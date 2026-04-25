<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Acceso No Autorizado - La Confianza</title>
        <link href="{{ asset('css/template.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            body {
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
            }
            .error-card {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 40px;
                box-shadow: 0 15px 35px rgba(0,0,0,0.1);
                border: 1px solid rgba(255,255,255,0.3);
            }
            .display-1 {
                font-weight: 800;
                background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .btn-custom {
                background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
                border: none;
                color: white;
                padding: 12px 30px;
                border-radius: 30px;
                transition: transform 0.2s;
                text-decoration: none;
                display: inline-block;
            }
            .btn-custom:hover {
                transform: translateY(-3px);
                color: white;
                box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="error-card">
                        <div class="mb-4">
                            <i class="fas fa-lock-open fa-4x" style="color: #6a11cb;"></i>
                        </div>
                        <h1 class="display-1">401</h1>
                        <h2 class="mb-3">Acceso Restringido</h2>
                        <p class="lead mb-4"> No tienes los permisos necesarios para ver esta sección.</p>
                        
                        <a href="{{ route('login') }}" class="btn-custom">
                            <i class="fas fa-sign-in-alt me-2"></i> Iniciar sesion
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <footer class="fixed-bottom py-3">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-center small">
                    <div class="text-muted">Copyright &copy; Mini Market La Confianza 2026</div>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    </body>
</html>