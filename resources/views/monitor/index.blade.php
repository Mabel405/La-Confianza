<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NOC en Vivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        :root {
            --bg: #07111f;
            --panel: rgba(11, 21, 38, 0.82);
            --panel-strong: #0b1526;
            --line: rgba(148, 163, 184, 0.18);
            --text: #e5eefc;
            --muted: #8fa3c7;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --accent: #7c83fd;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(124, 131, 253, 0.22), transparent 28%),
                radial-gradient(circle at top right, rgba(34, 197, 94, 0.14), transparent 24%),
                linear-gradient(180deg, #020611 0%, #07111f 60%, #030712 100%);
            color: var(--text);
        }

        .hero {
            border: 1px solid var(--line);
            background: linear-gradient(135deg, rgba(124, 131, 253, 0.14), rgba(15, 23, 42, 0.88));
            backdrop-filter: blur(12px);
            border-radius: 28px;
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.35);
        }

        .glass {
            border: 1px solid var(--line);
            background: var(--panel);
            backdrop-filter: blur(12px);
            border-radius: 22px;
            box-shadow: 0 18px 44px rgba(0, 0, 0, 0.24);
        }

        .metric-value {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .metric-label {
            color: var(--muted);
            font-size: 0.92rem;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .status-success { background: var(--success); }
        .status-warning { background: var(--warning); }
        .status-danger { background: var(--danger); }
        .status-neutral { background: #94a3b8; }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.04);
        }

        .log-box {
            max-height: 360px;
            overflow: auto;
            white-space: pre-wrap;
            word-break: break-word;
            font-size: 0.84rem;
            line-height: 1.45;
            color: #cbd5e1;
            background: #020817;
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.15);
            padding: 1rem;
        }

        .small-muted {
            color: var(--muted);
            font-size: 0.85rem;
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        canvas {
            max-height: 260px;
        }
    </style>
</head>
<body>
<div class="container-fluid py-4 px-3 px-lg-4">
    <div class="hero p-4 p-lg-5 mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-end">
            <div>
                <div class="pill mb-3">
                    <span class="status-dot status-success"></span>
                    MONITOR NOC EN VIVO
                </div>
                <h1 class="display-6 fw-bold mb-2">Dashboard de Observabilidad</h1>
                <p class="mb-0 text-white-50">
                    Estado del EC2, Docker, MySQL, recursos del sistema y logs actualizandose cada 5 segundos.
                </p>
            </div>
            <div class="text-lg-end">
                <div class="small-muted">Ultima actualizacion</div>
                <div id="updatedAt" class="fs-5 fw-semibold">{{ $metrics['updated_at'] }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-md-6 col-xxl-3">
            <div class="glass p-3 h-100">
                <div class="metric-label mb-1">Servidor</div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div id="serverStatus" class="fw-bold fs-4">Online</div>
                        <div id="serverInfo" class="small-muted">{{ $metrics['server']['hostname'] ?? 'unknown' }}</div>
                    </div>
                    <span id="serverDot" class="pill"><span class="status-dot status-success"></span>Activo</span>
                </div>
                <div id="serverUptime" class="small-muted mt-3">{{ $metrics['server']['uptime'] ?? 'N/A' }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xxl-3">
            <div class="glass p-3 h-100">
                <div class="metric-label mb-1">Base de datos</div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div id="databaseStatus" class="fw-bold fs-4">{{ $metrics['database']['label'] ?? 'N/A' }}</div>
                        <div class="small-muted">Tiempo de respuesta</div>
                    </div>
                    <span id="databaseDot" class="pill"><span class="status-dot status-success"></span>Online</span>
                </div>
                <div id="databaseResponse" class="metric-label mt-3">{{ $metrics['response_time_ms'] ?? 'N/A' }} ms</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xxl-3">
            <div class="glass p-3 h-100">
                <div class="metric-label mb-1">Docker</div>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                <div id="dockerStatus" class="fw-bold fs-4">{{ $metrics['docker']['label'] ?? 'N/A' }}</div>
                        <div class="small-muted">Contenedores visibles</div>
                    </div>
                    <span id="dockerDot" class="pill"><span class="status-dot status-success"></span>OK</span>
                </div>
                <div id="dockerHint" class="small-muted mt-3">Listo para inspeccion</div>
                <div id="dockerUpdatedAt" class="small-muted mt-2">{{ $metrics['docker']['updated_at'] ?? 'Sin sincronizar' }}</div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xxl-3">
            <div class="glass p-3 h-100">
                <div class="metric-label mb-1">Sesiones activas</div>
                <div id="sessionsValue" class="metric-value">{{ $metrics['sessions_active'] ?? 'N/A' }}</div>
                <div class="small-muted">Usuarios autenticados recientes</div>
                <div class="metric-label mt-3">Errores recientes: <span id="errorsCount">{{ $metrics['errors_count'] ?? 0 }}</span></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-4">
            <div class="glass p-3 h-100">
                <div class="section-title mb-3">CPU</div>
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div class="metric-value" id="cpuValue">{{ $metrics['cpu']['label'] ?? 'N/A' }}</div>
                    <div class="small-muted">Load / uso estimado</div>
                </div>
                <canvas id="cpuChart"></canvas>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="glass p-3 h-100">
                <div class="section-title mb-3">RAM</div>
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div class="metric-value" id="memoryValue">{{ $metrics['memory']['label'] ?? 'N/A' }}</div>
                    <div class="small-muted" id="memoryDetails">{{ $metrics['memory']['used'] ?? 'N/A' }} / {{ $metrics['memory']['total'] ?? 'N/A' }}</div>
                </div>
                <canvas id="memoryChart"></canvas>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="glass p-3 h-100">
                <div class="section-title mb-3">Disco</div>
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div class="metric-value" id="diskValue">{{ $metrics['disk']['label'] ?? 'N/A' }}</div>
                    <div class="small-muted" id="diskDetails">{{ $metrics['disk']['used'] ?? 'N/A' }} / {{ $metrics['disk']['total'] ?? 'N/A' }}</div>
                </div>
                <canvas id="diskChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-xl-5">
            <div class="glass p-3 h-100">
                <div class="section-title mb-3">Contenedores Docker</div>
                <div id="dockerContainers" class="d-grid gap-2">
                    @foreach(($metrics['docker']['containers'] ?? []) as $container)
                        <div class="d-flex justify-content-between align-items-center border border-white border-opacity-10 rounded-3 px-3 py-2">
                            <span class="fw-semibold">{{ $container['name'] }}</span>
                            <span class="small-muted">{{ $container['status'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-7">
            <div class="glass p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
                    <div>
                        <div class="section-title">Registros de Laravel</div>
                        <div id="logFileName" class="small-muted">{{ $metrics['log_file'] ?? 'Sin archivo de logs' }}</div>
                    </div>
                    <a href="{{ route('monitor.logs.download') }}" class="btn btn-outline-light btn-sm">Descargar registros</a>
                </div>
                <div id="logsPanel" class="log-box">{{ implode("\n", $metrics['logs'] ?? []) ?: 'Sin errores recientes.' }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-xl-6">
            <div class="glass p-3 h-100">
                <div class="section-title mb-3">Despliegue</div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div id="deployStatus" class="fw-bold fs-4">{{ $metrics['deploy']['label'] ?? 'Sin despliegue registrado' }}</div>
                        <div class="small-muted">Output del ultimo deploy en EC2</div>
                    </div>
                    <span id="deployDot" class="pill"><span class="status-dot status-neutral"></span>Deploy</span>
                </div>
                <div id="deployUpdatedAt" class="small-muted mb-3">{{ $metrics['deploy']['updated_at'] ?? 'Sin sincronizar' }}</div>
                <div id="deployLogs" class="log-box">{{ implode("\n", $metrics['deploy']['logs'] ?? []) ?: 'Sin logs de despliegue.' }}</div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="glass p-3 h-100">
                <div class="section-title mb-3">Playwright</div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                <div id="playwrightStatus" class="fw-bold fs-4">{{ $metrics['playwright']['label'] ?? 'Ultimo reporte de CI no encontrado' }}</div>
                        <div class="small-muted">Resumen de la ultima corrida E2E</div>
                    </div>
                    <span id="playwrightDot" class="pill"><span class="status-dot status-neutral"></span>E2E</span>
                </div>
                <div id="playwrightUpdatedAt" class="small-muted mb-3">{{ $metrics['playwright']['updated_at'] ?? 'Sin sincronizar' }}</div>
                <div id="playwrightStats" class="small-muted mb-3">
                    Pasados: {{ $metrics['playwright']['passed'] ?? 'N/A' }} |
                    Fallidos: {{ $metrics['playwright']['failed'] ?? 'N/A' }} |
                    Omitidos: {{ $metrics['playwright']['skipped'] ?? 'N/A' }}
                </div>
                <a id="playwrightReportLink"
                   href="{{ !empty($metrics['playwright']['report_url']) ? $metrics['playwright']['report_url'] : '#' }}"
                   class="btn btn-light fw-semibold w-100 {{ empty($metrics['playwright']['report_url']) ? 'disabled' : '' }}"
                   {{ empty($metrics['playwright']['report_url']) ? 'aria-disabled=true tabindex=-1' : '' }}>
                    Ver reporte Playwright
                </a>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-lg-4">
            <div class="glass p-3 h-100">
                <div class="metric-label mb-1">Tiempo de respuesta BD</div>
                <div id="responseTime" class="metric-value">{{ $metrics['response_time_ms'] ?? 'N/A' }} ms</div>
                <div class="small-muted">Consulta simple `select 1`</div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="glass p-3 h-100">
                <div class="metric-label mb-1">Backup</div>
                <div id="backupStatus" class="metric-value">{{ $metrics['backup_status']['label'] ?? 'No configurado' }}</div>
                <div class="small-muted mb-3">Backup manual de MySQL desde el propio Ubuntu</div>
                <button id="backupButton" type="button" class="btn btn-light fw-semibold w-100">
                    Generar backup ahora
                </button>
                <a id="downloadBackupLink"
                   href="{{ !empty($metrics['backup_status']['file_name']) ? route('monitor.backup.download') : '#' }}"
                   class="btn btn-outline-light fw-semibold w-100 mt-2 {{ empty($metrics['backup_status']['file_name']) ? 'disabled' : '' }}"
                   {{ empty($metrics['backup_status']['file_name']) ? 'aria-disabled=true tabindex=-1' : '' }}>
                    Descargar último backup
                </a>
                <div id="backupFeedback" class="small-muted mt-3"></div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="glass p-3 h-100">
                <div class="metric-label mb-1">Host</div>
                <div id="hostName" class="metric-value">{{ $metrics['server']['hostname'] ?? 'unknown' }}</div>
                <div id="hostOs" class="small-muted">{{ $metrics['server']['os'] ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
</div>

<script>
    const initialMetrics = @json($metrics);
    const history = {
        labels: [],
        cpu: [],
        memory: [],
        disk: [],
    };

    const statusMap = {
        success: 'status-success',
        warning: 'status-warning',
        danger: 'status-danger',
        neutral: 'status-neutral',
    };

    const chartConfig = (label, color) => ({
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label,
                data: [],
                borderColor: color,
                backgroundColor: color + '22',
                pointRadius: 2,
                tension: 0.35,
                fill: true,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 100,
                    ticks: { color: '#8fa3c7' },
                    grid: { color: 'rgba(148, 163, 184, 0.12)' },
                },
                x: {
                    ticks: { color: '#8fa3c7' },
                    grid: { color: 'rgba(148, 163, 184, 0.08)' },
                }
            },
            plugins: {
                legend: {
                    labels: { color: '#e5eefc' }
                }
            }
        }
    });

    const cpuChart = new Chart(document.getElementById('cpuChart'), chartConfig('CPU %', '#7c83fd'));
    const memoryChart = new Chart(document.getElementById('memoryChart'), chartConfig('RAM %', '#22c55e'));
    const diskChart = new Chart(document.getElementById('diskChart'), chartConfig('DISK %', '#f59e0b'));

    function setStatusDot(elementId, status, label) {
        const element = document.getElementById(elementId);
        if (!element) return;

        const className = statusMap[status] || 'status-neutral';
        element.innerHTML = `<span class="status-dot ${className}"></span>${label}`;
    }

    function pushMetric(chart, value, label, key) {
        if (typeof value !== 'number') return;

        history.labels.push(label);
        history[key].push(value);

        if (history.labels.length > 12) {
            history.labels.shift();
            history[key].shift();
        }

        chart.data.labels = history.labels;
        chart.data.datasets[0].data = history[key];
        chart.update();
    }

    function renderContainers(containers) {
        const box = document.getElementById('dockerContainers');
        box.innerHTML = '';

        if (!containers || containers.length === 0) {
            box.innerHTML = '<div class="small-muted">Sin contenedores visibles o Docker no disponible.</div>';
            return;
        }

        containers.forEach((container) => {
            const row = document.createElement('div');
            row.className = 'd-flex justify-content-between align-items-center border border-white border-opacity-10 rounded-3 px-3 py-2';
            row.innerHTML = `<span class="fw-semibold"></span><span class="small-muted"></span>`;
            row.querySelector('span:first-child').textContent = container.name;
            row.querySelector('span:last-child').textContent = container.status;
            box.appendChild(row);
        });
    }

    function renderLogs(lines) {
        const box = document.getElementById('logsPanel');
        if (!lines || lines.length === 0) {
            box.textContent = 'Sin errores recientes.';
            return;
        }
        box.textContent = lines.join('\n');
    }

    function renderMetrics(data) {
        document.getElementById('updatedAt').textContent = data.updated_at || '-';

        document.getElementById('serverStatus').textContent = data.server?.hostname ? 'Online' : 'N/A';
        document.getElementById('serverInfo').textContent = data.server?.hostname || 'unknown';
        document.getElementById('serverUptime').textContent = data.server?.uptime || 'N/A';
        setStatusDot('serverDot', 'success', data.server?.hostname ? 'Activo' : 'N/A');

        document.getElementById('databaseStatus').textContent = data.database?.label || 'N/A';
        document.getElementById('databaseResponse').textContent = data.response_time_ms !== null && data.response_time_ms !== undefined ? `${data.response_time_ms} ms` : 'N/A';
        setStatusDot('databaseDot', data.database?.status || 'neutral', data.database?.label || 'N/A');

        document.getElementById('dockerStatus').textContent = data.docker?.label || 'N/A';
        document.getElementById('dockerHint').textContent = data.docker?.available ? 'Contenedores detectados por Docker' : 'Docker no disponible o sin permisos';
        document.getElementById('dockerUpdatedAt').textContent = data.docker?.updated_at || 'Sin sincronizar';
        setStatusDot('dockerDot', data.docker?.status || 'neutral', data.docker?.label || 'N/A');
        renderContainers(data.docker?.containers || []);

        document.getElementById('cpuValue').textContent = data.cpu?.label || 'N/A';
        document.getElementById('memoryValue').textContent = data.memory?.label || 'N/A';
        document.getElementById('memoryDetails').textContent = `${data.memory?.used || 'N/A'} / ${data.memory?.total || 'N/A'}`;
        document.getElementById('diskValue').textContent = data.disk?.label || 'N/A';
        document.getElementById('diskDetails').textContent = `${data.disk?.used || 'N/A'} / ${data.disk?.total || 'N/A'}`;

        document.getElementById('responseTime').textContent = data.response_time_ms !== null && data.response_time_ms !== undefined ? `${data.response_time_ms} ms` : 'N/A';
        document.getElementById('backupStatus').textContent = data.backup_status?.label || 'No configurado';
        document.getElementById('backupFeedback').textContent = data.backup_status?.file_name
            ? `Archivo: ${data.backup_status.file_name}${data.backup_status.size ? ' · ' + data.backup_status.size : ''}`
            : 'Sin backups previos.';
        const downloadLink = document.getElementById('downloadBackupLink');
        const hasBackup = Boolean(data.backup_status?.file_name);
        downloadLink.href = hasBackup ? '{{ route('monitor.backup.download') }}' : '#';
        downloadLink.classList.toggle('disabled', !hasBackup);
        downloadLink.setAttribute('aria-disabled', String(!hasBackup));
        if (!hasBackup) {
            downloadLink.setAttribute('tabindex', '-1');
        } else {
            downloadLink.removeAttribute('tabindex');
        }
        document.getElementById('hostName').textContent = data.server?.hostname || 'unknown';
        document.getElementById('hostOs').textContent = data.server?.os || 'N/A';
        document.getElementById('sessionsValue').textContent = data.sessions_active === null || data.sessions_active === undefined ? 'N/A' : data.sessions_active;
        document.getElementById('errorsCount').textContent = data.errors_count ?? 0;
        document.getElementById('logFileName').textContent = data.log_file || 'Sin archivo de logs';
        renderLogs(data.logs || []);
        document.getElementById('deployStatus').textContent = data.deploy?.label || 'Sin despliegue registrado';
        document.getElementById('deployUpdatedAt').textContent = data.deploy?.updated_at || 'Sin sincronizar';
        setStatusDot('deployDot', data.deploy?.status || 'neutral', data.deploy?.available ? 'OK' : 'Deploy');
        document.getElementById('deployLogs').textContent = (data.deploy?.logs || []).join('\n') || 'Sin logs de despliegue.';

        document.getElementById('playwrightStatus').textContent = data.playwright?.label || 'Ultimo reporte de CI no encontrado';
        document.getElementById('playwrightUpdatedAt').textContent = data.playwright?.updated_at || 'Sin sincronizar';
        document.getElementById('playwrightStats').textContent = `Pasados: ${data.playwright?.passed ?? 'N/A'} | Fallidos: ${data.playwright?.failed ?? 'N/A'} | Omitidos: ${data.playwright?.skipped ?? 'N/A'}`;
        setStatusDot('playwrightDot', data.playwright?.status || 'neutral', data.playwright?.available ? 'OK' : 'E2E');
        const reportLink = document.getElementById('playwrightReportLink');
        const reportUrl = data.playwright?.report_url || '#';
        reportLink.href = reportUrl;
        reportLink.classList.toggle('disabled', reportUrl === '#');
        reportLink.setAttribute('aria-disabled', String(reportUrl === '#'));
        if (reportUrl === '#') {
            reportLink.setAttribute('tabindex', '-1');
        } else {
            reportLink.removeAttribute('tabindex');
        }

        pushMetric(cpuChart, data.cpu?.usage, data.updated_at, 'cpu');
        pushMetric(memoryChart, data.memory?.usage, data.updated_at, 'memory');
        pushMetric(diskChart, data.disk?.usage, data.updated_at, 'disk');
    }

    async function runBackup() {
        const button = document.getElementById('backupButton');
        const feedback = document.getElementById('backupFeedback');

        button.disabled = true;
        button.textContent = 'Generando...';
        feedback.textContent = 'Procesando backup...';

        try {
            const response = await fetch('/dashboard/monitor/backup', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({}),
            });

            const data = await response.json();

            if (!response.ok || !data.ok) {
                throw new Error(data.message || 'No se pudo generar el backup.');
            }

            feedback.textContent = data.message;
            await refreshMonitor();
        } catch (error) {
            feedback.textContent = error.message || 'Falló el backup.';
        } finally {
            button.disabled = false;
            button.textContent = 'Generar backup ahora';
        }
    }

    async function refreshMonitor() {
        try {
            const response = await fetch('/dashboard/monitor/data', {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) {
                throw new Error('Monitor request failed');
            }
            const data = await response.json();
            renderMetrics(data);
        } catch (error) {
            console.error(error);
        }
    }

    renderMetrics(initialMetrics);
    const backupButton = document.getElementById('backupButton');
    const downloadBackupLink = document.getElementById('downloadBackupLink');

    if (backupButton) {
        backupButton.textContent = 'Descargar último backup';
        backupButton.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopImmediatePropagation();

            if (downloadBackupLink && downloadBackupLink.href && downloadBackupLink.href !== '#') {
                window.location.href = downloadBackupLink.href;
            }
        }, true);
    }

    document.getElementById('backupButton').addEventListener('click', runBackup);
    setInterval(refreshMonitor, 5000);
</script>
</body>
</html>
