<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - ExploreTuTumbes</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @php $compiledCss = 'build/assets/app-CEwZte8_.css'; @endphp
    @if(file_exists(public_path($compiledCss)))
        <link href="{{ asset($compiledCss) }}" rel="stylesheet">
    @endif
</head>
<body style="margin:0; min-height:100vh; background:linear-gradient(160deg,#0e7490 0%,#1d6fa4 60%,#1e3a5f 100%); display:flex; flex-direction:column; align-items:center; justify-content:center; font-family:Inter,ui-sans-serif,system-ui,sans-serif;">

    {{-- Header logo --}}
    <div style="text-align:center; margin-bottom:28px;">
        <div style="display:inline-flex; align-items:center; gap:10px; margin-bottom:8px;">
            <div style="background:rgba(255,255,255,0.2); border-radius:10px; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                    <circle cx="12" cy="9" r="2.5" fill="#fff" stroke="none"/>
                </svg>
            </div>
            <span style="font-size:1.5rem; font-weight:800; color:#fff; letter-spacing:0.01em;">ExploreTuTumbes</span>
        </div>
        <p style="color:rgba(255,255,255,0.8); font-size:0.95rem; margin:0;">Inicia sesión para continuar</p>
    </div>

    {{-- Card --}}
    <div style="background:#fff; border-radius:16px; padding:36px 40px; width:100%; max-width:420px; box-shadow:0 20px 60px rgba(0,0,0,0.25);">

        <h2 style="font-size:1.6rem; font-weight:700; color:#1e3a5f; margin:0 0 4px;">Iniciar Sesión</h2>
        <p style="color:#6b7280; font-size:0.875rem; margin:0 0 24px;">Ingresa tus credenciales para acceder a tu cuenta</p>

        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fca5a5; color:#dc2626; padding:10px 14px; border-radius:8px; font-size:0.875rem; margin-bottom:16px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('cliente.login.post') }}" method="POST">
            @csrf

            {{-- Correo --}}
            <div style="margin-bottom:18px;">
                <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Correo Electrónico</label>
                <div style="position:relative;">
                    <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tu@email.com" required
                        style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:11px 12px 11px 38px; font-size:0.9rem; color:#374151; outline:none; box-sizing:border-box; transition:border-color 0.15s;"
                        onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                </div>
            </div>

            {{-- Contraseña --}}
            <div style="margin-bottom:18px;">
                <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Contraseña</label>
                <div style="position:relative;">
                    <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </span>
                    <input type="password" name="password" id="passwordInput" placeholder="••••••••" required
                        style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:11px 40px 11px 38px; font-size:0.9rem; color:#374151; outline:none; box-sizing:border-box; transition:border-color 0.15s;"
                        onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                    <button type="button" onclick="togglePassword()" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af; padding:0;">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Recordarme + Olvidé contraseña --}}
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:22px;">
                <label style="display:flex; align-items:center; gap:8px; font-size:0.875rem; color:#374151; cursor:pointer;">
                    <input type="checkbox" name="remember" style="width:15px; height:15px; accent-color:#0e7490;">
                    Recordarme
                </label>
                <a href="#" style="font-size:0.875rem; color:#0e7490; text-decoration:none; font-weight:500;">¿Olvidaste tu contraseña?</a>
            </div>

            {{-- Botón submit --}}
            <button type="submit"
                style="width:100%; background:#1e3a5f; color:#fff; font-size:1rem; font-weight:700; padding:12px; border:none; border-radius:8px; cursor:pointer; transition:background 0.15s; letter-spacing:0.02em;"
                onmouseover="this.style.background='#0e7490'" onmouseout="this.style.background='#1e3a5f'">
                Iniciar Sesión
            </button>
        </form>

        {{-- Divisor --}}
        <div style="display:flex; align-items:center; gap:12px; margin:22px 0;">
            <div style="flex:1; height:1px; background:#e5e7eb;"></div>
            <span style="font-size:0.8rem; color:#9ca3af; white-space:nowrap;">O continúa con</span>
            <div style="flex:1; height:1px; background:#e5e7eb;"></div>
        </div>

        {{-- Botones sociales --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">
            <button type="button" style="display:flex; align-items:center; justify-content:center; gap:8px; border:1.5px solid #e5e7eb; background:#fff; border-radius:8px; padding:10px; font-size:0.875rem; font-weight:600; color:#374151; cursor:pointer; transition:background 0.15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                <svg width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Google
            </button>
            <button type="button" style="display:flex; align-items:center; justify-content:center; gap:8px; border:1.5px solid #e5e7eb; background:#fff; border-radius:8px; padding:10px; font-size:0.875rem; font-weight:600; color:#374151; cursor:pointer; transition:background 0.15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook
            </button>
        </div>

        {{-- Registro --}}
        <p style="text-align:center; font-size:0.875rem; color:#6b7280; margin:0 0 16px;">
            ¿No tienes una cuenta? <a href="{{ route('cliente.register') }}" style="color:#0e7490; font-weight:600; text-decoration:none;">Regístrate aquí</a>
        </p>

        {{-- Credenciales de prueba --}}
        <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:8px; padding:12px 16px; text-align:center; font-size:0.8rem; color:#92400e;">
            <p style="margin:0 0 4px;">💡 <strong>Credenciales de prueba:</strong></p>
            <p style="margin:0; color:#374151;"><strong>Admin:</strong> <span style="color:#0e7490;">admin@exploretutumbes.com</span></p>
            <p style="margin:0; color:#374151;"><strong>Cliente:</strong> <span style="color:#0e7490;">cualquier otro email</span></p>
        </div>
    </div>

    {{-- Footer links --}}
    <div style="margin-top:24px; text-align:center;">
        <a href="{{ route('cliente.inicio') }}" style="color:rgba(255,255,255,0.8); font-size:0.875rem; text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:8px;">
            ← Volver al inicio
        </a>
        <br>
        <a href="{{ route('login') }}" style="color:rgba(255,255,255,0.6); font-size:0.8rem; text-decoration:none;">
            🔒 Acceso al Panel Administrativo
        </a>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
