<div id="layoutSidenav_nav" class="layoutSidenav_nav-fixed">
    <nav class="sb-sidenav sb-sidenav-dark" id="sidenavAccordion"> 
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- Header del Sidebar -->
                <div class="d-flex align-items-center px-3 mb-3 sidebar-header" style="background: rgba(255,255,255,0.95); border-radius: 12px; padding: 12px !important; margin: 12px;">
                    
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('panel') }}">
                        <div class="sidebar-logo me-2 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; border-radius: 14px; background: rgba(196,30,58,0.1); border: 2px solid rgba(196,30,58,0.2); padding: 8px; flex-shrink: 0;">
                            <img src="/ICON/logo.png" alt="Logo" />
                        </div>
                        <div class="sidebar-text">
                            <h6 class="mb-0 fw-semibold" style="color: #C41E3A;">La Confianza</h6>
                            <small style="color: #666;">
                                <i class="fas fa-circle me-1" style="color: #C41E3A;"></i>
                                Panel Administrativo
                            </small>
                        </div>
                    </a>
                
                </div>

                <!-- Sección Principal -->
                <div class="sb-sidenav-menu-heading text-uppercase small fw-semibold px-3 mb-2" 
                     style="color: #ffffff; 
                            letter-spacing: 0.5px;
                            font-size: 0.7rem;
                            opacity: 0.9;">
                    <i class="fas fa-circle me-2" style="color: #FFE5E5; font-size: 4px;"></i>PRINCIPAL
                </div>
                <!-- Panel de Control -->
                <a class="nav-link active" href="{{ route('panel') }}" 
                   style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
                          color: #C41E3A;
                          border-left: 4px solid #C41E3A;
                          margin: 4px 12px;
                          padding: 12px 16px !important;
                          border-radius: 12px;
                          box-shadow: 0 4px 12px -8px rgba(196, 30, 58, 0.25);
                          font-weight: 600;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #C41E3A;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span class="nav-link-text">Panel de Control</span>
                </a>

                <!-- MÓDULOS DEL SISTEMA -->
                <div class="sb-sidenav-menu-heading text-uppercase small fw-semibold px-3 mt-4 mb-2" 
                     style="color: #ffffff; 
                            letter-spacing: 0.5px;
                            font-size: 0.7rem;
                            opacity: 0.9;">
                    <i class="fas fa-circle me-2" style="color: #FFE5E5; font-size: 4px;"></i>MÓDULOS DEL SISTEMA
                </div>
                
                <!-- Gestión de Compras -->
                @can('ver-compra')
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCompras" 
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span class="nav-link-text">Gestión de Compras</span>
                    <div class="sb-sidenav-collapse-arrow ms-auto" style="color: rgba(255,255,255,0.6);">
                        <i class="fas fa-chevron-down" style="font-size: 11px;"></i>
                    </div>
                </a>
                <div class="collapse" id="collapseCompras">
                    <nav class="sb-sidenav-menu-nested nav ps-4">
                        <a class="nav-link" href="{{ route('compras.index') }}">
                            <i class="fas fa-list me-2" style="font-size: 0.85rem;"></i>Ver Compras
                        </a>
                        <a class="nav-link" href="{{ route('compras.create') }}">
                            <i class="fas fa-plus-circle me-2" style="font-size: 0.85rem;"></i>Nueva Compra
                        </a>
                    </nav>
                </div>
                @endcan

                <!-- Gestión de Ventas -->
                @can('ver-venta')
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVentas"
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <span class="nav-link-text">Gestión de Ventas</span>
                    <div class="sb-sidenav-collapse-arrow ms-auto" style="color: rgba(255,255,255,0.6);">
                        <i class="fas fa-chevron-down" style="font-size: 11px;"></i>
                    </div>
                </a>
                <div class="collapse" id="collapseVentas">
                    <nav class="sb-sidenav-menu-nested nav ps-4">
                        <a class="nav-link" href="{{ route('ventas.index') }}"
                           style="color: rgba(255,255,255,0.85);
                                  padding: 8px 16px !important;
                                  margin: 2px 12px 2px 28px;
                                  border-radius: 8px;">
                            <i class="fas fa-list me-2" style="font-size: 0.85rem;"></i>
                            Ver Ventas
                        </a>
                        <a class="nav-link" href="{{ route('ventas.create') }}"
                           style="color: rgba(255,255,255,0.85);
                                  padding: 8px 16px !important;
                                  margin: 2px 12px 2px 28px;
                                  border-radius: 8px;">
                            <i class="fas fa-plus-circle me-2" style="font-size: 0.85rem;"></i>
                            Nueva Venta
                        </a>
                    </nav>
                </div>
                @endcan

                <!-- CATÁLOGOS -->
                <div class="sb-sidenav-menu-heading text-uppercase small fw-semibold px-3 mt-4 mb-2" 
                     style="color: #ffffff; 
                            letter-spacing: 0.5px;
                            font-size: 0.7rem;
                            opacity: 0.9;">
                    <i class="fas fa-circle me-2" style="color: #FFE5E5; font-size: 4px;"></i>CATÁLOGOS
                </div>
                
                <!-- Categorías -->
                @can('ver-categoria')
                <a class="nav-link" href="{{ route('categorias.index') }}"
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-tags"></i>
                    </div>
                    <span class="nav-link-text">Categorías</span>
                </a>
                @endcan

                <!-- Presentaciones -->
                @can('ver-presentacione')
                <a class="nav-link" href="{{ route('presentaciones.index') }}"
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-cube"></i>
                    </div>
                    <span class="nav-link-text">Presentaciones</span>
                </a>
                @endcan

                <!-- Marcas -->
                @can('ver-marca')
                <a class="nav-link" href="{{ route('marcas.index') }}"
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-badge"></i>
                    </div>
                    <span class="nav-link-text">Marcas</span>
                </a>
                @endcan

                <!-- Productos -->
                @can('ver-producto')
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProductos"
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <span class="nav-link-text">Productos</span>
                    <div class="sb-sidenav-collapse-arrow ms-auto" style="color: rgba(255,255,255,0.6);">
                        <i class="fas fa-chevron-down" style="font-size: 11px;"></i>
                    </div>
                </a>
                <div class="collapse" id="collapseProductos">
                    <nav class="sb-sidenav-menu-nested nav ps-4">
                        <a class="nav-link" href="{{ route('productos.index') }}">
                            <i class="fas fa-list me-2" style="font-size: 0.85rem;"></i>Ver Productos
                        </a>
                        <a class="nav-link" href="{{ route('productos.create') }}">
                            <i class="fas fa-plus-circle me-2" style="font-size: 0.85rem;"></i>Nuevo Producto
                        </a>
                    </nav>
                </div>
                @endcan

                <!-- PERSONAS Y CONTACTOS -->
                <div class="sb-sidenav-menu-heading text-uppercase small fw-semibold px-3 mt-4 mb-2" 
                     style="color: #ffffff; 
                            letter-spacing: 0.5px;
                            font-size: 0.7rem;
                            opacity: 0.9;">
                    <i class="fas fa-circle me-2" style="color: #FFE5E5; font-size: 4px;"></i>PERSONAS Y CONTACTOS
                </div>
                
                <!-- Clientes -->
                @can('ver-cliente')
                <a class="nav-link" href="{{ route('clientes.index') }}"
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-people-group"></i>
                    </div>
                    <span class="nav-link-text">Clientes</span>
                </a>
                @endcan

                <!-- Proveedores -->
                @can('ver-proveedore')
                <a class="nav-link" href="{{ route('proveedores.index') }}"
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-truck"></i>
                    </div>
                    <span class="nav-link-text">Proveedores</span>
                </a>
                @endcan

                <!-- ADMINISTRACIÓN -->
                <div class="sb-sidenav-menu-heading text-uppercase small fw-semibold px-3 mt-4 mb-2" 
                     style="color: #ffffff; 
                            letter-spacing: 0.5px;
                            font-size: 0.7rem;
                            opacity: 0.9;">
                    <i class="fas fa-circle me-2" style="color: #FFE5E5; font-size: 4px;"></i>ADMINISTRACIÓN
                </div>
                
                <!-- Usuarios -->
                @can('ver-user')
                <a class="nav-link" href="{{ route('users.index') }}"
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-user-lock"></i>
                    </div>
                    <span class="nav-link-text">Usuarios</span>
                </a>
                @endcan

                <!-- Roles -->
                @can('ver-role')
                <a class="nav-link" href="{{ route('roles.index') }}"
                   style="color: rgba(255,255,255,0.9);
                          margin: 2px 12px;
                          padding: 10px 16px !important;
                          border-radius: 10px;">
                    <div class="sb-nav-link-icon me-3" 
                         style="color: #FFE5E5;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <span class="nav-link-text">Roles y Permisos</span>
                </a>
                @endcan
            </div>
        </div>

    </nav>
</div>

<style>

#layoutSidenav_nav {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 260px;
    z-index: 1030;
}


.sb-sidenav-dark {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 260px;
    background: linear-gradient(180deg, #C41E3A 0%, #A01829 100%);
    border-right: 3px solid rgba(255,255,255,0.1);
    box-shadow: 10px 0 30px -15px rgba(196, 30, 58, 0.35);
    overflow-y: auto;
    transform: none !important;
}


#layoutSidenav_content {
    margin-left: 260px;
}

.sb-sidenav-dark .sb-sidenav-menu {
    background: transparent !important;
    padding: 16px 0;
}


.sidebar-header {
    padding: 14px 12px 18px;
    margin-bottom: 8px;
    border-bottom: 1px solid rgba(255,255,255,0.15);
}

.sb-sidenav-dark .navbar-brand {
    text-decoration: none;
}


.sidebar-logo {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: rgba(255,255,255,0.2);
    border: 2px solid rgba(255,255,255,0.35);
    box-shadow: 0 4px 10px -6px rgba(0,0,0,.4);
    padding: 6px;
}

.sidebar-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}


.sidebar-text h6 {
    color: #ffffff;
    font-size: 0.95rem;
    line-height: 1.1;
    margin-bottom: 2px;
    font-weight: 700;
}

.sidebar-text small {
    color: rgba(255,255,255,.75);
    font-size: 0.65rem;
    font-weight: 500;
}

.sidebar-text i {
    color: #FFE5E5;
    font-size: 6px;
}

.sb-sidenav-dark .sb-sidenav-menu-heading {
    text-transform: uppercase;
    font-size: .65rem;
    font-weight: 700;
    padding: 12px 16px 6px;
    letter-spacing: .08em;
    color: rgba(255,255,255,.85);
}


.sb-sidenav-dark .nav-link {
    color: rgba(255,255,255,.9) !important;
    margin: 3px 12px;
    padding: 10px 16px !important;
    border-radius: 10px;
    transition: all .25s cubic-bezier(0.4, 0, 0.2, 1);
}

.sb-sidenav-dark .nav-link:hover {
    color: #fff !important;
    background: rgba(255,255,255,.18) !important;
    transform: translateX(3px);
}

.sb-sidenav-dark .nav-link.active {
    color: #C41E3A !important;
    background: rgba(255,255,255,.95) !important;
    font-weight: 600;
}


.sb-sidenav-dark .sb-nav-link-icon,
.sb-sidenav-dark .sb-nav-link-icon i {
    color: rgba(255,255,255,.75) !important;
    transition: color .25s ease;
}

.sb-sidenav-dark .nav-link:hover .sb-nav-link-icon i {
    color: #FFE5E5 !important;
}

.sb-sidenav-dark .nav-link.active .sb-nav-link-icon i {
    color: #C41E3A !important;
}

.sb-sidenav-dark .sb-sidenav-collapse-arrow i {
    color: rgba(255,255,255,.6) !important;
    transition: transform .3s ease;
}

.sb-sidenav-dark .nav-link:hover .sb-sidenav-collapse-arrow i {
    color: rgba(255,255,255,.8) !important;
}


.sb-sidenav-dark .sb-sidenav-menu-nested {
    padding-left: .75rem;
}

.sb-sidenav-dark .sb-sidenav-menu-nested .nav-link {
    color: rgba(255,255,255,.8) !important;
    padding: 8px 16px !important;
    margin: 4px 12px 4px 28px;
    border-radius: 8px;
    font-size: .85rem;
    background: transparent !important;
    transition: all .15s ease;
}

.sb-sidenav-dark .sb-sidenav-menu-nested .nav-link:hover {
    color: #fff !important;
    background: rgba(255,255,255,.14) !important;
    transform: translateX(2px);
}

.sb-sidenav-dark .sb-sidenav-menu-nested .nav-link.active {
    color: #FFE5E5 !important;
    background: rgba(255,255,255,.15) !important;
    font-weight: 600;
}


.sb-sidenav-dark .sb-sidenav-menu-nested .nav-link i.fas.fa-circle {
    display: none !important;
}

.sb-sidenav-dark::-webkit-scrollbar {
    width: 6px;
}

.sb-sidenav-dark::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,.3);
    border-radius: 6px;
    transition: background .2s ease;
}

.sb-sidenav-dark::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,.5);
}

.sb-sidenav-dark::-webkit-scrollbar-track {
    background: transparent;
}


html, body {
    margin: 0 !important;
    padding: 0 !important;
    height: 100%;
}


body.sb-nav-fixed,
body.sb-nav-fixed #layoutSidenav,
body.sb-nav-fixed #layoutSidenav_nav,
body.sb-nav-fixed #layoutSidenav_content {
    padding-top: 0 !important;
    margin-top: 0 !important;
}

#layoutSidenav_nav,
#sidenavAccordion,
.sb-sidenav,
.sb-sidenav-dark {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    bottom: 0 !important;
    height: 100vh !important;
    margin-top: 0 !important;
    padding-top: 0 !important;
    transform: none !important;
}


#layoutSidenav_content {
    margin-left: 260px !important;
}

.sb-topnav,
.navbar {
    position: relative !important;
}
</style>