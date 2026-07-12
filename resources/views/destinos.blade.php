<x-app-layout>
    <x-slot name="header">
        Gestión de Destinos
    </x-slot>

    <div class="mb-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-1">Listado de Destinos</h3>
                <p class="text-muted">Administra los destinos turísticos de la región de Tumbes</p>
            </div>
            <a href="{{ route('destinos.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Nuevo Destino
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 ms-auto">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" placeholder="Buscar destinos..." disabled>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Ubicación</th>
                                <th>Clima</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($destinos as $destino)
                                <tr>
                                    <td style="width: 130px;">
                                        <img src="{{ $destino->imagen_url }}" alt="{{ $destino->nombre }}" class="img-fluid rounded" style="max-height: 70px; object-fit: cover; width: 130px;">
                                    </td>
                                    <td>
                                        <strong>{{ $destino->nombre }}</strong>
                                        <div class="text-muted small">ID: {{ $destino->id_destino }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $destino->categoria }}</span>
                                    </td>
                                    <td>{{ $destino->descripcion }}</td>
                                    <td>{{ $destino->temperatura_prom ?? 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" disabled>
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No hay destinos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
