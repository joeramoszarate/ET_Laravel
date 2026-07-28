<x-app-layout>
    <x-slot name="header">Configuración</x-slot>

    <style>
        .cfg-title { color: #1a73e8; font-size: 1.6rem; font-weight: 700; margin-bottom: 2px; }
        .cfg-subtitle { color: #666; font-size: 0.92rem; margin-bottom: 1.2rem; }
        .cfg-tabs { display: flex; background: #f0f4f8; border-radius: 8px; padding: 4px; margin-bottom: 1.5rem; gap: 2px; }
        .cfg-tab { flex: 1; text-align: center; padding: 8px 0; border-radius: 6px; cursor: pointer; font-size: 0.93rem; color: #555; border: none; background: transparent; transition: all .2s; }
        .cfg-tab.active { background: #fff; color: #1a73e8; font-weight: 600; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        .cfg-panel { display: none; }
        .cfg-panel.active { display: block; }
        .cfg-card { background: #fff; border: 1px solid #e0e7ef; border-radius: 10px; padding: 1.5rem; }
        .cfg-section-title { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; margin-bottom: 2px; }
        .cfg-section-sub { color: #888; font-size: 0.85rem; margin-bottom: 1.2rem; }
        .cfg-label { font-size: 0.82rem; color: #555; margin-bottom: 4px; display: block; }
        .cfg-input { width: 100%; border: 1px solid #d0d9e8; border-radius: 6px; padding: 9px 12px; font-size: 0.93rem; color: #222; background: #f8fafd; outline: none; transition: border .2s; }
        .cfg-input:focus { border-color: #1a73e8; background: #fff; }
        .cfg-select { width: 100%; border: 1px solid #d0d9e8; border-radius: 6px; padding: 9px 12px; font-size: 0.93rem; color: #222; background: #f8fafd; appearance: auto; }
        .cfg-divider { border: none; border-top: 1px solid #e8edf3; margin: 1rem 0; }
        /* Toggle switch */
        .toggle-row { display: flex; justify-content: space-between; align-items: center; padding: 14px 0; border-bottom: 1px solid #f0f4f8; }
        .toggle-row:last-child { border-bottom: none; }
        .toggle-label strong { font-size: 0.93rem; color: #1a1a1a; display: block; }
        .toggle-label span { font-size: 0.82rem; color: #1a73e8; }
        .toggle-switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; inset: 0; background: #ccc; border-radius: 24px; cursor: pointer; transition: .3s; }
        .toggle-slider:before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: .3s; }
        .toggle-switch input:checked + .toggle-slider { background: #1a73e8; }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(20px); }
        /* Payment card */
        .pay-card { background: #f8fafd; border: 1px solid #e0e7ef; border-radius: 8px; padding: 1rem 1.2rem; margin-bottom: 1rem; }
        .pay-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0; }
        .pay-card-title strong { font-size: 0.95rem; color: #1a1a1a; }
        .pay-card-title span { font-size: 0.82rem; color: #888; display: block; }
        .pay-card-body { margin-top: 1rem; }
        /* Save button */
        .cfg-save-row { display: flex; justify-content: flex-end; margin-top: 1.2rem; }
        .cfg-btn-save { background: transparent; border: 1px solid #1a73e8; color: #1a73e8; border-radius: 6px; padding: 8px 18px; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all .2s; }
        .cfg-btn-save:hover { background: #1a73e8; color: #fff; }
        /* Security */
        .session-item { display: flex; justify-content: space-between; align-items: center; background: #f8fafd; border-radius: 8px; padding: 12px 16px; }
        .session-info strong { font-size: 0.93rem; color: #1a1a1a; }
        .session-info span { font-size: 0.82rem; color: #1a73e8; display: block; }
        .btn-outline-danger-sm { border: 1px solid #dc3545; color: #dc3545; background: transparent; border-radius: 6px; padding: 6px 14px; font-size: 0.85rem; cursor: pointer; }
        .btn-outline-danger-sm:hover { background: #dc3545; color: #fff; }
        .btn-outline-secondary-sm { border: 1px solid #888; color: #555; background: transparent; border-radius: 6px; padding: 6px 14px; font-size: 0.85rem; cursor: pointer; }
        .btn-outline-secondary-sm:hover { background: #888; color: #fff; }
    </style>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="cfg-title">Configuración</div>
    <div class="cfg-subtitle">Administra las preferencias y ajustes de tu agencia</div>

    <!-- Tabs -->
    <div class="cfg-tabs">
        <button class="cfg-tab active" onclick="switchTab('general', this)">General</button>
        <button class="cfg-tab" onclick="switchTab('notificaciones', this)">Notificaciones</button>
        <button class="cfg-tab" onclick="switchTab('pagos', this)">Pagos</button>
        <button class="cfg-tab" onclick="switchTab('seguridad', this)">Seguridad</button>
    </div>

    {{-- ===== GENERAL ===== --}}
    <div id="tab-general" class="cfg-panel active">
        <form action="{{ route('configuracion.update') }}" method="POST">
            @csrf
            <input type="hidden" name="_tab" value="general">
            <div class="cfg-card">
                <div class="cfg-section-title"><i class="fas fa-globe mr-2" style="color:#1a73e8;"></i>Información de la Empresa</div>
                <div class="cfg-section-sub">Actualiza los datos principales de tu agencia</div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="cfg-label">Nombre de la Empresa</label>
                        <input type="text" name="nombre_empresa" class="cfg-input" value="{{ old('nombre_empresa', optional($config)->nombre_empresa ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="cfg-label">Email de Contacto</label>
                        <input type="email" name="email_contacto" class="cfg-input" value="{{ old('email_contacto', optional($config)->email_contacto ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="cfg-label">Teléfono</label>
                        <input type="text" name="telefono" class="cfg-input" value="{{ old('telefono', optional($config)->telefono ?? '') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="cfg-label">Dirección</label>
                        <input type="text" name="direccion" class="cfg-input" value="{{ old('direccion', optional($config)->direccion ?? '') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="cfg-label">Descripción</label>
                    <input type="text" name="descripcion" class="cfg-input" value="{{ old('descripcion', optional($config)->descripcion ?? '') }}">
                </div>

                <hr class="cfg-divider">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="cfg-label">Moneda</label>
                        <select name="moneda" class="cfg-select">
                            @foreach(['USD - Dólar','PEN - Sol','EUR - Euro'] as $m)
                                <option value="{{ $m }}" {{ old('moneda', optional($config)->moneda ?? 'USD - Dólar') === $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="cfg-label">Zona Horaria</label>
                        <select name="zona_horaria" class="cfg-select">
                            @foreach(['Lima (UTC-5)','Bogotá (UTC-5)','Ciudad de México (UTC-6)','Madrid (UTC+1)'] as $z)
                                <option value="{{ $z }}" {{ old('zona_horaria', optional($config)->zona_horaria ?? 'Lima (UTC-5)') === $z ? 'selected' : '' }}>{{ $z }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="cfg-label">Idioma</label>
                        <select name="idioma" class="cfg-select">
                            @foreach(['Español','English','Português'] as $i)
                                <option value="{{ $i }}" {{ old('idioma', optional($config)->idioma ?? 'Español') === $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="cfg-save-row">
                    <button type="submit" class="cfg-btn-save"><i class="fas fa-save"></i> Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== NOTIFICACIONES ===== --}}
    <div id="tab-notificaciones" class="cfg-panel">
        <form action="{{ route('configuracion.update') }}" method="POST">
            @csrf
            <input type="hidden" name="_tab" value="notificaciones">
            <div class="cfg-card">
                <div class="cfg-section-title"><i class="fas fa-bell mr-2" style="color:#1a73e8;"></i>Preferencias de Notificaciones</div>
                <div class="cfg-section-sub">Configura cómo y cuándo deseas recibir notificaciones</div>

                @php
                    $notifs = [
                        ['name'=>'notif_email',       'label'=>'Notificaciones por Email',  'desc'=>'Recibe actualizaciones importantes por correo electrónico', 'default'=>true],
                        ['name'=>'notif_sms',         'label'=>'Notificaciones SMS',         'desc'=>'Recibe alertas críticas por mensaje de texto',              'default'=>false],
                        ['name'=>'confirm_reserva',   'label'=>'Confirmación de Reservas',   'desc'=>'Enviar email automático al confirmar una reserva',          'default'=>true],
                        ['name'=>'recordatorio_pago', 'label'=>'Recordatorios de Pago',      'desc'=>'Enviar recordatorios para pagos pendientes',                'default'=>true],
                        ['name'=>'emails_marketing',  'label'=>'Emails de Marketing',        'desc'=>'Recibir promociones y ofertas especiales',                  'default'=>false],
                    ];
                @endphp

                @foreach($notifs as $n)
                    <div class="toggle-row">
                        <div class="toggle-label">
                            <strong>{{ $n['label'] }}</strong>
                            <span>{{ $n['desc'] }}</span>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="{{ $n['name'] }}" {{ old($n['name'], optional($config)->{$n['name']} ?? $n['default']) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                @endforeach

                <div class="cfg-save-row">
                    <button type="submit" class="cfg-btn-save"><i class="fas fa-save"></i> Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== PAGOS ===== --}}
    <div id="tab-pagos" class="cfg-panel">
        <form action="{{ route('configuracion.update') }}" method="POST">
            @csrf
            <input type="hidden" name="_tab" value="pagos">
            <div class="cfg-card">
                <div class="cfg-section-title"><i class="fas fa-credit-card mr-2" style="color:#1a73e8;"></i>Configuración de Pagos</div>
                <div class="cfg-section-sub">Administra métodos de pago y pasarelas</div>

                {{-- Stripe --}}
                <div class="pay-card">
                    <div class="pay-card-header">
                        <div class="pay-card-title d-flex align-items-center gap-2">
                            <i class="fas fa-credit-card mr-2" style="color:#1a73e8;font-size:1.1rem;"></i>
                            <div>
                                <strong>Stripe</strong>
                                <span>Pasarela de pagos</span>
                            </div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="stripe_enabled" id="stripeToggle" {{ old('stripe_enabled', optional($config)->stripe_enabled ?? false) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    <div class="pay-card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="cfg-label">Clave Pública</label>
                                <input type="text" name="stripe_public" class="cfg-input" placeholder="pk_live_..." value="{{ old('stripe_public', optional($config)->stripe_public ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="cfg-label">Clave Secreta</label>
                                <input type="text" name="stripe_secret" class="cfg-input" placeholder="sk_live_..." value="{{ old('stripe_secret', optional($config)->stripe_secret ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PayPal --}}
                <div class="pay-card">
                    <div class="pay-card-header">
                        <div class="pay-card-title d-flex align-items-center gap-2">
                            <i class="fas fa-envelope mr-2" style="color:#1a73e8;font-size:1.1rem;"></i>
                            <div>
                                <strong>PayPal</strong>
                                <span>Pagos alternativos</span>
                            </div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="paypal_enabled" {{ old('paypal_enabled', optional($config)->paypal_enabled ?? false) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="cfg-save-row">
                    <button type="submit" class="cfg-btn-save"><i class="fas fa-save"></i> Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>

    {{-- ===== SEGURIDAD ===== --}}
    <div id="tab-seguridad" class="cfg-panel">
        <form action="{{ route('configuracion.update') }}" method="POST">
            @csrf
            <input type="hidden" name="_tab" value="seguridad">
            <div class="cfg-card">
                <div class="cfg-section-title"><i class="fas fa-lock mr-2" style="color:#1a73e8;"></i>Seguridad de la Cuenta</div>
                <div class="cfg-section-sub">Actualiza tu contraseña y configuración de seguridad</div>

                <div class="mb-3">
                    <label class="cfg-label">Contraseña Actual</label>
                    <input type="password" name="current_password" class="cfg-input">
                </div>
                <div class="mb-3">
                    <label class="cfg-label" style="color:#1a73e8;">Nueva Contraseña</label>
                    <input type="password" name="new_password" class="cfg-input">
                </div>
                <div class="mb-3">
                    <label class="cfg-label" style="color:#1a73e8;">Confirmar Nueva Contraseña</label>
                    <input type="password" name="new_password_confirmation" class="cfg-input">
                </div>

                <hr class="cfg-divider">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong style="font-size:.93rem;">Autenticación de Dos Factores</strong>
                        <div style="font-size:.82rem;color:#888;">Añade una capa extra de seguridad a tu cuenta</div>
                    </div>
                    <button type="button" class="btn-outline-secondary-sm">Configurar</button>
                </div>

                <hr class="cfg-divider">

                <div style="font-size:.85rem;color:#555;margin-bottom:.6rem;">Sesiones Activas</div>
                <div class="session-item">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-user-circle fa-2x mr-3" style="color:#aaa;"></i>
                        <div class="session-info">
                            <strong>{{ request()->header('User-Agent') ? 'Navegador actual' : 'Chrome - Windows' }}</strong>
                            <span>Activo ahora</span>
                        </div>
                    </div>
                    <button type="button" class="btn-outline-danger-sm">Cerrar Sesión</button>
                </div>

                <div class="cfg-save-row">
                    <button type="submit" class="cfg-btn-save"><i class="fas fa-save"></i> Actualizar Contraseña</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function switchTab(tab, el) {
            document.querySelectorAll('.cfg-panel').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.cfg-tab').forEach(t => t.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
            el.classList.add('active');
            localStorage.setItem('cfgTab', tab);
        }
        // Restaurar tab activo
        const saved = localStorage.getItem('cfgTab');
        if (saved) {
            const btn = [...document.querySelectorAll('.cfg-tab')].find(b => b.getAttribute('onclick').includes("'" + saved + "'"));
            if (btn) switchTab(saved, btn);
        }
    </script>
</x-app-layout>
