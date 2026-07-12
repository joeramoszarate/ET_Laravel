<x-app-layout>
    <x-slot name="header">
        Gestión de Paquetes
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h3 class="mb-1">Lista de Paquetes</h3>
            <p class="text-muted">Administra los paquetes turísticos</p>

            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paquetes as $paquete)
                            <tr>
                                <td style="width: 160px;">
                                    @if($paquete->imagen_url)
                                        <img src="{{ $paquete->imagen_url }}" alt="{{ $paquete->nombre_paquete }}" class="img-fluid rounded" style="max-height:70px; object-fit:cover; width:130px;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:70px; width:130px;">No imagen</div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $paquete->nombre_paquete }}</strong>
                                    <div class="text-muted small">ID: {{ $paquete->id_paquete }}</div>
                                </td>
                                <td>{{ $paquete->descripcion }}</td>
                                <td>
                                    <a href="{{ route('paquetes.edit', $paquete->id_paquete) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i> Editar</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No hay paquetes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        Paquetes
    </x-slot>

    <div class="card">
        <div class="card-body">
            <p>Esta es la página de Paquetes.</p>
        </div>
    </div>
</x-app-layout>
