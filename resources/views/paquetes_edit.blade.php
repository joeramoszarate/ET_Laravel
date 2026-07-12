<x-app-layout>
    <x-slot name="header">
        Editar Paquete
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h3 class="mb-1">Editar Paquete</h3>

            <form action="{{ route('paquetes.update', $paquete->id_paquete) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="nombre_paquete" class="form-control" value="{{ old('nombre_paquete', $paquete->nombre_paquete) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" rows="3" class="form-control">{{ old('descripcion', $paquete->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen (subir desde tu equipo)</label>
                    <input type="file" name="imagen" class="form-control">
                    @if($paquete->imagen_url)
                        <div class="mt-2">
                            <img src="{{ $paquete->imagen_url }}" alt="imagen actual" style="max-width:200px; max-height:150px; object-fit:cover;">
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('paquetes') }}" class="btn btn-light">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
