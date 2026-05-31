<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manajemen Alat Laboratorium</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Figtree', sans-serif;
                overflow-x: hidden;
                background: radial-gradient(circle at top, rgba(59,130,246,0.2), transparent 25%),
                            radial-gradient(circle at bottom right, rgba(16,185,129,0.14), transparent 18%),
                            linear-gradient(180deg, #07122a 0%, #0d1727 100%);
            }

            .navbar-custom {
                background: linear-gradient(135deg, #1e3a8a 0%, #23397e 80%);
                padding: 1rem 0;
                box-shadow: 0 18px 40px rgba(0,0,0,0.18);
            }

            .navbar-custom .navbar-brand {
                font-weight: 800;
                font-size: 1.45rem;
                color: #f8fafc !important;
                letter-spacing: 0.03em;
            }

            .hero {
                background: linear-gradient(135deg, #0f2b56 0%, #1c3f7a 35%, #1f4a91 100%);
                color: white;
                padding: 70px 20px;
                position: relative;
                overflow: hidden;
                min-height: calc(100vh - 92px);
                display: flex;
                align-items: center;
                border-radius: 32px;
                box-shadow: 0 30px 80px rgba(15,23,42,0.35);
            }

            .hero::before,
            .hero::after {
                content: '';
                position: absolute;
                border-radius: 50%;
                opacity: 0.16;
            }

            .hero::before {
                width: 520px;
                height: 520px;
                top: -140px;
                right: -140px;
                background: rgba(56,189,248,0.18);
                filter: blur(12px);
            }

            .hero::after {
                width: 340px;
                height: 340px;
                bottom: -90px;
                left: -90px;
                background: rgba(16,185,129,0.14);
                filter: blur(10px);
            }

            .hero-content {
                position: relative;
                z-index: 1;
                max-width: 640px;
                padding: 32px;
                background: rgba(255,255,255,0.08);
                border: 1px solid rgba(255,255,255,0.12);
                border-radius: 24px;
                backdrop-filter: blur(12px);
            }

            .hero h1 {
                font-size: 3.2rem;
                font-weight: 800;
                margin-bottom: 1rem;
                line-height: 1.03;
                letter-spacing: -0.04em;
            }

            .hero p {
                font-size: 1rem;
                margin-bottom: 1.75rem;
                line-height: 1.7;
                opacity: 0.9;
                color: rgba(248,250,252,0.94);
            }

            .hero-buttons {
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
            }

            .btn-hero-primary,
            .btn-hero-secondary {
                padding: 12px 30px;
                border-radius: 999px;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.25s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .btn-hero-primary {
                background: white;
                color: #1e3a8a;
                border: 2px solid white;
            }

            .btn-hero-secondary {
                background: rgba(255,255,255,0.16);
                color: white;
                border: 2px solid rgba(255,255,255,0.35);
            }

            .btn-hero-primary:hover,
            .btn-hero-secondary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 24px rgba(0,0,0,0.16);
            }

            .lab-illustration {
                position: relative;
                z-index: 1;
                height: 240px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(255,255,255,0.08);
                border: 1px solid rgba(255,255,255,0.12);
                border-radius: 28px;
                box-shadow: inset 0 0 40px rgba(255,255,255,0.06);
            }

            .lab-icon {
                font-size: 7rem;
                filter: drop-shadow(0 8px 24px rgba(0,0,0,0.25));
                animation: float 3.5s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-16px); }
            }

            .footer-custom {
                background: rgba(15,23,42,0.92);
                color: #cbd5e1;
                padding: 24px 20px;
                text-align: center;
                font-size: 0.95rem;
                border-top: 1px solid rgba(255,255,255,0.06);
            }

            @media (max-width: 768px) {
                .hero {
                    min-height: auto;
                    padding: 50px 16px;
                }

                .hero h1 {
                    font-size: 2.2rem;
                }

                .lab-illustration {
                    height: 180px;
                }

                .lab-icon {
                    font-size: 5rem;
                }
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">🔬 LAB MANAGER</a>
            </div>
        </nav>

        <div class="hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="hero-content">
                            <h1>COMPUTER LAB</h1>
                            <p>Sistem manajemen alat laboratorium komputer yang ringkas dan berwarna.
                            Akses login atau daftar akun dari halaman yang lebih profesional.</p>
                            <div class="hero-buttons">
                                <a href="{{ route('login') }}" class="btn-hero-primary">Login</a>
                                <a href="{{ route('register') }}" class="btn-hero-secondary">Daftar Akun</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="lab-illustration">
                            <div class="lab-icon">💻</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-custom">
            <p>&copy; 2026 Sistem Manajemen Lab Komputer.</p>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
