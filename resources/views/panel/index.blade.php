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
        <div class="text-muted">
            <i class="fas fa-calendar-alt me-2"></i>{{ now()->format('d/m/Y') }}
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
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-clock me-2"></i>Actividad Reciente</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            🧾 Última venta: {{ $ultimaVenta?->created_at ?? 'Sin registros' }}
                        </li>
                        <li class="list-group-item">
                            📦 Último producto: {{ $ultimoProducto?->nombre ?? 'Sin registros' }}
                        </li>
                        <li class="list-group-item">
                            👤 Último cliente: {{ $ultimoCliente?->nombre ?? 'Sin registros' }}
                        </li>
                        <li class="list-group-item">
                            🏭 Último proveedor: {{ $ultimoProveedor?->nombre ?? 'Sin registros' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush