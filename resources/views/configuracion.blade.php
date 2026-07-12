<x-app-layout>
    <x-slot name="header">
        Configuración
    </x-slot>

    <form action="{{ route('configuracion.update') }}" method="POST">
        @csrf

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#general">General</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#notificaciones">Notificaciones</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pagos">Pagos</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#seguridad">Seguridad</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="general">
                        <h5 class="mb-3">Información de la Empresa</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre de la Empresa</label>
                                <input type="text" name="nombre_empresa" class="form-control" value="{{ old('nombre_empresa', optional($config)->nombre_empresa ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email de Contacto</label>
                                <input type="email" name="email_contacto" class="form-control" value="{{ old('email_contacto', optional($config)->email_contacto ?? '') }}">
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="{{ old('telefono', optional($config)->telefono ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control" value="{{ old('direccion', optional($config)->direccion ?? '') }}">
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', optional($config)->descripcion ?? '') }}</textarea>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <label class="form-label">Moneda</label>
                                <input type="text" name="moneda" class="form-control" value="{{ old('moneda', optional($config)->moneda ?? 'USD') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Zona Horaria</label>
                                <input type="text" name="zona_horaria" class="form-control" value="{{ old('zona_horaria', optional($config)->zona_horaria ?? 'Lima (UTC-5)') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Idioma</label>
                                <input type="text" name="idioma" class="form-control" value="{{ old('idioma', optional($config)->idioma ?? 'Español') }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="notificaciones">
                        <h5 class="mb-3">Preferencias de Notificaciones</h5>

                        <div class="list-group">
                            <label class="list-group-item">
                                <input type="checkbox" name="notif_email" {{ old('notif_email', optional($config)->notif_email ?? true) ? 'checked' : '' }}> Notificaciones por Email
                            </label>
                            <label class="list-group-item">
                                <input type="checkbox" name="notif_sms" {{ old('notif_sms', optional($config)->notif_sms ?? false) ? 'checked' : '' }}> Notificaciones SMS
                            </label>
                            <label class="list-group-item">
                                <input type="checkbox" name="confirm_reserva" {{ old('confirm_reserva', optional($config)->confirm_reserva ?? true) ? 'checked' : '' }}> Confirmación de Reservas
                            </label>
                            <label class="list-group-item">
                                <input type="checkbox" name="recordatorio_pago" {{ old('recordatorio_pago', optional($config)->recordatorio_pago ?? true) ? 'checked' : '' }}> Recordatorios de Pago
                            </label>
                            <label class="list-group-item">
                                <input type="checkbox" name="emails_marketing" {{ old('emails_marketing', optional($config)->emails_marketing ?? false) ? 'checked' : '' }}> Emails de Marketing
                            </label>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pagos">
                        <h5 class="mb-3">Configuración de Pagos</h5>

                        <div class="card p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Stripe</strong>
                                    <div class="text-muted">Pasarela de pagos</div>
                                </div>
                                <div>
                                    <input type="checkbox" name="stripe_enabled" {{ old('stripe_enabled', optional($config)->stripe_enabled ?? false) ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Clave Pública</label>
                                    <input type="text" name="stripe_public" class="form-control" value="{{ old('stripe_public', optional($config)->stripe_public ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Clave Secreta</label>
                                    <input type="text" name="stripe_secret" class="form-control" value="{{ old('stripe_secret', optional($config)->stripe_secret ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="card p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>PayPal</strong>
                                    <div class="text-muted">Pagos alternativos</div>
                                </div>
                                <div>
                                    <input type="checkbox" name="paypal_enabled" {{ old('paypal_enabled', optional($config)->paypal_enabled ?? false) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="seguridad">
                        <h5 class="mb-3">Seguridad de la Cuenta</h5>

                        <div class="mb-3">
                            <label class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary">Actualizar Contraseña</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
