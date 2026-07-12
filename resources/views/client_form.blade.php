<x-app-layout>
    <x-slot name="header">
        <h2 class="mb-0">{{ isset($cliente) ? 'Editar Cliente' : 'Agregar Nuevo Cliente' }}</h2>
    </x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ isset($cliente) ? route('clients.update', $cliente->id_cliente) : route('clients.store') }}" method="POST">
                        @csrf
                        @if(isset($cliente))
                            @method('PUT')
                        @endif

                        <!-- ID Cliente (solo lectura si edita) -->
                        @if(isset($cliente))
                            <div class="mb-3">
                                <label for="id_cliente" class="form-label">ID Cliente</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="id_cliente" 
                                    value="{{ $cliente->id_cliente }}"
                                    readonly
                                >
                            </div>
                        @endif

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('nombre') is-invalid @enderror" 
                                    id="nombre" 
                                    name="nombre"
                                    value="{{ old('nombre', isset($cliente) ? $cliente->nombre : '') }}"
                                    placeholder="Nombre del cliente"
                                    required
                                >
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Apellidos -->
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('apellidos') is-invalid @enderror" 
                                    id="apellidos" 
                                    name="apellidos"
                                    value="{{ old('apellidos', isset($cliente) ? $cliente->apellidos : '') }}"
                                    placeholder="Apellidos del cliente"
                                    required
                                >
                                @error('apellidos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tipo de Documento -->
                            <div class="col-md-6 mb-3">
                                <label for="id_tipdoc" class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                                <select 
                                    class="form-select @error('id_tipdoc') is-invalid @enderror" 
                                    id="id_tipdoc" 
                                    name="id_tipdoc"
                                    required
                                >
                                    <option value="">-- Seleccionar --</option>
                                    @forelse($tiposDocumento ?? [] as $tipo)
                                        <option value="{{ $tipo->id_tipdoc }}" {{ old('id_tipdoc', isset($cliente) ? $cliente->id_tipdoc : '') === $tipo->id_tipdoc ? 'selected' : '' }}>
                                            {{ $tipo->descripcion ?? $tipo->id_tipdoc }}
                                        </option>
                                    @empty
                                        <option value="" disabled>No hay tipos de documento disponibles</option>
                                    @endforelse
                                </select>
                                @error('id_tipdoc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Número de Documento -->
                            <div class="col-md-6 mb-3">
                                <label for="nro_documento" class="form-label">Nº Documento <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('nro_documento') is-invalid @enderror" 
                                    id="nro_documento" 
                                    name="nro_documento"
                                    value="{{ old('nro_documento', isset($cliente) ? $cliente->nro_documento : '') }}"
                                    placeholder="Ej: 12345678"
                                    required
                                >
                                @error('nro_documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Correo -->
                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                <input 
                                    type="email" 
                                    class="form-control @error('correo') is-invalid @enderror" 
                                    id="correo" 
                                    name="correo"
                                    value="{{ old('correo', isset($cliente) ? $cliente->correo : '') }}"
                                    placeholder="correo@ejemplo.com"
                                    required
                                >
                                @error('correo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('telefono') is-invalid @enderror" 
                                    id="telefono" 
                                    name="telefono"
                                    value="{{ old('telefono', isset($cliente) ? $cliente->telefono : '') }}"
                                    placeholder="+51 987654321"
                                >
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Nacionalidad -->
                            <div class="col-md-6 mb-3">
                                <label for="nacionalidad" class="form-label">Nacionalidad</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('nacionalidad') is-invalid @enderror" 
                                    id="nacionalidad" 
                                    name="nacionalidad"
                                    value="{{ old('nacionalidad', isset($cliente) ? $cliente->nacionalidad : '') }}"
                                    placeholder="Ej: Peruana"
                                >
                                @error('nacionalidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contraseña -->
                            <div class="col-md-6 mb-3">
                                <label for="contraseña" class="form-label">Contraseña <span class="text-danger">*</span></label>
                                <input 
                                    type="password" 
                                    class="form-control @error('contraseña') is-invalid @enderror" 
                                    id="contraseña" 
                                    name="contraseña"
                                    placeholder="Contraseña segura"
                                    {{ isset($cliente) ? '' : 'required' }}
                                >
                                @if(isset($cliente))
                                    <small class="text-muted">Dejar en blanco para mantener la contraseña actual</small>
                                @endif
                                @error('contraseña')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                {{ isset($cliente) ? 'Actualizar Cliente' : 'Crear Cliente' }}
                            </button>
                            <a href="{{ route('clients') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
