<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Acceso Restringido — La Confianza</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background: linear-gradient(135deg, #b71c1c 0%, #e53935 50%, #c0392b 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* ── Tarjeta ── */
        .err-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 520px;
            display: flex;
            flex-direction: column;
        }

        /* Banda roja superior */
        .err-top {
            background: #c0392b;
            padding: 2.5rem 2rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }
        .err-top::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }
        .err-top::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 140px; height: 140px;
            border-radius: 50%;
            background: rgba(0,0,0,0.08);
        }

        /* Escudo + código */
        .shield-wrap { position: relative; z-index: 1; }
        .shield-wrap svg { width: 90px; height: auto; filter: drop-shadow(0 6px 16px rgba(0,0,0,0.3)); }

        .err-code {
            position: relative; z-index: 1;
            font-size: 5rem;
            font-weight: 800;
            color: rgba(255,255,255,0.2);
            line-height: 1;
            letter-spacing: -4px;
        }

        /* Cuerpo blanco */
        .err-body {
            padding: 2.5rem 2.5rem 2rem;
            text-align: center;
        }

        .lock-icon {
            width: 64px; height: 64px;
            border-radius: 50%;
            background: #fef2f2;
            display: flex; align-items: center; justify-content: center;
            margin: -2rem auto 1.5rem;
            position: relative; z-index: 2;
            border: 3px solid #fff;
            box-shadow: 0 4px 14px rgba(192,57,43,0.18);
        }
        .lock-icon i { font-size: 1.6rem; color: #c0392b; }

        .err-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }
        .err-msg {
            font-size: 0.88rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .btn-volver {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #c0392b;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 28px;
            font-size: 0.88rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .btn-volver:hover {
            background: #a93226;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(192,57,43,0.3);
        }

        /* Pie */
        .err-footer {
            font-size: 0.72rem;
            color: #94a3b8;
            text-align: center;
            padding: 1.25rem;
            border-top: 1px solid #f1f5f9;
        }

        /* Footer página */
        .page-footer {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.55);
            margin-top: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="err-card">

        {{-- Banda roja --}}
        <div class="err-top">
            <div class="shield-wrap">
                <svg viewBox="0 0 120 145" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M60 5L10 26V74C10 107 32 131 60 141C88 131 110 107 110 74V26L60 5Z"
                          fill="white" fill-opacity="0.18" stroke="white" stroke-width="2"/>
                    <path d="M60 14L18 33V74C18 103 37 125 60 134C83 125 102 103 102 74V33L60 14Z"
                          fill="white" fill-opacity="0.1"/>
                    <circle cx="60" cy="70" r="30" fill="white" fill-opacity="0.18"/>
                    <path d="M44 70L55 82L78 56" stroke="white" stroke-width="4.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <text x="60" y="112" text-anchor="middle" fill="white"
                          font-size="6.5" font-family="Poppins,sans-serif"
                          font-weight="700" letter-spacing="1.5">LA CONFIANZA</text>
                </svg>
            </div>
        </div>

        {{-- Cuerpo --}}
        <div class="err-body">

            <div class="lock-icon">
                <i class="fas fa-lock"></i>
            </div>

            <h2 class="err-title">Acceso restringido</h2>
            <p class="err-msg">
                No tienes los permisos necesarios para ver esta sección.<br>
                Por favor inicia sesión con una cuenta autorizada.
            </p>

            <a href="{{ route('login') }}" class="btn-volver">
                <i class="fas fa-sign-in-alt"></i>
                Iniciar sesión
            </a>

        </div>

        <div class="err-footer">
            &copy; {{ date('Y') }} La Confianza Mini Market · Lima, Perú
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>