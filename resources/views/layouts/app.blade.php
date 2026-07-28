<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Explore Tumbes') }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── PALETA A: LIGHT — blanco / gris neutro / acento azul pizarra ── */
        :root,
        [data-theme="light"] {
            --bg-body:       #f4f6f9;
            --bg-sidebar:    #1e2433;
            --bg-sidebar-hover: #2a3347;
            --bg-navbar:     #ffffff;
            --bg-card:       #ffffff;
            --bg-content:    #f4f6f9;
            --bg-input:      #f8f9fc;
            --bg-table-head: #f8f9fc;
            --bg-table-row-hover: #f1f4fb;

            --text-primary:  #1a1f2e;
            --text-secondary:#64748b;
            --text-sidebar:  #c8d3e8;
            --text-sidebar-active: #ffffff;
            --text-nav-header: #5a6a85;

            --accent:        #3b5bdb;
            --accent-hover:  #2f4ac4;
            --accent-light:  #eef2ff;

            --border:        #e8ecf4;
            --border-input:  #dde3f0;
            --shadow:        0 1px 3px rgba(0,0,0,.06), 0 1px 8px rgba(0,0,0,.04);
            --shadow-card:   0 2px 8px rgba(0,0,0,.07);

            --brand-dot:     #3b5bdb;
            --sidebar-active-bg: #3b5bdb;
            --sidebar-active-text: #ffffff;
            --toggle-bg:     #f1f4fb;
            --toggle-icon:   #3b5bdb;
        }

        /* ── PALETA B: DARK — carbón profundo / acento índigo suave ── */
        [data-theme="dark"] {
            --bg-body:       #0f1117;
            --bg-sidebar:    #0d0f14;
            --bg-sidebar-hover: #1a1d26;
            --bg-navbar:     #13161f;
            --bg-card:       #1a1d26;
            --bg-content:    #0f1117;
            --bg-input:      #1e2130;
            --bg-table-head: #1e2130;
            --bg-table-row-hover: #1e2130;

            --text-primary:  #e8ecf4;
            --text-secondary:#8892a4;
            --text-sidebar:  #6b7a96;
            --text-sidebar-active: #ffffff;
            --text-nav-header: #3d4a60;

            --accent:        #6c8aff;
            --accent-hover:  #5a78f0;
            --accent-light:  #1a2040;

            --border:        #1e2436;
            --border-input:  #252b3b;
            --shadow:        0 1px 3px rgba(0,0,0,.3);
            --shadow-card:   0 2px 12px rgba(0,0,0,.4);

            --brand-dot:     #6c8aff;
            --sidebar-active-bg: #6c8aff;
            --sidebar-active-text: #ffffff;
            --toggle-bg:     #1a1d26;
            --toggle-icon:   #6c8aff;
        }

        /* ── ESCALA TIPOGRÁFICA ── */
        :root {
            --font:          'Inter', system-ui, -apple-system, sans-serif;

            /* Tamaños */
            --text-xs:       0.70rem;   /* 11.2px — etiquetas, badges */
            --text-sm:       0.78rem;   /* 12.5px — tabla body, sidebar */
            --text-base:     0.875rem;  /* 14px   — texto general */
            --text-md:       0.9375rem; /* 15px   — párrafos, inputs */
            --text-lg:       1.0625rem; /* 17px   — subtítulos */
            --text-xl:       1.25rem;   /* 20px   — títulos de sección */
            --text-2xl:      1.5rem;    /* 24px   — títulos de página */
            --text-3xl:      1.875rem;  /* 30px   — métricas grandes */

            /* Pesos */
            --fw-light:      300;
            --fw-normal:     400;
            --fw-medium:     500;
            --fw-semibold:   600;
            --fw-bold:       700;
            --fw-extrabold:  800;

            /* Line-height */
            --lh-tight:      1.2;
            --lh-snug:       1.35;
            --lh-normal:     1.5;
            --lh-relaxed:    1.65;

            /* Letter-spacing */
            --ls-tight:      -0.02em;
            --ls-normal:     0em;
            --ls-wide:       0.03em;
            --ls-wider:      0.06em;
            --ls-widest:     0.12em;
        }

        /* ── RESET GLOBAL ── */
        * { box-sizing: border-box; }

        html { font-size: 16px; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        body, .wrapper {
            font-family: var(--font) !important;
            font-size: var(--text-base) !important;
            font-weight: var(--fw-normal) !important;
            line-height: var(--lh-normal) !important;
            letter-spacing: var(--ls-normal) !important;
            background-color: var(--bg-body) !important;
            color: var(--text-primary) !important;
        }

        /* Aplicar fuente — excluir Font Awesome para no romper iconos */
        *:not(.fa):not(.fas):not(.far):not(.fal):not(.fab):not(.fad):not([class*="fa-"]) {
            font-family: var(--font) !important;
        }

        /* Forzar fuente de Font Awesome en iconos */
        .fa, .fas, .far, .fal, .fab, .fad,
        [class*="fa-"]::before, [class*="fa-"]::after {
            font-family: 'Font Awesome 5 Free', 'Font Awesome 5 Brands' !important;
        }

        /* ── NAVBAR ── */
        .main-header.navbar {
            background-color: var(--bg-navbar) !important;
            border-bottom: 1px solid var(--border) !important;
            box-shadow: var(--shadow) !important;
            min-height: 56px;
        }
        .main-header .nav-link,
        .main-header .navbar-nav .nav-link {
            color: var(--text-secondary) !important;
        }
        .main-header .nav-link:hover { color: var(--accent) !important; }
        .main-header .dropdown-menu {
            background: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            box-shadow: var(--shadow-card) !important;
        }
        .main-header .dropdown-item {
            color: var(--text-primary) !important;
            font-size: var(--text-base) !important;
            font-weight: var(--fw-medium) !important;
            letter-spacing: var(--ls-normal) !important;
        }
        .main-header .dropdown-item:hover {
            background: var(--accent-light) !important;
            color: var(--accent) !important;
        }
        .main-header .dropdown-divider { border-color: var(--border) !important; }

        /* ── SIDEBAR ── */
        .main-sidebar {
            background-color: var(--bg-sidebar) !important;
            border-right: 1px solid var(--border) !important;
            box-shadow: none !important;
        }
        .brand-link {
            background-color: var(--bg-sidebar) !important;
            border-bottom: 1px solid rgba(255,255,255,.06) !important;
            padding: 14px 16px !important;
        }
        .brand-text {
            color: #ffffff !important;
            font-size: var(--text-lg) !important;
            font-weight: var(--fw-extrabold) !important;
            letter-spacing: var(--ls-tight) !important;
            line-height: var(--lh-tight) !important;
        }
        .brand-text b {
            color: var(--brand-dot) !important;
            font-weight: var(--fw-extrabold) !important;
        }

        /* Nav items */
        .nav-sidebar .nav-link {
            color: #c8d3e8 !important;
            border-radius: 8px !important;
            margin: 1px 8px !important;
            padding: 9px 12px !important;
            font-size: var(--text-sm) !important;
            font-weight: var(--fw-medium) !important;
            line-height: var(--lh-snug) !important;
            letter-spacing: var(--ls-normal) !important;
            transition: all .15s !important;
        }
        .nav-sidebar .nav-link:hover {
            background-color: var(--bg-sidebar-hover) !important;
            color: #ffffff !important;
        }
        .nav-sidebar .nav-link p,
        .nav-sidebar .nav-link .nav-icon,
        .nav-sidebar .nav-link i {
            color: inherit !important;
            font-family: inherit !important;
        }
        /* Iconos del sidebar mantienen FA */
        .nav-sidebar .nav-icon.fas,
        .nav-sidebar .nav-icon.far,
        .nav-sidebar .nav-icon.fab {
            font-family: 'Font Awesome 5 Free', 'Font Awesome 5 Brands' !important;
        }
        .nav-sidebar .nav-link.active {
            background-color: var(--sidebar-active-bg) !important;
            color: var(--sidebar-active-text) !important;
            font-weight: var(--fw-semibold) !important;
            box-shadow: 0 2px 8px rgba(59,91,219,.25) !important;
        }
        .nav-sidebar .nav-link p {
            font-size: var(--text-sm) !important;
            font-weight: inherit !important;
            line-height: var(--lh-snug) !important;
        }
        .nav-sidebar .nav-icon { font-size: 0.85rem !important; width: 1.4rem !important; }

        .nav-header {
            color: #5a7090 !important;
            font-size: var(--text-xs) !important;
            font-weight: var(--fw-bold) !important;
            letter-spacing: var(--ls-widest) !important;
            line-height: var(--lh-tight) !important;
            padding: 16px 20px 5px !important;
            text-transform: uppercase !important;
        }

        /* ── CONTENT ── */
        .content-wrapper {
            background-color: var(--bg-content) !important;
        }
        .content-header {
            padding: 16px 20px 0 !important;
        }
        .content-header h1 {
            font-size: var(--text-xl) !important;
            font-weight: var(--fw-bold) !important;
            letter-spacing: var(--ls-tight) !important;
            line-height: var(--lh-tight) !important;
            color: var(--text-primary) !important;
        }

        /* ── CARDS ── */
        .card {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            border-radius: 10px !important;
            box-shadow: var(--shadow-card) !important;
            color: var(--text-primary) !important;
        }
        .card-header {
            background-color: var(--bg-card) !important;
            border-bottom: 1px solid var(--border) !important;
            color: var(--text-primary) !important;
            font-size: var(--text-md) !important;
            font-weight: var(--fw-semibold) !important;
            letter-spacing: var(--ls-tight) !important;
            line-height: var(--lh-snug) !important;
        }
        .card-body {
            color: var(--text-primary) !important;
            font-size: var(--text-base) !important;
            line-height: var(--lh-relaxed) !important;
        }
        .card-title {
            color: var(--text-primary) !important;
            font-size: var(--text-md) !important;
            font-weight: var(--fw-semibold) !important;
            letter-spacing: var(--ls-tight) !important;
        }

        /* ── TABLES ── */
        .table {
            color: var(--text-primary) !important;
        }
        .table thead th, .table-light th {
            background-color: var(--bg-table-head) !important;
            color: var(--text-secondary) !important;
            border-color: var(--border) !important;
            font-size: var(--text-xs) !important;
            font-weight: var(--fw-bold) !important;
            letter-spacing: var(--ls-wider) !important;
            text-transform: uppercase !important;
            line-height: var(--lh-snug) !important;
        }
        .table td {
            border-color: var(--border) !important;
            color: var(--text-primary) !important;
            font-size: var(--text-sm) !important;
            font-weight: var(--fw-normal) !important;
            line-height: var(--lh-normal) !important;
        }
        .table th {
            border-color: var(--border) !important;
            color: var(--text-primary) !important;
        }
        .table-hover tbody tr:hover td {
            background-color: var(--bg-table-row-hover) !important;
        }

        /* ── FORMS ── */
        .form-control, .custom-select, select.form-control {
            background-color: var(--bg-input) !important;
            border: 1.5px solid var(--border-input) !important;
            color: var(--text-primary) !important;
            border-radius: 7px !important;
            font-size: var(--text-base) !important;
            font-weight: var(--fw-normal) !important;
            line-height: var(--lh-normal) !important;
            letter-spacing: var(--ls-normal) !important;
            transition: border .2s !important;
        }
        .form-control:focus, select.form-control:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(59,91,219,.1) !important;
            background-color: var(--bg-card) !important;
        }
        .form-label, label {
            color: var(--text-secondary) !important;
            font-size: var(--text-xs) !important;
            font-weight: var(--fw-semibold) !important;
            letter-spacing: var(--ls-wide) !important;
            text-transform: uppercase !important;
            line-height: var(--lh-snug) !important;
        }
        .custom-file-label {
            background-color: var(--bg-input) !important;
            border-color: var(--border-input) !important;
            color: var(--text-secondary) !important;
            font-size: var(--text-base) !important;
        }

        /* ── BUTTONS ── */
        .btn {
            font-family: var(--font) !important;
            font-size: var(--text-sm) !important;
            font-weight: var(--fw-semibold) !important;
            letter-spacing: var(--ls-wide) !important;
            line-height: var(--lh-snug) !important;
            border-radius: 7px !important;
        }
        .btn-success {
            background-color: var(--accent) !important;
            border-color: var(--accent) !important;
            color: #fff !important;
        }
        .btn-success:hover {
            background-color: var(--accent-hover) !important;
            border-color: var(--accent-hover) !important;
        }
        .btn-outline-secondary {
            border-color: var(--border) !important;
            color: var(--text-secondary) !important;
        }
        .btn-outline-secondary:hover {
            background-color: var(--accent-light) !important;
            color: var(--accent) !important;
            border-color: var(--accent) !important;
        }
        .btn-outline-primary {
            border-color: var(--accent) !important;
            color: var(--accent) !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--accent) !important;
            color: #fff !important;
        }
        .btn-light {
            background-color: var(--bg-input) !important;
            border-color: var(--border) !important;
            color: var(--text-secondary) !important;
        }
        .btn-light:hover { background-color: var(--border) !important; }
        .btn-sm { font-size: var(--text-xs) !important; }
        .btn-lg { font-size: var(--text-md) !important; }

        /* ── ALERTS ── */
        .alert-success {
            background-color: #ecfdf5 !important;
            border-color: #6ee7b7 !important;
            color: #065f46 !important;
        }
        .alert-danger {
            background-color: #fef2f2 !important;
            border-color: #fca5a5 !important;
            color: #991b1b !important;
        }
        [data-theme="dark"] .alert-success {
            background-color: #052e16 !important;
            border-color: #166534 !important;
            color: #86efac !important;
        }
        [data-theme="dark"] .alert-danger {
            background-color: #2d0a0a !important;
            border-color: #7f1d1d !important;
            color: #fca5a5 !important;
        }

        /* ── MODALS ── */
        .modal-content {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            border-radius: 12px !important;
            color: var(--text-primary) !important;
        }
        .modal-header, .modal-footer {
            border-color: var(--border) !important;
        }
        .modal-title {
            color: var(--text-primary) !important;
            font-size: var(--text-lg) !important;
            font-weight: var(--fw-bold) !important;
            letter-spacing: var(--ls-tight) !important;
            line-height: var(--lh-snug) !important;
        }
        .close { color: var(--text-secondary) !important; }
        .modal-body {
            font-size: var(--text-base) !important;
            line-height: var(--lh-relaxed) !important;
        }

        /* ── BADGES ── */
        .badge-light {
            background-color: var(--bg-input) !important;
            color: var(--text-secondary) !important;
            border-color: var(--border) !important;
        }

        /* ── PROGRESS ── */
        .progress {
            background-color: var(--bg-input) !important;
            border-radius: 99px !important;
        }

        /* ── DROPDOWN ── */
        .dropdown-menu {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
        }

        /* ── THEME TOGGLE BUTTON ── */
        #themeToggle {
            background: var(--toggle-bg) !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px !important;
            width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center;
            padding: 0 !important;
            transition: all .2s;
        }
        #themeToggle:hover { border-color: var(--accent) !important; }
        #themeIcon { color: var(--toggle-icon) !important; font-size: 0.85rem; }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg-body); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-secondary); }

        /* ── MISC ── */
        /* ── TIPOGRAFÍA UTILITARIA ── */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font) !important;
            letter-spacing: var(--ls-tight) !important;
            line-height: var(--lh-tight) !important;
            font-weight: var(--fw-bold) !important;
            color: var(--text-primary) !important;
        }
        h1 { font-size: var(--text-2xl) !important; }
        h2 { font-size: var(--text-xl) !important; }
        h3 { font-size: var(--text-lg) !important; font-weight: var(--fw-semibold) !important; }
        h4 { font-size: var(--text-md) !important; font-weight: var(--fw-semibold) !important; }
        h5 { font-size: var(--text-base) !important; font-weight: var(--fw-semibold) !important; }
        h6 { font-size: var(--text-sm) !important; font-weight: var(--fw-semibold) !important; }

        p {
            font-size: var(--text-base) !important;
            line-height: var(--lh-relaxed) !important;
            color: var(--text-primary) !important;
        }
        small, .small {
            font-size: var(--text-xs) !important;
            line-height: var(--lh-normal) !important;
        }
        strong, b { font-weight: var(--fw-semibold) !important; }

        .text-muted { color: var(--text-secondary) !important; font-size: var(--text-sm) !important; }
        hr { border-color: var(--border) !important; }
        .input-group-text {
            background-color: var(--bg-input) !important;
            border-color: var(--border-input) !important;
            color: var(--text-secondary) !important;
        }
        .list-group-item {
            background-color: var(--bg-card) !important;
            border-color: var(--border) !important;
            color: var(--text-primary) !important;
        }
        .nav-tabs .nav-link {
            color: var(--text-secondary) !important;
            border-color: transparent !important;
        }
        .nav-tabs .nav-link.active {
            background-color: var(--bg-card) !important;
            border-color: var(--border) var(--border) var(--bg-card) !important;
            color: var(--accent) !important;
        }
        .nav-tabs { border-color: var(--border) !important; }

        /* Sidebar scrollbar */
        .sidebar { scrollbar-width: thin; scrollbar-color: var(--bg-sidebar-hover) transparent; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- NAVBAR --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto align-items-center" style="gap:8px;">
            {{-- Botón Calendario --}}
            <li class="nav-item">
                <a href="{{ route('admin.calendario') }}" id="btnCalendario" title="Calendario de Reservas"
                   style="background:var(--toggle-bg);border:1px solid var(--border);border-radius:8px;width:34px;height:34px;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .2s;"
                   onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='var(--border)'">
                    <i class="fas fa-calendar-alt" style="color:var(--toggle-icon);font-size:0.85rem;"></i>
                </a>
            </li>
            {{-- Toggle tema --}}
            <li class="nav-item">
                <button id="themeToggle" title="Cambiar tema">
                    <i id="themeIcon" class="fas fa-moon"></i>
                </button>
            </li>
            {{-- Usuario --}}
            <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" style="gap:6px;">
                    <div style="width:30px;height:30px;border-radius:50%;background:var(--accent-light);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-user" style="color:var(--accent);font-size:0.75rem;"></i>
                    </div>
                    <span style="font-size:0.85rem;font-weight:500;color:var(--text-primary);">
                        {{ Auth::user()->nombre ?? Auth::user()->correo }}
                    </span>
                    <i class="fas fa-chevron-down" style="font-size:0.65rem;color:var(--text-secondary);"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="min-width:180px;padding:6px;">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item" style="border-radius:6px;padding:8px 12px;">
                        <i class="fas fa-user-circle mr-2" style="color:var(--accent);width:14px;"></i>Perfil
                    </a>
                    <div class="dropdown-divider my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item" style="border-radius:6px;padding:8px 12px;color:#dc2626 !important;">
                            <i class="fas fa-sign-out-alt mr-2" style="width:14px;"></i>Cerrar sesión
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    {{-- SIDEBAR --}}
    <aside class="main-sidebar elevation-0">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text"><b>Explore</b> Tumbes</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2 pb-3">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th-large"></i><p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">VENTAS Y OPERACIONES</li>

                    <li class="nav-item">
                        <a href="{{ route('reservas.index') }}" class="nav-link {{ request()->routeIs('reservas.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-check"></i><p>Reservas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('caja') }}" class="nav-link {{ request()->routeIs('caja*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cash-register"></i><p>Caja</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('clients') }}" class="nav-link {{ request()->routeIs('clients', 'clients.search', 'clients.create', 'clients.edit') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i><p>Clientes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('usuarios.vista') }}" class="nav-link {{ request()->routeIs('usuarios.vista') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i><p>Usuarios</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pagos') }}" class="nav-link {{ request()->routeIs('pagos') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-credit-card"></i><p>Pagos</p>
                        </a>
                    </li>

                    <li class="nav-header">GESTIÓN DE CATÁLOGO</li>

                    <li class="nav-item">
                        <a href="{{ route('paquetes') }}" class="nav-link {{ request()->routeIs('paquetes') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box-open"></i><p>Paquetes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tours') }}" class="nav-link {{ request()->routeIs('tours') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-route"></i><p>Tours</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('destinos') }}" class="nav-link {{ request()->routeIs('destinos') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map-marked-alt"></i><p>Destinos</p>
                        </a>
                    </li>

                    <li class="nav-header">SISTEMA</li>

                    <li class="nav-item">
                        <a href="{{ route('reportes') }}" class="nav-link {{ request()->routeIs('reportes') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i><p>Reportes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('mipagina') }}" class="nav-link {{ request()->routeIs('mipagina') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-paint-brush"></i><p>Mi Página Web</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('configuracion') }}" class="nav-link {{ request()->routeIs('configuracion') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i><p>Configuración</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    {{-- CONTENT --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">{{ $header ?? 'Panel principal' }}</h1>
            </div>
        </div>
        <section class="content" style="padding-top:16px;">
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </section>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<script>
    const html = document.documentElement;

    function applyTheme(dark) {
        html.setAttribute('data-theme', dark ? 'dark' : 'light');
        document.getElementById('themeIcon').className = dark ? 'fas fa-sun' : 'fas fa-moon';
        localStorage.setItem('adminTheme', dark ? 'dark' : 'light');
    }

    document.getElementById('themeToggle').addEventListener('click', function () {
        applyTheme(html.getAttribute('data-theme') !== 'dark');
    });

    // Aplicar al cargar
    if (localStorage.getItem('adminTheme') === 'dark') applyTheme(true);
</script>
</body>
</html>
