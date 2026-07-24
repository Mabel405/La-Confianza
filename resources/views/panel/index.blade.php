@extends('template')

@section('title','Panel')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet"/> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    
    :root {
        --primary: #1e293b;
        --secondary: #334155;
        --accent: #0f172a;
        --success: #059669;
        --info: #2563eb;
        --warning: #d97706;
        --danger: #dc2626;
        --light: #f8fafc;
        --dark: #020617;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
    }

    body {
        background-color: var(--gray-100);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .container-fluid {
        padding: 2rem 2rem;
    }

    .card {
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        background: white;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border-color: var(--gray-300);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-footer {
        background: var(--gray-100);
        border-top: 1px solid var(--gray-200);
        padding: 1rem 1.5rem;
    }

    .icon-container {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--gray-100);
        border-radius: 10px;
        color: var(--gray-600);
    }

    .icon-container i {
        font-size: 1.5rem;
        color: var(--gray-600);
    }

    /* Tipografía corporativa */
    .page-title {
        font-size: 2rem;
        font-weight: 600;
        color: var(--dark);
        letter-spacing: -0.02em;
        margin-bottom: 0.5rem;
    }

    .lead {
        font-size: 1rem;
        font-weight: 400;
        color: var(--gray-500);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 1.5rem;
        letter-spacing: -0.01em;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-700);
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0.25rem;
    }

    .card-text {
        font-size: 0.875rem;
        color: var(--gray-500);
        line-height: 1.5;
    }

    /* Contadores minimalistas */
    .counter-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    .counter-label {
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }


    .card-footer span {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-600);
    }

    .card-footer a {
        color: var(--gray-600);
        transition: color 0.2s;
    }

    .card-footer a:hover {
        color: var(--dark);
    }


    .card-clientes { border-top: 3px solid var(--primary); }
    .card-categorias { border-top: 3px solid var(--info); }
    .card-compras { border-top: 3px solid var(--success); }
    .card-marcas { border-top: 3px solid var(--danger); }
    .card-presentaciones { border-top: 3px solid var(--warning); }
    .card-productos { border-top: 3px solid var(--accent); }
    .card-proveedores { border-top: 3px solid var(--gray-600); }
    .card-usuarios { border-top: 3px solid var(--secondary); }
    .card-ventas { border-top: 3px solid var(--success); }

    /* Estadísticas adicionales - estilo dashboard */
    .stat-box {
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: 10px;
        padding: 1.5rem;
        transition: all 0.2s;
    }

    .stat-box:hover {
        border-color: var(--gray-300);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--dark);
        line-height: 1.2;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    /* Header de sección estadísticas */
    .card-header {
        background: white;
        border-bottom: 1px solid var(--gray-200);
        padding: 1.25rem 1.5rem;
    }

    .card-header h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--dark);
    }

    .card-header i {
        color: var(--gray-400);
    }

    /* Sweet Alert personalizado */
    .swal2-popup {
        font-family: inherit;
        border-radius: 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 1.75rem;
        }
        
        .counter-number {
            font-size: 1.75rem;
        }
    }

    /* Utilidades */
    .text-muted {
        color: var(--gray-500) !important;
    }

    .bg-white {
        background: white !important;
    }

    /* Separador sutil */
    hr {
        border-color: var(--gray-200);
        opacity: 0.5;
    }
</style>
@endpush

@section('content')

@if(session('success'))
<script>
    let message = "{{ session('success') }}";
    Swal.fire({
        title: message,
        icon: 'success',
        confirmButtonColor: 'var(--primary)',
        showClass: {
            popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        },
        timer: 3000,
        timerProgressBar: true
    })
</script>
@endif

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Panel de Control</h1>
            <p class="lead mb-0">Sistema de Gestión Administrativa</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            @role('administrador')
                <a href="{{ route('monitor.index') }}" class="btn btn-dark btn-sm px-3 py-2" style="border-radius: 10px;">
                    <i class="fas fa-radar me-2"></i>Monitor NOC
                </a>
            @endrole
            <div class="text-muted">
                <i class="fas fa-calendar-alt me-2"></i>{{ now()->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <hr class="mb-4">

    @php
    use App\Models\Cliente;
    use App\Models\Categoria;
    use App\Models\Compra;
    use App\Models\Marca;
    use App\Models\Presentacione;
    use App\Models\Producto;
    use App\Models\Proveedore;
    use App\Models\User;
    use App\Models\Venta;

    // CLIENTES (estado está en persona)
    $clientes = Cliente::whereHas('persona', function($q){
        $q->where('estado',1);
    })->count();

    $categorias = Categoria::whereHas('caracteristica', function($q){
    $q->where('estado', 1);
    })->count();

    $marcas = Marca::whereHas('caracteristica', function($q){
    $q->where('estado', 1);
    })->count();

    $presentaciones = Presentacione::whereHas('caracteristica', function($q){
    $q->where('estado', 1);
    })->count();

    $proveedores = Proveedore::whereHas('persona', function($q){
    $q->where('estado', 1);
    })->count();
    

    $productos = Producto::where('estado', 1)->count();

    $users = User::count();
    $ventas  = Venta::where('estado', 1)->count();
    $compras = Compra::where('estado', 1)->count();

    $ultimaVenta = Venta::latest()->first();
    $ultimoProducto = Producto::latest()->first();
    
    $ultimoCliente = Cliente::whereHas('persona', function($q){
        $q->where('estado',1);
    })->latest()->first();
    
    $ultimoProveedor = Proveedore::latest()->first();
    @endphp

    

    <div class="row g-4">
        <!-- Clientes -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-clientes h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-container"><i class="fa-solid fa-users"></i></div>
                        <div class="text-end">
                            <div class="counter-number">{{ $clientes }}</div>
                            <div class="counter-label">Total</div>
                        </div>
                    </div>
                    <h5 class="card-title">Clientes</h5>
                    <p class="card-text">Gestión de clientes registrados en el sistema</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Ver detalles</span>
                    <a class="stretched-link" href="{{ route('clientes.index') }}">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Categorías -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-categorias h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="icon-container"><i class="fa-solid fa-tags"></i></div>
                        <div class="text-end">
                            <div class="counter-number">{{ $categorias }}</div>
                            <div class="counter-label">Total</div>
                        </div>
                    </div>
                    <h5 class="card-title">Categorías</h5>
                    <p class="card-text">Clasificación de productos</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Ver detalles</span>
                    <a class="stretched-link" href="{{ route('categorias.index') }}">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Compras -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-compras h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="icon-container"><i class="fa-solid fa-cart-shopping"></i></div>
                        <div class="text-end">
                            <div class="counter-number">{{ $compras }}</div>
                            <div class="counter-label">Total</div>
                        </div>
                    </div>
                    <h5 class="card-title">Compras</h5>
                    <p class="card-text">Historial de compras</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Ver detalles</span>
                    <a class="stretched-link" href="{{ route('compras.index') }}">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Marcas -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-marcas h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="icon-container"><i class="fa-solid fa-bullhorn"></i></div>
                        <div class="text-end">
                            <div class="counter-number">{{ $marcas }}</div>
                            <div class="counter-label">Total</div>
                        </div>
                    </div>
                    <h5 class="card-title">Marcas</h5>
                    <p class="card-text">Fabricantes</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Ver detalles</span>
                    <a class="stretched-link" href="{{ route('marcas.index') }}">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Presentaciones -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-presentaciones h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="icon-container"><i class="fa-solid fa-box-open"></i></div>
                        <div class="text-end">
                            <div class="counter-number">{{ $presentaciones }}</div>
                            <div class="counter-label">Total</div>
                        </div>
                    </div>
                    <h5 class="card-title">Presentaciones</h5>
                    <p class="card-text">Formatos</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Ver detalles</span>
                    <a class="stretched-link" href="{{ route('presentaciones.index') }}">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Productos -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-productos h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="icon-container"><i class="fa-solid fa-boxes-stacked"></i></div>
                        <div class="text-end">
                            <div class="counter-number">{{ $productos }}</div>
                            <div class="counter-label">Total</div>
                        </div>
                    </div>
                    <h5 class="card-title">Productos</h5>
                    <p class="card-text">Inventario</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Ver detalles</span>
                    <a class="stretched-link" href="{{ route('productos.index') }}">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Proveedores -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-proveedores h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="icon-container"><i class="fa-solid fa-truck"></i></div>
                        <div class="text-end">
                            <div class="counter-number">{{ $proveedores }}</div>
                            <div class="counter-label">Total</div>
                        </div>
                    </div>
                    <h5 class="card-title">Proveedores</h5>
                    <p class="card-text">Socios comerciales</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Ver detalles</span>
                    <a class="stretched-link" href="{{ route('proveedores.index') }}">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Usuarios -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-usuarios h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="icon-container"><i class="fa-solid fa-users-gear"></i></div>
                        <div class="text-end">
                            <div class="counter-number">{{ $users }}</div>
                            <div class="counter-label">Total</div>
                        </div>
                    </div>
                    <h5 class="card-title">Usuarios</h5>
                    <p class="card-text">Accesos</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Ver detalles</span>
                    <a class="stretched-link" href="{{ route('users.index') }}">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Ventas -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-ventas h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="icon-container"><i class="fa-solid fa-chart-line"></i></div>
                        <div class="text-end">
                            <div class="counter-number">{{ $ventas }}</div>
                            <div class="counter-label">Total</div>
                        </div>
                    </div>
                    <h5 class="card-title">Ventas</h5>
                    <p class="card-text">Transacciones</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <span>Ver detalles</span>
                    <a class="stretched-link" href="{{ route('ventas.index') }}">
                        <i class="fas fa-arrow-right fa-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividad Reciente -->
    @php
    // Ventas por mes — últimos 7 meses
    $grafVentasMes = collect(range(6, 0))->map(fn($i) => [
        'label' => now()->subMonths($i)->translatedFormat('M'),
        'total' => \App\Models\Venta::where('estado', 1)
                    ->whereYear('created_at',  now()->subMonths($i)->year)
                    ->whereMonth('created_at', now()->subMonths($i)->month)
                    ->count(),
    ]);
    
    // Compras vs Ventas — últimos 6 meses
    $grafCvsV = collect(range(5, 0))->map(fn($i) => [
        'label'   => now()->subMonths($i)->translatedFormat('M y'),
        'ventas'  => \App\Models\Venta::where('estado', 1)
                        ->whereYear('created_at',  now()->subMonths($i)->year)
                        ->whereMonth('created_at', now()->subMonths($i)->month)
                        ->count(),
        'compras' => \App\Models\Compra::where('estado', 1)
                        ->whereYear('created_at',  now()->subMonths($i)->year)
                        ->whereMonth('created_at', now()->subMonths($i)->month)
                        ->count(),
    ]);
    
    // Top 5 productos más vendidos
    
    $grafTopProductos = \App\Models\Producto::where('estado', 1)
        ->withCount(['ventas as vendidos'])
        ->orderByDesc('vendidos')
        ->limit(5)
        ->get()
        ->map(fn($p) => [
            'nombre'   => \Str::limit($p->nombre, 20),
            'vendidos' => (int) $p->vendidos,
        ]);
    
    // Distribución de productos por categoría
    
    $grafCategorias = \App\Models\Categoria::whereHas('caracteristica', fn($q) => $q->where('estado', 1))
        ->withCount(['productos as total' => fn($q) => $q->where('estado', 1)])
        ->having('total', '>', 0)
        ->orderByDesc('total')
        ->limit(6)
        ->get()
        ->map(fn($c) => [
            'nombre' => \Str::limit($c->caracteristica->nombre ?? 'Sin nombre', 16),
            'total'  => (int) $c->total,
        ]);
    @endphp
    

<style>
    .graf-section        { margin-top: 2.5rem; }
    .graf-heading        { font-size: .8rem; font-weight: 600; color: #64748b;
                           text-transform: uppercase; letter-spacing: .06em;
                           margin-bottom: 1.1rem; display: flex; align-items: center; gap: 8px; }
    .graf-heading::before{ content:''; width:3px; height:14px; background:#dc2626;
                           border-radius:0; display:inline-block; }
    .graf-grid           { display: grid; grid-template-columns: repeat(2,1fr); gap: 14px; }
    @media(max-width:860px){ .graf-grid{ grid-template-columns:1fr; } }

    .graf-card           { background:#fff; border:1px solid #e2e8f0; border-radius:12px;
                           overflow:hidden; transition:box-shadow .18s; }
    .graf-card:hover     { box-shadow:0 4px 16px rgba(0,0,0,.07); }
    .graf-card-head      { display:flex; align-items:center; gap:9px; padding:12px 16px;
                           border-bottom:1px solid #f1f5f9; }
    .gc-icon             { width:28px; height:28px; border-radius:7px; flex-shrink:0;
                           display:flex; align-items:center; justify-content:center; }
    .gc-icon svg         { width:14px; height:14px; }
    .gc-title            { font-size:.75rem; font-weight:600; color:#0f172a; flex:1;
                           text-transform:uppercase; letter-spacing:.04em; }
    .gc-badge            { font-size:.68rem; padding:2px 9px; border-radius:20px; font-weight:500; }
    .graf-card-body      { padding:14px 16px; }
    .graf-canvas-wrap    { position:relative; width:100%; }
    .graf-legend         { display:flex; flex-wrap:wrap; gap:6px 12px; margin-bottom:10px;
                           font-size:.72rem; color:#64748b; }
    .graf-legend-item    { display:flex; align-items:center; gap:4px; }
    .graf-legend-sq      { width:9px; height:9px; border-radius:2px; flex-shrink:0; }
    .graf-empty          { display:flex; align-items:center; justify-content:center;
                           height:160px; color:#94a3b8; font-size:.8rem; }
</style>

<div class="graf-section">
    <div class="graf-heading">Estadísticas y análisis</div>

    <div class="graf-grid">

        {{-- 1. Ventas por mes --}}
        <div class="graf-card">
            <div class="graf-card-head">
                <div class="gc-icon" style="background:#ECFDF5">
                    <svg viewBox="0 0 16 16" fill="none" stroke="#059669" stroke-width="1.6" stroke-linecap="round">
                        <path d="M2 12l3-5 3 2 3-4 3 3"/>
                    </svg>
                </div>
                <span class="gc-title">Ventas por mes</span>
                <span class="gc-badge" style="background:#ECFDF5;color:#065F46">7 meses</span>
            </div>
            <div class="graf-card-body">
                @if($grafVentasMes->sum('total') > 0)
                    <div class="graf-canvas-wrap" style="height:195px">
                        <canvas id="grafVM"></canvas>
                    </div>
                @else
                    <div class="graf-empty">Sin datos de ventas aún</div>
                @endif
            </div>
        </div>

        {{-- 2. Compras vs Ventas --}}
        <div class="graf-card">
            <div class="graf-card-head">
                <div class="gc-icon" style="background:#EFF6FF">
                    <svg viewBox="0 0 16 16" fill="none" stroke="#2563eb" stroke-width="1.6" stroke-linecap="round">
                        <rect x="2" y="8" width="3" height="6" rx="1"/>
                        <rect x="6.5" y="5" width="3" height="9" rx="1"/>
                        <rect x="11" y="2" width="3" height="12" rx="1"/>
                    </svg>
                </div>
                <span class="gc-title">Compras vs ventas</span>
                <span class="gc-badge" style="background:#EFF6FF;color:#1D4ED8">6 meses</span>
            </div>
            <div class="graf-card-body">
                <div class="graf-legend">
                    <span class="graf-legend-item">
                        <span class="graf-legend-sq" style="background:#059669"></span>Ventas
                    </span>
                    <span class="graf-legend-item">
                        <span class="graf-legend-sq" style="background:#2563eb"></span>Compras
                    </span>
                </div>
                <div class="graf-canvas-wrap" style="height:168px">
                    <canvas id="grafCV"></canvas>
                </div>
            </div>
        </div>

        {{-- 3. Top 5 productos --}}
        <div class="graf-card">
            <div class="graf-card-head">
                <div class="gc-icon" style="background:#FFF7ED">
                    <svg viewBox="0 0 16 16" fill="none" stroke="#d97706" stroke-width="1.6" stroke-linecap="round">
                        <path d="M8 2l1.5 4.5H14l-3.5 2.5 1.5 4.5L8 11l-4 2.5 1.5-4.5L2 6.5h4.5z"/>
                    </svg>
                </div>
                <span class="gc-title">Top 5 productos</span>
                <span class="gc-badge" style="background:#FFF7ED;color:#92400E">Más vendidos</span>
            </div>
            <div class="graf-card-body">
                @if($grafTopProductos->isNotEmpty())
                    <div class="graf-canvas-wrap" style="height:195px">
                        <canvas id="grafTP"></canvas>
                    </div>
                @else
                    <div class="graf-empty">Sin ventas registradas aún</div>
                @endif
            </div>
        </div>

        {{-- 4. Donut por categoría --}}
        <div class="graf-card">
            <div class="graf-card-head">
                <div class="gc-icon" style="background:#F5F3FF">
                    <svg viewBox="0 0 16 16" fill="none" stroke="#7c3aed" stroke-width="1.6" stroke-linecap="round">
                        <circle cx="8" cy="8" r="6"/>
                        <path d="M8 2a6 6 0 014.24 10.24"/>
                    </svg>
                </div>
                <span class="gc-title">Productos por categoría</span>
                <span class="gc-badge" style="background:#F5F3FF;color:#5B21B6">Distribución</span>
            </div>
            <div class="graf-card-body">
                @if($grafCategorias->isNotEmpty())
                    <div class="graf-legend" id="donutLegend"></div>
                    <div class="graf-canvas-wrap" style="height:168px">
                        <canvas id="grafDN"></canvas>
                    </div>
                @else
                    <div class="graf-empty">Sin categorías con productos</div>
                @endif
            </div>
        </div>

    </div>
</div>

@push('js')
<script>
    window.POS_ventasMes = {
        labels: @json($grafVentasMes->pluck('label')),
        data:   @json($grafVentasMes->pluck('total'))
    };
    window.POS_cvsv = {
        labels:  @json($grafCvsV->pluck('label')),
        ventas:  @json($grafCvsV->pluck('ventas')),
        compras: @json($grafCvsV->pluck('compras'))
    };
    window.POS_top5 = {
        labels: @json($grafTopProductos->pluck('nombre')),
        data:   @json($grafTopProductos->pluck('vendidos'))
    };
    window.POS_categorias = {
        labels: @json($grafCategorias->pluck('nombre')),
        data:   @json($grafCategorias->pluck('total'))
    };
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
</div>
@endsection


@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
