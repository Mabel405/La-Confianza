<nav class="sb-topnav navbar navbar-expand" 
     style="background: linear-gradient(135deg, #FFFFFF 100%);
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -10px rgba(124, 131, 253, 0.15);
            padding: 0.5rem 1rem;">

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group" style="border-radius: 14px; overflow: hidden; box-shadow: 0 4px 12px -6px rgba(124, 131, 253, 0.2);">
            <input class="form-control" type="text" placeholder="Buscar..." 
                   style="border: 1.8px solid #e5e7eb; border-right: none; background: #f8fafc; color: #1e293b; padding: 8px 16px;"
                   aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn" id="btnNavbarSearch" type="button" 
                    style="background: #f8fafc;
                           border: 1.8px solid #e5e7eb; border-left: none; color: #7c83fd;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    
    <!-- Navbar User Menu -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#" 
               role="button" data-bs-toggle="dropdown" aria-expanded="false"
               style="color: #1e293b; background: white; border-radius: 30px; padding: 6px 16px 6px 10px;
                      border: 1.8px solid #e5e7eb;
                      box-shadow: 0 4px 12px -6px rgba(124, 131, 253, 0.15);">
                <div class="d-flex align-items-center justify-content-center me-2"
                     style="width: 32px; height: 32px; border-radius: 50%; 
                            background: linear-gradient(135deg, #eef2ff 0%, #fdf2f8 100%);
                            border: 1px solid #fbcfe8;">
                    <i class="fas fa-user" style="color: #7c83fd; font-size: 14px;"></i>
                </div>
                <span style="font-size: 0.9rem; font-weight: 500;">{{ auth()->user()->name ?? 'Usuario' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" 
                style="background: white; border: 1px solid #e5e7eb; border-radius: 14px; box-shadow: 0 15px 30px -12px rgba(124, 131, 253, 0.25); padding: 8px; margin-top: 8px;">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.index') }}" 
                       style="color: #1e293b; border-radius: 10px; padding: 10px 16px; transition: all 0.2s;">
                        <i class="fas fa-cog me-2" style="color: #7c83fd; width: 20px;"></i>Configuraciones
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#!" 
                       style="color: #1e293b; border-radius: 10px; padding: 10px 16px; transition: all 0.2s;">
                        <i class="fas fa-history me-2" style="color: #7c83fd; width: 20px;"></i>Registro de Actividad
                    </a>
                </li>
                <li><hr class="dropdown-divider" style="border-color: #f1f5f9; margin: 6px 0;"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" 
                       style="color: #b91c1c; border-radius: 10px; padding: 10px 16px;"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2" style="color: #b91c1c; width: 20px;"></i>Cerrar Sesión
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<style>


.sb-topnav {
    transition: all 0.3s ease;
    position: fixed;
    top: 0;
    right: 0;
    z-index: 1030;
}

/* Inputs */
.sb-topnav .form-control:focus {
    box-shadow: 0 0 0 3px rgba(124, 131, 253, 0.15);
    border-color: #a5b4fc !important;
    background-color: white !important;
    outline: none;
}

/* Dropdown */
.sb-topnav .dropdown-item:hover {
    background: #fdf2f8 !important;
    color: #7c83fd !important;
    transform: translateX(3px);
}

.sb-topnav .dropdown-item:active {
    background: #eef2ff !important;
}

/* Usuario */
.navbar-nav .nav-link:hover {
    background: #fdf2f8 !important;
    border-color: #fbcfe8 !important;
    transform: translateY(-1px);
}

/* Animación del dropdown */
.dropdown-menu {
    animation: fadeInDown 0.2s ease;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}



:root {
    --sidebar-width: 260px; 
}


body:not(.sb-sidenav-toggled) .sb-topnav {
    left: var(--sidebar-width);
    width: calc(100% - var(--sidebar-width));
}


#layoutSidenav_content {
    padding-top: 72px;
}

</style>

