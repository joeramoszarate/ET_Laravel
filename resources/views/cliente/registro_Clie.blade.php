<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Cuenta - ExploreTuTumbes</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @php $compiledCss = 'build/assets/app-CEwZte8_.css'; @endphp
    @if(file_exists(public_path($compiledCss)))
        <link href="{{ asset($compiledCss) }}" rel="stylesheet">
    @endif
</head>
<body style="margin:0; min-height:100vh; background:linear-gradient(160deg,#0e7490 0%,#1d6fa4 60%,#1e3a5f 100%); display:flex; flex-direction:column; align-items:center; justify-content:flex-start; padding:40px 16px 40px; font-family:Inter,ui-sans-serif,system-ui,sans-serif;">

    {{-- Header logo --}}
    <div style="text-align:center; margin-bottom:28px;">
        <div style="display:inline-flex; align-items:center; gap:10px; margin-bottom:8px;">
            <div style="background:rgba(255,255,255,0.2); border-radius:10px; width:40px; height:40px; display:flex; align-items:center; justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                    <circle cx="12" cy="9" r="2.5" fill="#fff" stroke="none"/>
                </svg>
            </div>
            <span style="font-size:1.5rem; font-weight:800; color:#fff;">ExploreTuTumbes</span>
        </div>
        <p style="color:rgba(255,255,255,0.8); font-size:0.95rem; margin:0;">Crea tu cuenta y comienza a explorar</p>
    </div>

    {{-- Card --}}
    <div style="background:#fff; border-radius:16px; padding:36px 40px; width:100%; max-width:560px; box-shadow:0 20px 60px rgba(0,0,0,0.25);">

        <h2 style="font-size:1.6rem; font-weight:700; color:#1e3a5f; margin:0 0 4px;">Crear Cuenta</h2>
        <p style="color:#6b7280; font-size:0.875rem; margin:0 0 28px;">Completa el formulario para registrarte en nuestra plataforma</p>

        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fca5a5; color:#dc2626; padding:10px 14px; border-radius:8px; font-size:0.875rem; margin-bottom:20px;">
                <ul style="margin:0; padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cliente.register.post') }}" method="POST" id="registerForm">
            @csrf

            {{-- DATOS PERSONALES --}}
            <div style="margin-bottom:20px;">
                <p style="font-size:0.7rem; font-weight:700; color:#9ca3af; letter-spacing:0.08em; text-transform:uppercase; margin:0 0 12px; padding-bottom:8px; border-bottom:1px solid #e5e7eb;">Datos Personales</p>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Nombre <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Juan" required maxlength="100"
                                style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:10px 10px 10px 34px; font-size:0.875rem; color:#374151; outline:none; box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                        </div>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Apellidos <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <input type="text" name="apellidos" value="{{ old('apellidos') }}" placeholder="Pérez García" required maxlength="100"
                                style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:10px 10px 10px 34px; font-size:0.875rem; color:#374151; outline:none; box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                        </div>
                    </div>
                </div>
            </div>

            {{-- DOCUMENTO DE IDENTIDAD --}}
            <div style="margin-bottom:20px;">
                <p style="font-size:0.7rem; font-weight:700; color:#9ca3af; letter-spacing:0.08em; text-transform:uppercase; margin:0 0 12px; padding-bottom:8px; border-bottom:1px solid #e5e7eb;">Documento de Identidad</p>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Tipo de Documento <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </span>
                            <select name="id_tipdoc" required
                                style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:10px 10px 10px 34px; font-size:0.875rem; color:#374151; outline:none; box-sizing:border-box; appearance:none; background:#fff;"
                                onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                                <option value="">Selecciona un tipo</option>
                                @foreach($tiposDocumento as $tipo)
                                    <option value="{{ $tipo->id_tipdoc }}" {{ old('id_tipdoc') == $tipo->id_tipdoc ? 'selected' : '' }}>
                                        {{ $tipo->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">N° de Documento <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </span>
                            <input type="text" name="nro_documento" value="{{ old('nro_documento') }}" placeholder="12345678" required maxlength="18"
                                style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:10px 10px 10px 34px; font-size:0.875rem; color:#374151; outline:none; box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                        </div>
                    </div>
                </div>
            </div>

            {{-- DATOS DE CONTACTO --}}
            <div style="margin-bottom:20px;">
                <p style="font-size:0.7rem; font-weight:700; color:#9ca3af; letter-spacing:0.08em; text-transform:uppercase; margin:0 0 12px; padding-bottom:8px; border-bottom:1px solid #e5e7eb;">Datos de Contacto</p>

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Correo Electrónico <span style="color:#ef4444;">*</span></label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tu@email.com" required maxlength="100"
                            style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:10px 10px 10px 34px; font-size:0.875rem; color:#374151; outline:none; box-sizing:border-box;"
                            onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Nacionalidad</label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/></svg>
                            </span>
                            <select name="nacionalidad"
                                style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:10px 10px 10px 34px; font-size:0.875rem; color:#374151; outline:none; box-sizing:border-box; appearance:none; background:#fff;"
                                onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                                <option value="">Selecciona (opcional)</option>
                                <option value="Peruana" {{ old('nacionalidad')=='Peruana'?'selected':'' }}>Peruana</option>
                                <option value="Colombiana" {{ old('nacionalidad')=='Colombiana'?'selected':'' }}>Colombiana</option>
                                <option value="Ecuatoriana" {{ old('nacionalidad')=='Ecuatoriana'?'selected':'' }}>Ecuatoriana</option>
                                <option value="Chilena" {{ old('nacionalidad')=='Chilena'?'selected':'' }}>Chilena</option>
                                <option value="Argentina" {{ old('nacionalidad')=='Argentina'?'selected':'' }}>Argentina</option>
                                <option value="Boliviana" {{ old('nacionalidad')=='Boliviana'?'selected':'' }}>Boliviana</option>
                                <option value="Venezolana" {{ old('nacionalidad')=='Venezolana'?'selected':'' }}>Venezolana</option>
                                <option value="Otra" {{ old('nacionalidad')=='Otra'?'selected':'' }}>Otra</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Teléfono</label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="+51 987 654 321" maxlength="18"
                                style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:10px 10px 10px 34px; font-size:0.875rem; color:#374151; outline:none; box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEGURIDAD --}}
            <div style="margin-bottom:20px;">
                <p style="font-size:0.7rem; font-weight:700; color:#9ca3af; letter-spacing:0.08em; text-transform:uppercase; margin:0 0 12px; padding-bottom:8px; border-bottom:1px solid #e5e7eb;">Seguridad</p>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Contraseña <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input type="password" name="password" id="pass1" placeholder="••••••••" required maxlength="8"
                                oninput="updateCounter(this.value.length)"
                                style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:10px 34px 10px 34px; font-size:0.875rem; color:#374151; outline:none; box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                            <button type="button" onclick="togglePass('pass1','eye1')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af; padding:0;">
                                <svg id="eye1" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        <p style="font-size:0.75rem; color:#0e7490; margin:4px 0 0;" id="passCounter">Máximo 8 caracteres (0/8)</p>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:#374151; margin-bottom:6px;">Confirmar Contraseña <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:#9ca3af;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input type="password" name="password_confirmation" id="pass2" placeholder="••••••••" required maxlength="8"
                                style="width:100%; border:1.5px solid #e5e7eb; border-radius:8px; padding:10px 34px 10px 34px; font-size:0.875rem; color:#374151; outline:none; box-sizing:border-box;"
                                onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#e5e7eb'">
                            <button type="button" onclick="togglePass('pass2','eye2')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af; padding:0;">
                                <svg id="eye2" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Términos --}}
            <div style="margin-bottom:24px;">
                <label style="display:flex; align-items:flex-start; gap:10px; font-size:0.875rem; color:#374151; cursor:pointer;">
                    <input type="checkbox" name="terminos" required style="width:15px; height:15px; margin-top:2px; accent-color:#0e7490; flex-shrink:0;">
                    <span>Acepto los <a href="#" style="color:#0e7490; font-weight:600; text-decoration:none;">términos y condiciones</a> y la <a href="#" style="color:#0e7490; font-weight:600; text-decoration:none;">política de privacidad</a></span>
                </label>
            </div>

            {{-- Botón submit --}}
            <button type="submit"
                style="width:100%; background:#1e3a5f; color:#fff; font-size:1rem; font-weight:700; padding:12px; border:none; border-radius:8px; cursor:pointer; transition:background 0.15s; letter-spacing:0.02em;"
                onmouseover="this.style.background='#0e7490'" onmouseout="this.style.background='#1e3a5f'">
                Crear Cuenta
            </button>
        </form>

        <p style="text-align:center; font-size:0.875rem; color:#6b7280; margin:20px 0 0;">
            ¿Ya tienes una cuenta? <a href="{{ route('cliente.login') }}" style="color:#0e7490; font-weight:600; text-decoration:none;">Inicia sesión aquí</a>
        </p>
    </div>

    {{-- Footer --}}
    <div style="margin-top:24px; text-align:center;">
        <a href="{{ route('cliente.inicio') }}" style="color:rgba(255,255,255,0.8); font-size:0.875rem; text-decoration:none;">
            ← Volver al inicio
        </a>
    </div>

    <script>
        function togglePass(inputId, iconId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
        function updateCounter(len) {
            document.getElementById('passCounter').textContent = 'Máximo 8 caracteres (' + len + '/8)';
        }
    </script>
</body>
</html>
