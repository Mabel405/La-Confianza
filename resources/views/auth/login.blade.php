<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Acceso — La Confianza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --red:       #c0392b;
            --red-dark:  #a93226;
            --red-light: #e74c3c;
            --bg:        #f4f6f8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }

        body {
            background: linear-gradient(135deg, #b71c1c 0%, #e53935 50%, #c0392b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

    
        .login-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 860px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(0,0,0,0.25);
        }

        @media (max-width: 680px) {
            .login-card { grid-template-columns: 1fr; }
            .panel-left  { display: none; }
        }

        .panel-left {
            background: var(--red);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }
        .panel-left::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(0,0,0,0.08);
        }

        .brand-logo { position: relative; z-index: 1; }
        .brand-logo svg { width: 120px; height: auto; filter: drop-shadow(0 8px 24px rgba(0,0,0,0.3)); }

        .brand-text {
            position: relative; z-index: 1;
            text-align: center;
        }
        .brand-text h2 {
            font-size: 1.5rem; font-weight: 700;
            color: #fff; letter-spacing: 0.3px; line-height: 1.2;
        }
        .brand-text p {
            font-size: 0.72rem; color: rgba(255,255,255,0.75);
            text-transform: uppercase; letter-spacing: 2.5px; margin-top: 5px;
        }

        .store-illustration {
            position: relative; z-index: 1;
            width: 100%; max-width: 220px;
        }
        .store-illustration svg { width: 100%; height: auto; }

        .brand-tagline {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.65);
            font-style: italic;
            text-align: center;
            position: relative; z-index: 1;
        }


        .panel-right {
            background: #fff;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header { margin-bottom: 2rem; }
        .form-header h1 { font-size: 1.4rem; font-weight: 700; color: #1a1a2e; }
        .form-header p  { font-size: 0.85rem; color: #64748b; margin-top: 4px; }


        .field { margin-bottom: 1.1rem; }

        .field label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }

        .field-wrap { position: relative; }

        .field-wrap .field-icon {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
            pointer-events: none;
        }

        .field-wrap input {
            width: 100%;
            padding: 11px 14px 11px 38px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.88rem;
            background: #f8fafc;
            color: #1a1a2e;
            transition: border-color 0.18s, box-shadow 0.18s;
            outline: none;
        }

        .field-wrap input:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(192,57,43,0.12);
            background: #fff;
        }

        .field-wrap input::placeholder { color: #cbd5e1; }

        .eye-toggle {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 2px;
            transition: color 0.15s;
        }
        .eye-toggle:hover { color: var(--red); }

        /* Botón */
        .btn-ingresar {
            width: 100%;
            padding: 12px;
            background: var(--red);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.8px;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .btn-ingresar:hover {
            background: var(--red-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(192,57,43,0.3);
        }
        .btn-ingresar:active { transform: translateY(0); }

        .btn-ingresar i { margin-right: 8px; }

        /* Errores */
        .alert-custom {
            background: #fef2f2;
            border-left: 3px solid #e24b4a;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 1.25rem;
            font-size: 0.82rem;
            color: #b91c1c;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        .alert-custom i { margin-top: 1px; }

        /* Pie */
        .form-footer {
            font-size: 0.72rem;
            color: #94a3b8;
            text-align: center;
            margin-top: 1.75rem;
        }
    </style>
</head>
<body>

<div class="login-card">

    {{-- ── Panel izquierdo ── --}}
    <div class="panel-left">

        {{-- Logo escudo La Confianza --}}
        <div class="brand-logo">
            <svg viewBox="0 0 120 145" fill="none" xmlns="http://www.w3.org/2000/svg">
                {{-- Escudo --}}
                <path d="M60 5L10 26V74C10 107 32 131 60 141C88 131 110 107 110 74V26L60 5Z"
                      fill="white" fill-opacity="0.18" stroke="white" stroke-width="2"/>
                <path d="M60 14L18 33V74C18 103 37 125 60 134C83 125 102 103 102 74V33L60 14Z"
                      fill="white" fill-opacity="0.1"/>
                {{-- Círculo interior --}}
                <circle cx="60" cy="70" r="30" fill="white" fill-opacity="0.18"/>
                {{-- Check / tilde --}}
                <path d="M44 70L55 82L78 56" stroke="white" stroke-width="4.5"
                      stroke-linecap="round" stroke-linejoin="round"/>
                {{-- Nombre en el escudo --}}
                <text x="60" y="112" text-anchor="middle" fill="white"
                      font-size="6.5" font-family="Poppins,sans-serif"
                      font-weight="700" letter-spacing="1.5">LA CONFIANZA</text>
            </svg>
        </div>

        <div class="brand-text">
            <h2>La Confianza</h2>
            <p>Mini Market · Lima</p>
        </div>

        {{-- Ilustración tienda --}}
        <div class="store-illustration">
            <svg viewBox="0 0 220 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                {{-- Suelo --}}
                <rect x="0" y="118" width="220" height="4" rx="2" fill="rgba(0,0,0,0.15)"/>
                {{-- Edificio --}}
                <rect x="12" y="50" width="196" height="70" rx="4" fill="rgba(255,255,255,0.12)"/>
                {{-- Toldo --}}
                <rect x="8"  y="40" width="204" height="14" rx="3" fill="rgba(255,255,255,0.28)"/>
                {{-- Rayas toldo --}}
                <rect x="30"  y="40" width="8" height="14" fill="rgba(0,0,0,0.1)"/>
                <rect x="60"  y="40" width="8" height="14" fill="rgba(0,0,0,0.1)"/>
                <rect x="90"  y="40" width="8" height="14" fill="rgba(0,0,0,0.1)"/>
                <rect x="120" y="40" width="8" height="14" fill="rgba(0,0,0,0.1)"/>
                <rect x="150" y="40" width="8" height="14" fill="rgba(0,0,0,0.1)"/>
                <rect x="180" y="40" width="8" height="14" fill="rgba(0,0,0,0.1)"/>
                {{-- Cartel --}}
                <rect x="40" y="28" width="140" height="14" rx="3" fill="rgba(255,255,255,0.22)"/>
                <text x="110" y="39" text-anchor="middle" fill="white"
                      font-size="7" font-family="Poppins,sans-serif" font-weight="700"
                      letter-spacing="1.5">LA CONFIANZA</text>
                {{-- Puerta --}}
                <rect x="90"  y="85" width="40" height="35" rx="3" fill="rgba(0,0,0,0.18)"/>
                <rect x="93"  y="88" width="16" height="30" rx="2" fill="rgba(255,255,255,0.15)"/>
                <rect x="111" y="88" width="16" height="30" rx="2" fill="rgba(255,255,255,0.15)"/>
                {{-- Estantes izquierda --}}
                <rect x="20" y="62" width="22" height="30" rx="2" fill="rgba(255,255,255,0.2)"/>
                <rect x="22" y="66" width="18" height="4" rx="1" fill="rgba(255,255,255,0.3)"/>
                <rect x="22" y="74" width="18" height="4" rx="1" fill="rgba(255,255,255,0.3)"/>
                <rect x="22" y="82" width="18" height="4" rx="1" fill="rgba(255,255,255,0.3)"/>
                {{-- Estantes derecha --}}
                <rect x="178" y="62" width="22" height="30" rx="2" fill="rgba(255,255,255,0.2)"/>
                <rect x="180" y="66" width="18" height="4" rx="1" fill="rgba(255,255,255,0.3)"/>
                <rect x="180" y="74" width="18" height="4" rx="1" fill="rgba(255,255,255,0.3)"/>
                <rect x="180" y="82" width="18" height="4" rx="1" fill="rgba(255,255,255,0.3)"/>
                {{-- Ventanas --}}
                <rect x="48" y="62" width="30" height="20" rx="2" fill="rgba(255,255,255,0.2)"/>
                <rect x="142" y="62" width="30" height="20" rx="2" fill="rgba(255,255,255,0.2)"/>
                {{-- Productos ventana --}}
                <circle cx="58" cy="72" r="5" fill="rgba(255,255,255,0.3)"/>
                <circle cx="68" cy="70" r="4" fill="rgba(255,255,255,0.25)"/>
                <circle cx="152" cy="72" r="5" fill="rgba(255,255,255,0.3)"/>
                <circle cx="162" cy="70" r="4" fill="rgba(255,255,255,0.25)"/>
            </svg>
        </div>

        <p class="brand-tagline">Sistema de Gestión Administrativa</p>
    </div>

    {{-- ── Panel derecho (formulario) ── --}}
    <div class="panel-right">

        <div class="form-header">
            <h1>Bienvenido</h1>
            <p>Ingresa tus credenciales para acceder al sistema</p>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            @foreach ($errors->all() as $item)
                <div class="alert-custom">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $item }}
                </div>
            @endforeach
        @endif

        <form action="/login" method="POST">
            @csrf

            {{-- Correo --}}
            <div class="field">
                <label>Correo electrónico</label>
                <div class="field-wrap">
                    <i class="fas fa-envelope field-icon"></i>
                    <input type="email"
                           name="email"
                           id="inputEmail"
                           placeholder="nombre@ejemplo.com"
                           value="{{ old('email') }}"
                           required>
                </div>
            </div>

            {{-- Contraseña --}}
            <div class="field">
                <label>Contraseña</label>
                <div class="field-wrap">
                    <i class="fas fa-lock field-icon"></i>
                    <input type="password"
                           name="password"
                           id="inputPassword"
                           placeholder="••••••••"
                           required>
                    <button class="eye-toggle" type="button" id="togglePassword" title="Ver contraseña">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button class="btn-ingresar" type="submit">
                <i class="fas fa-sign-in-alt"></i>INICIAR SESIÓN
            </button>

        </form>

        <p class="form-footer">
            &copy; {{ date('Y') }} La Confianza Mini Market · Lima, Perú
        </p>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('inputPassword');
        const icon  = document.getElementById('eyeIcon');
        const isPass = input.type === 'password';
        input.type = isPass ? 'text' : 'password';
        icon.classList.toggle('fa-eye',      !isPass);
        icon.classList.toggle('fa-eye-slash', isPass);
    });

    // Validación básica antes de enviar
    document.querySelector('form').addEventListener('submit', function (e) {
        const inputs = this.querySelectorAll('input[required]');
        let ok = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.style.borderColor = '#e24b4a';
                ok = false;
            } else {
                input.style.borderColor = '';
            }
        });
        if (!ok) e.preventDefault();
    });
</script>
</body>
</html>