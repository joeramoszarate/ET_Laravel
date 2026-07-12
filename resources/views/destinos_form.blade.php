<x-app-layout>
    <x-slot name="header">
        Nuevo Destino
    </x-slot>

    <div class="position-relative" style="min-height: calc(100vh - 160px);">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.35); z-index: 0;"></div>

        <div class="d-flex justify-content-center align-items-center h-100" style="position: relative; z-index: 1;">
            <div class="card shadow-lg" style="max-width: 780px; width: 100%; border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h3 class="mb-1">Nuevo Destino</h3>
                            <p class="text-muted mb-0">Completa la información del destino turístico</p>
                        </div>
                        <a href="{{ route('destinos') }}" class="btn btn-light btn-sm">×</a>
                    </div>

                    <form action="{{ route('destinos.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre del Destino *</label>
                                <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ej: Punta Sal" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="categoria" class="form-label">Tipo de Destino *</label>
                                <input type="text" name="categoria" id="categoria" class="form-control @error('categoria') is-invalid @enderror" value="{{ old('categoria') }}" placeholder="Ej: Playa, Naturaleza" required>
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Ubicación *</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion') }}" placeholder="Ubicación exacta del destino" required>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label for="temperatura_prom" class="form-label">Clima</label>
                                <input type="text" name="temperatura_prom" id="temperatura_prom" class="form-control @error('temperatura_prom') is-invalid @enderror" value="{{ old('temperatura_prom') }}" placeholder="Ej: 26°C – 32°C">
                                @error('temperatura_prom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="imagen_url" class="form-label">URL de Imagen *</label>
                                <input type="text" name="imagen_url" id="imagen_url" class="form-control @error('imagen_url') is-invalid @enderror" value="{{ old('imagen_url') }}" placeholder="https://..." required>
                                @error('imagen_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-12">
                                <label for="descripcion_extra" class="form-label">Descripción adicional</label>
                                <textarea name="descripcion_extra" id="descripcion_extra" rows="3" class="form-control" placeholder="Descripción detallada del destino">{{ old('descripcion_extra') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('destinos') }}" class="btn btn-light">Cancelar</a>
                            <button type="submit" class="btn btn-success">Crear Destino</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
