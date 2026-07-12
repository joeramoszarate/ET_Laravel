<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Explore Tumbes') }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color:#f8fbf8;">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->nombre ?? Auth::user()->correo }}
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">Perfil</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Cerrar sesión</button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-success elevation-4" style="background-color:#2E7D32;">
        <a href="{{ route('dashboard') }}" class="brand-link" style="background-color:#2E7D32;">
            <span class="brand-text font-weight-light"><b>Explore</b> Tumbes</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
                    <li class="nav-header">VENTAS Y OPERACIONES</li>
                    <li class="nav-item"><a href="{{ route('reservas.index') }}" class="nav-link {{ request()->routeIs('reservas.*') ? 'active' : '' }}"><i class="nav-icon fas fa-calendar-check"></i><p>Reservas</p></a></li>
                    <li class="nav-item"><a href="{{ route('clients') }}" class="nav-link {{ request()->routeIs('clients', 'clients.search', 'clients.create', 'clients.edit') ? 'active' : '' }}"><i class="nav-icon fas fa-users"></i><p>Clientes</p></a></li>
                    <li class="nav-item"><a href="{{ route('pagos') }}" class="nav-link {{ request()->routeIs('pagos') ? 'active' : '' }}"><i class="nav-icon fas fa-credit-card"></i><p>Pagos <span class="text-muted" style="font-size:0.85em; font-style:italic;">(Sugerido)</span></p></a></li>
                    <li class="nav-header">GESTIÓN DE CATÁLOGO</li>
                    <li class="nav-item"><a href="{{ route('paquetes') }}" class="nav-link {{ request()->routeIs('paquetes') ? 'active' : '' }}"><i class="nav-icon fas fa-box-open"></i><p>Paquetes</p></a></li>
                    <li class="nav-item"><a href="{{ route('tours') }}" class="nav-link {{ request()->routeIs('tours') ? 'active' : '' }}"><i class="nav-icon fas fa-route"></i><p>Tours</p></a></li>
                    <li class="nav-item"><a href="{{ route('destinos') }}" class="nav-link {{ request()->routeIs('destinos') ? 'active' : '' }}"><i class="nav-icon fas fa-map-marked-alt"></i><p>Destinos</p></a></li>
                    <li class="nav-header">SISTEMA</li>
                    <li class="nav-item"><a href="{{ route('reportes') }}" class="nav-link {{ request()->routeIs('reportes') ? 'active' : '' }}"><i class="nav-icon fas fa-chart-bar"></i><p>Reportes</p></a></li>
                    <li class="nav-item"><a href="{{ route('configuracion') }}" class="nav-link {{ request()->routeIs('configuracion') ? 'active' : '' }}"><i class="nav-icon fas fa-cogs"></i><p>Configuración <span class="text-muted" style="font-size:0.85em; font-style:italic;">/ Usuarios</span></p></a></li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $header ?? 'Panel principal' }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                {{ $slot }}
            </div>
        </section>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>
