<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','ExploreTuTumbes')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
    @php $compiledCss = 'build/assets/app-CEwZte8_.css'; @endphp
    @if(file_exists(public_path($compiledCss)))
        <link href="{{ asset($compiledCss) }}" rel="stylesheet">
    @endif
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Nunito', ui-sans-serif, system-ui, sans-serif;
            margin: 0;
            background: #f8fafc;
            font-size: 15px;
            color: #1a1a2e;
        }
        h1, h2, h3 { font-family: 'Playfair Display', 'Nunito', serif; }
        h4, h5, h6, p, a, span, button, input, select, label {
            font-family: 'Nunito', sans-serif;
        }
        img { max-width: 100%; height: auto; }

        /* Navbar responsivo */
        @media (max-width: 768px) {
            .nav-links { display: none !important; }
            .nav-auth { gap: 8px !important; }
            .nav-auth a[href*="register"] span.reg-text { display: none; }
        }

        /* Grids responsivos generales */
        @media (max-width: 900px) {
            .footer-grid { grid-template-columns: 1fr 1fr !important; }
        }
        @media (max-width: 600px) {
            .footer-grid { grid-template-columns: 1fr !important; gap: 28px !important; }
            .footer-bottom-inner { flex-direction: column !important; text-align: center !important; }
            .footer-bottom-links { justify-content: center !important; flex-wrap: wrap !important; gap: 12px !important; }
            /* Hero responsivo */
            .hero-search-grid { grid-template-columns: 1fr !important; }
            /* Stats responsivo */
            .stats-grid { grid-template-columns: 1fr !important; }
            /* Features responsivo */
            .features-grid { grid-template-columns: 1fr 1fr !important; }
            /* Cards responsivo */
            .cards-grid { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 480px) {
            .features-grid { grid-template-columns: 1fr !important; }
            .tabs-row { flex-direction: column !important; }
        }
    </style>
</head>
<body>
    @unless(request()->routeIs('cliente.login') || request()->routeIs('cliente.register'))
        @include('cliente.navbar')
    @endunless

    @yield('content')

    @unless(request()->routeIs('cliente.login') || request()->routeIs('cliente.register'))
        @include('cliente.footer_clie')
    @endunless
</body>
</html>
