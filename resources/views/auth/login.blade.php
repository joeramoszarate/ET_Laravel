<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Explore Tumbes | Iniciar sesión</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition login-page" style="background: linear-gradient(135deg, #f7fbf8 0%, #eef7ee 100%);">
<div class="login-box">
    <div class="card card-outline card-success shadow-lg">
        <div class="card-header text-center" style="background: linear-gradient(90deg, #2E7D32 0%, #0288D1 100%); color: white;">
            <h1 class="h4 mb-0"><b>Explore</b> Tumbes</h1>
            <p class="mb-0 small">Agencia de Turismo Provincial</p>
        </div>
        <div class="card-body login-card-body">
            <p class="login-box-msg text-muted">Ingrese sus credenciales para iniciar sesión</p>

            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group mb-3">
                    <input id="email" type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Correo" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <div class="input-group mb-3">
                    <input id="password" type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Recordarme</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-success btn-block" style="background-color:#2E7D32; border-color:#2E7D32;">Entrar</button>
                    </div>
                </div>
            </form>

            <p class="mb-0 mt-3 text-center">
                <a href="{{ route('password.request') }}" class="text-info">¿Olvidó su contraseña?</a>
            </p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>
