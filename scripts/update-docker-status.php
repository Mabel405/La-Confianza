#!/usr/bin/env php
<?php

declare(strict_types=1);

$projectRoot = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');

if ($projectRoot === false) {
    fwrite(STDERR, "No se pudo resolver la ruta del proyecto.\n");
    exit(1);
}

$outputFile = $projectRoot . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'monitor' . DIRECTORY_SEPARATOR . 'docker.json';
$outputDir = dirname($outputFile);

if (! is_dir($outputDir) && ! mkdir($outputDir, 0755, true) && ! is_dir($outputDir)) {
    fwrite(STDERR, "No se pudo crear el directorio de monitor.\n");
    exit(1);
}

$timestamp = date('Y-m-d H:i:s');
$command = 'docker ps --format "{{.Names}}|{{.Status}}" 2>&1';
$rawOutput = shell_exec($command);

$snapshot = [
    'available' => false,
    'label' => 'No disponible',
    'status' => 'neutral',
    'updated_at' => $timestamp,
    'containers' => [],
    'raw' => null,
];

if (is_string($rawOutput)) {
    $trimmed = trim($rawOutput);
    $snapshot['raw'] = $trimmed !== '' ? $trimmed : null;

    $lower = strtolower($trimmed);
    if (
        $trimmed !== '' &&
        ! str_contains($lower, 'docker: not found') &&
        ! str_contains($lower, 'command not found') &&
        ! str_contains($lower, 'permission denied')
    ) {
        $containers = [];

        foreach (array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $trimmed) ?: [])) as $line) {
            [$name, $status] = array_pad(explode('|', $line, 2), 2, '');
            $containers[] = [
                'name' => trim($name),
                'status' => trim($status),
            ];
        }

        $snapshot['available'] = true;
        $snapshot['label'] = 'Running: ' . count($containers);
        $snapshot['status'] = count($containers) > 0 ? 'success' : 'warning';
        $snapshot['containers'] = $containers;
    }
}

$encoded = json_encode($snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

if ($encoded === false) {
    fwrite(STDERR, "No se pudo serializar el JSON.\n");
    exit(1);
}

if (file_put_contents($outputFile, $encoded . PHP_EOL, LOCK_EX) === false) {
    fwrite(STDERR, "No se pudo escribir el archivo de estado.\n");
    exit(1);
}

echo "Docker snapshot actualizado en {$outputFile}\n";
