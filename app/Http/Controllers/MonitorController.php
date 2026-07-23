<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MonitorController extends Controller
{
    public function index()
    {
        return view('monitor.index', [
            'metrics' => $this->snapshot(),
        ]);
    }

    public function data(): JsonResponse
    {
        return response()->json($this->snapshot());
    }

    public function backup(Request $request): JsonResponse
    {
        $backupDir = $this->backupDirectory();
        $this->ensureDirectory($backupDir);

        $timestamp = now()->format('Y-m-d_H-i-s');
        $fileName = 'dbsistemaabarrote_'.$timestamp.'.sql';
        $backupPath = $backupDir.DIRECTORY_SEPARATOR.$fileName;

        $connection = config('database.connections.mysql');
        $database = $connection['database'] ?? env('DB_DATABASE', 'dbsistemaabarrote');
        $user = $connection['username'] ?? env('DB_USERNAME', 'root');
        $password = $connection['password'] ?? env('DB_PASSWORD', '');
        $host = $connection['host'] ?? env('DB_HOST', '127.0.0.1');
        $port = $connection['port'] ?? env('DB_PORT', '3306');

        $defaultsFile = tempnam(sys_get_temp_dir(), 'mysql_backup_');

        if ($defaultsFile === false) {
            return response()->json([
                'ok' => false,
                'message' => 'No se pudo preparar el archivo temporal de credenciales.',
            ], 500);
        }

        $defaultsContent = "[client]\n".
            "user={$user}\n".
            "password={$password}\n".
            "host={$host}\n".
            "port={$port}\n";

        File::put($defaultsFile, $defaultsContent);

        try {
            $command = sprintf(
                'mysqldump --defaults-extra-file=%s --single-transaction --routines --triggers --events %s > %s 2>&1',
                escapeshellarg($defaultsFile),
                escapeshellarg($database),
                escapeshellarg($backupPath)
            );

            $output = $this->runCommand($command);

            if (! file_exists($backupPath) || filesize($backupPath) === 0) {
                @unlink($backupPath);

                return response()->json([
                    'ok' => false,
                    'message' => 'El backup no se generó correctamente.',
                    'output' => $output,
                    'backup_status' => $this->backupStatus(),
                ], 500);
            }

            return response()->json([
                'ok' => true,
                'message' => 'Backup generado correctamente.',
                'output' => $output,
                'backup_status' => $this->backupStatus(),
            ]);
        } finally {
            @unlink($defaultsFile);
        }
    }

    private function snapshot(): array
    {
        $database = $this->databaseStatus();
        $disk = $this->diskStatus();
        $memory = $this->memoryStatus();
        $cpu = $this->cpuStatus();
        $server = $this->serverStatus();

        return [
            'server' => $server,
            'database' => $database,
            'docker' => $this->dockerStatus(),
            'cpu' => $cpu,
            'memory' => $memory,
            'disk' => $disk,
            'response_time_ms' => $database['response_time_ms'],
            'logs' => $this->tailLogs(),
            'errors_count' => $this->errorCount(),
            'sessions_active' => $this->activeSessions(),
            'backup_status' => $this->backupStatus(),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ];
    }

    private function serverStatus(): array
    {
        return [
            'hostname' => gethostname() ?: 'unknown',
            'os' => PHP_OS_FAMILY,
            'uptime' => $this->runCommand('uptime -p') ?: $this->uptimeFromProc(),
            'load_average' => function_exists('sys_getloadavg') ? sys_getloadavg() : null,
        ];
    }

    private function cpuStatus(): array
    {
        $usage = null;
        $top = $this->runCommand("top -bn1 | grep 'Cpu(s)'");

        if ($top && preg_match('/([\d\.]+)\s*us,\s*([\d\.]+)\s*sy/', $top, $matches)) {
            $usage = round(((float) $matches[1]) + ((float) $matches[2]), 1);
        } elseif (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg()[0] ?? null;
            if ($load !== null) {
                $cores = (int) trim($this->runCommand('nproc') ?: '1');
                $cores = max($cores, 1);
                $usage = round(min(100, ($load / $cores) * 100), 1);
            }
        }

        return [
            'usage' => $usage,
            'label' => $usage === null ? 'N/A' : $usage.'%',
            'status' => $this->statusColor($usage, 75, 90),
        ];
    }

    private function memoryStatus(): array
    {
        $meminfo = $this->parseMemInfo();

        if (! isset($meminfo['MemTotal'], $meminfo['MemAvailable'])) {
            return [
                'total' => null,
                'used' => null,
                'free' => null,
                'usage' => null,
                'label' => 'N/A',
                'status' => 'neutral',
            ];
        }

        $total = (int) $meminfo['MemTotal'];
        $available = (int) $meminfo['MemAvailable'];
        $used = max(0, $total - $available);
        $usage = $total > 0 ? round(($used / $total) * 100, 1) : null;

        return [
            'total' => $this->formatBytes($total * 1024),
            'used' => $this->formatBytes($used * 1024),
            'free' => $this->formatBytes($available * 1024),
            'usage' => $usage,
            'label' => $usage === null ? 'N/A' : $usage.'%',
            'status' => $this->statusColor($usage, 75, 90),
        ];
    }

    private function diskStatus(): array
    {
        $root = '/';
        $total = @disk_total_space($root);
        $free = @disk_free_space($root);

        if ($total === false || $free === false || $total <= 0) {
            return [
                'total' => null,
                'used' => null,
                'free' => null,
                'usage' => null,
                'label' => 'N/A',
                'status' => 'neutral',
            ];
        }

        $used = $total - $free;
        $usage = round(($used / $total) * 100, 1);

        return [
            'total' => $this->formatBytes($total),
            'used' => $this->formatBytes($used),
            'free' => $this->formatBytes($free),
            'usage' => $usage,
            'label' => $usage.'%',
            'status' => $this->statusColor($usage, 75, 90),
        ];
    }

    private function databaseStatus(): array
    {
        $start = microtime(true);

        try {
            DB::connection()->getPdo();
            DB::select('select 1');

            $elapsed = round((microtime(true) - $start) * 1000, 1);

            return [
                'online' => true,
                'label' => 'Online',
                'response_time_ms' => $elapsed,
                'status' => $this->statusColor($elapsed, 150, 500),
            ];
        } catch (\Throwable $e) {
            return [
                'online' => false,
                'label' => 'Offline',
                'response_time_ms' => null,
                'status' => 'danger',
            ];
        }
    }

    private function dockerStatus(): array
    {
        $output = $this->runCommand('docker ps --format "{{.Names}}|{{.Status}}" 2>&1');

        if (! $output) {
            return [
                'available' => false,
                'label' => 'No disponible',
                'containers' => [],
                'status' => 'neutral',
            ];
        }

        if (str_contains(strtolower($output), 'permission denied') || str_contains(strtolower($output), 'command not found')) {
            return [
                'available' => false,
                'label' => 'No disponible',
                'containers' => [],
                'status' => 'neutral',
            ];
        }

        $containers = collect(explode("\n", trim($output)))
            ->filter()
            ->map(function ($line) {
                [$name, $status] = array_pad(explode('|', $line, 2), 2, '');

                return [
                    'name' => trim($name),
                    'status' => trim($status),
                ];
            })
            ->values()
            ->all();

        return [
            'available' => true,
            'label' => 'Running: '.count($containers),
            'containers' => $containers,
            'status' => count($containers) > 0 ? 'success' : 'warning',
        ];
    }

    private function tailLogs(): array
    {
        $path = storage_path('logs/laravel.log');

        if (! file_exists($path)) {
            return [];
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return array_slice($lines ?: [], -12);
    }

    private function errorCount(): int
    {
        return collect($this->tailLogs())
            ->filter(fn ($line) => str_contains(strtoupper($line), 'ERROR') || str_contains(strtoupper($line), 'CRITICAL') || str_contains(strtoupper($line), 'EXCEPTION'))
            ->count();
    }

    private function activeSessions(): ?int
    {
        $driver = config('session.driver');

        try {
            if ($driver === 'file') {
                $path = storage_path('framework/sessions');

                if (! is_dir($path)) {
                    return null;
                }

                $files = glob($path . DIRECTORY_SEPARATOR . '*') ?: [];
                $threshold = time() - (config('session.lifetime') * 60);

                return collect($files)
                    ->filter(fn ($file) => filemtime($file) !== false && filemtime($file) >= $threshold)
                    ->count();
            }

            if ($driver === 'database') {
                return DB::table(config('session.table', 'sessions'))
                    ->where('last_activity', '>=', now()->subMinutes((int) config('session.lifetime', 120))->timestamp)
                    ->count();
            }
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    }

    private function backupStatus(): array
    {
        $latest = $this->latestBackupSnapshot();

        if ($latest === null) {
            return [
                'label' => 'No configurado',
                'status' => 'neutral',
                'last_backup_at' => null,
                'file_name' => null,
                'size' => null,
            ];
        }

        return [
            'label' => 'Último backup: '.$latest['last_backup_at'],
            'status' => 'success',
            'last_backup_at' => $latest['last_backup_at'],
            'file_name' => $latest['file_name'],
            'size' => $latest['size'],
        ];
    }

    private function backupDirectory(): string
    {
        return storage_path('app/backups/mysql');
    }

    private function latestBackupSnapshot(): ?array
    {
        $directory = $this->backupDirectory();

        if (! is_dir($directory)) {
            return null;
        }

        $files = collect(glob($directory.DIRECTORY_SEPARATOR.'*.sql') ?: [])
            ->filter(fn ($file) => is_file($file))
            ->map(fn ($file) => [
                'path' => $file,
                'mtime' => filemtime($file) ?: 0,
                'size' => filesize($file) ?: 0,
            ])
            ->sortByDesc('mtime')
            ->values();

        if ($files->isEmpty()) {
            return null;
        }

        $latest = $files->first();

        return [
            'file_name' => basename($latest['path']),
            'last_backup_at' => now()->setTimestamp($latest['mtime'])->format('Y-m-d H:i:s'),
            'size' => $this->formatBytes($latest['size']),
        ];
    }

    private function ensureDirectory(string $directory): void
    {
        if (! is_dir($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }

    private function parseMemInfo(): array
    {
        $result = [];
        $path = '/proc/meminfo';

        if (! is_readable($path)) {
            return $result;
        }

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            if (preg_match('/^([^:]+):\s+(\d+)/', $line, $matches)) {
                $result[$matches[1]] = (int) $matches[2];
            }
        }

        return $result;
    }

    private function uptimeFromProc(): ?string
    {
        $path = '/proc/uptime';

        if (! is_readable($path)) {
            return null;
        }

        $content = trim(file_get_contents($path));
        if ($content === '') {
            return null;
        }

        $seconds = (int) floor((float) explode(' ', $content)[0]);
        $days = intdiv($seconds, 86400);
        $hours = intdiv($seconds % 86400, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        $parts = [];
        if ($days > 0) {
            $parts[] = $days.'d';
        }
        if ($hours > 0) {
            $parts[] = $hours.'h';
        }
        if ($minutes > 0 || empty($parts)) {
            $parts[] = $minutes.'m';
        }

        return 'up '.implode(' ', $parts);
    }

    private function statusColor(?float $value, float $warning, float $critical): string
    {
        if ($value === null) {
            return 'neutral';
        }

        if ($value >= $critical) {
            return 'danger';
        }

        if ($value >= $warning) {
            return 'warning';
        }

        return 'success';
    }

    private function formatBytes(int|float $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $size = (float) $bytes;
        $index = 0;

        while ($size >= 1024 && $index < count($units) - 1) {
            $size /= 1024;
            $index++;
        }

        return round($size, 1).' '.$units[$index];
    }

    private function runCommand(string $command): ?string
    {
        if (! function_exists('shell_exec')) {
            return null;
        }

        $output = @shell_exec($command);

        if (! is_string($output)) {
            return null;
        }

        $output = trim($output);

        return $output === '' ? null : $output;
    }
}
