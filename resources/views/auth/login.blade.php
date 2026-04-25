<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Inicio de Sesion del Sistema" />
        <meta name="author" content="Mabel Manturano" />
        <title>Login - Sistema Administrativo</title>
        
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    </head>
    <body>
        <div class="login-container">
            <!-- Logo y marca -->
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="brand-name">Sistema Administrativo</div>
            </div>
            
            <!-- Tarjeta de login -->
            <div class="login-card">
                <div class="card-header">
                    <h2>ACCESO AL SISTEMA</h2>
                    <p>Ingresa tus credenciales para continuar</p>
                </div>
                
                <div class="card-body">
                    @if ($errors->any())
                    @foreach ($errors->all() as $item)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{$item}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endforeach
                    @endif
                    
                    <form action="/login" method="POST">
                        @csrf
                        
                        <!-- Campo de correo -->
                        <div class="mb-4">
                            <label for="inputEmail" class="form-label">
                                <i class="fas fa-envelope"></i>Correo electrónico
                            </label>
                            <div class="input-group">
                                <input type="email" 
                                       class="form-control" 
                                       name="email" 
                                       id="inputEmail" 
                                       placeholder="nombre@ejemplo.com"
                                       required>
                            </div>
                        </div>
                        
                        <!-- Campo de contraseña -->
                        <div class="mb-5">
                            <label for="inputPassword" class="form-label">
                                <i class="fas fa-key"></i>Contraseña
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       name="password" 
                                       id="inputPassword" 
                                       placeholder="Ingresa tu contraseña"
                                       required>
                                <button class="password-toggle" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Botón de inicio de sesión -->
                        <div class="d-grid">
                            <button class="btn-login" type="submit">
                                <i class="fas fa-sign-in-alt me-2"></i>INICIAR SESIÓN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <style>
        :root {
            --primary-color: #7c83fd;
            --secondary-color: #a5b4fc;
            --accent-color: #fbcfe8;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
    
            --gradient-primary: linear-gradient(135deg, #c7d2fe 0%, #fbcfe8 100%);
            --shadow-lg: 0 20px 40px rgba(15, 23, 42, 0.08);
            --shadow-hover: 0 25px 60px rgba(15, 23, 42, 0.12);
    
            --radius-lg: 22px;
            --radius-sm: 14px;
        }
    
        * {
            font-family: 'Poppins', sans-serif;
        }
    
        body {
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
    
        .login-container {
            max-width: 420px;
            width: 100%;
        }
    
        .login-card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            transition: 0.3s ease;
        }
    
        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }
    
        .card-header {
            background: linear-gradient(135deg, #eef2ff, #fdf2f8);
            padding: 32px 28px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }
    
        .card-header h2 {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 6px;
        }
    
        .card-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
    
        .card-body {
            padding: 32px 30px;
        }
    
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }
    
        .form-label i {
            margin-right: 8px;
            color: var(--primary-color);
        }
    
        .form-control {
            padding: 14px 16px;
            border: 1.8px solid #e5e7eb;
            border-radius: var(--radius-sm);
            font-size: 0.95rem;
            background-color: #f8fafc;
            transition: 0.2s ease;
        }
    
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(124, 131, 253, 0.25);
            background-color: white;
        }
    
        .input-group {
            border-radius: var(--radius-sm);
            overflow: hidden;
        }
    
        .password-toggle {
            background: #f8fafc;
            border: 1.8px solid #e5e7eb;
            border-left: none;
            padding: 0 16px;
            color: #64748b;
        }
    
        .password-toggle:hover {
            color: var(--primary-color);
        }
    
        .btn-login {
            background: linear-gradient(135deg, #a5b4fc, #fbcfe8);
            border: none;
            color: #1e293b;
            padding: 14px;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: var(--radius-sm);
            letter-spacing: 0.5px;
            transition: 0.3s ease;
        }
    
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(124, 131, 253, 0.25);
        }
    
        .alert-danger {
            background: #fef2f2;
            color: #b91c1c;
            border-left: 4px solid #f87171;
        }
    
        .logo-container {
            text-align: center;
            margin-bottom: 24px;
        }
    
        .logo {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.12);
        }
    
        .logo i {
            font-size: 1.8rem;
            color: #7c83fd;
        }
    
        .brand-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            letter-spacing: 1px;
        }
    
    
    
        @media (max-width: 576px) {
            body {
                padding: 10px;
            }
    
            .login-container {
                max-width: 100%;
            }
    
            .card-header h2 {
                font-size: 1.5rem;
            }
    
            .card-body {
                padding: 22px 20px;
            }
    
            .btn-login {
                font-size: 0.9rem;
                padding: 12px;
            }
    
            .logo {
                width: 56px;
                height: 56px;
            }
    
            .logo i {
                font-size: 1.5rem;
            }
    
            .brand-name {
                font-size: 1rem;
            }
        }
    
        @media (max-height: 700px) {
            body {
                align-items: flex-start;
            }
        }
    </style>
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const togglePassword = document.getElementById('togglePassword');
                const passwordInput = document.getElementById('inputPassword');
                const passwordIcon = togglePassword.querySelector('i');
                
                // Función para alternar visibilidad de contraseña
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Cambiar icono
                    if (type === 'password') {
                        passwordIcon.classList.remove('fa-eye-slash');
                        passwordIcon.classList.add('fa-eye');
                    } else {
                        passwordIcon.classList.remove('fa-eye');
                        passwordIcon.classList.add('fa-eye-slash');
                    }
                });
                
                // Efecto de enfoque en campos de entrada
                const inputs = document.querySelectorAll('.form-control');
                inputs.forEach(input => {
                    // Agregar efecto al enfocar
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('focused');
                    });
                    
                    // Remover efecto al perder el foco
                    input.addEventListener('blur', function() {
                        if (this.value === '') {
                            this.parentElement.classList.remove('focused');
                        }
                    });
                });
                
                // Efecto de validación para campos requeridos
                const form = document.querySelector('form');
                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    inputs.forEach(input => {
                        if (input.hasAttribute('required') && input.value.trim() === '') {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            });
        </script>
    </body>
</html>