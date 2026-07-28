<x-app-layout>
    <x-slot name="header">Gestión de Destinos</x-slot>

    <div class="mb-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3 class="mb-1">Listado de Destinos</h3>
                <p class="text-muted">Administra los destinos turísticos de la región de Tumbes</p>
            </div>
            <a href="{{ route('destinos.create') }}" class="btn btn-success">
                <i class="fas fa-plus mr-2"></i>Nuevo Destino
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
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
                                    <td style="width:130px;">
                                        <img src="{{ $destino->imagen_url }}" alt="{{ $destino->nombre }}"
                                             class="img-fluid rounded" style="max-height:70px;object-fit:cover;width:130px;">
                                    </td>
                                    <td>
                                        <strong>{{ $destino->nombre }}</strong>
                                        <div class="text-muted small">ID: {{ $destino->id_destino }}</div>
                                    </td>
                                    <td><span class="badge bg-primary">{{ $destino->categoria }}</span></td>
                                    <td>{{ $destino->descripcion }}</td>
                                    <td>{{ $destino->temperatura_prom ?? 'N/A' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary btn-editar"
                                                data-id="{{ $destino->id_destino }}"
                                                data-url="{{ route('destinos.edit', $destino->id_destino) }}"
                                                data-update="{{ route('destinos.update', $destino->id_destino) }}"
                                                title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('destinos.destroy', $destino->id_destino) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar el destino {{ addslashes($destino->nombre) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No hay destinos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Destino -->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius:12px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">Editar Destino</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formEditar" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <div class="modal-body pt-2">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small font-weight-bold">Nombre del Destino *</label>
                                <input type="text" name="nombre" id="edit_nombre" class="form-control" required maxlength="18">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small font-weight-bold">Tipo / Categoría *</label>
                                <input type="text" name="categoria" id="edit_categoria" class="form-control" required maxlength="18">
                            </div>
                        </div>
                        <div class="row g-3 mt-1">
                            <div class="col-md-8">
                                <label class="form-label small font-weight-bold">Ubicación *</label>
                                <input type="text" name="descripcion" id="edit_descripcion" class="form-control" required maxlength="18">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small font-weight-bold">Clima</label>
                                <input type="text" name="temperatura_prom" id="edit_temperatura" class="form-control" maxlength="18" placeholder="Ej: 26°C – 32°C">
                            </div>
                        </div>
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label small font-weight-bold">Nueva Imagen</label>
                                <div class="custom-file">
                                    <input type="file" name="imagen" id="edit_imagen" accept="image/jpg,image/jpeg,image/png,image/webp"
                                           class="custom-file-input" onchange="previewImagen(this)">
                                    <label class="custom-file-label" for="edit_imagen">Seleccionar archivo...</label>
                                </div>
                                <small class="text-muted">JPG, PNG o WEBP · Máx 4MB</small>
                            </div>
                            <div class="col-md-6 d-flex align-items-center justify-content-center">
                                <div id="preview-container" class="text-center">
                                    <img id="preview_imagen" src="" alt="Vista previa"
                                         style="max-height:120px;max-width:100%;border-radius:8px;object-fit:cover;display:none;">
                                    <img id="current_imagen" src="" alt="Imagen actual"
                                         style="max-height:120px;max-width:100%;border-radius:8px;object-fit:cover;">
                                    <div class="text-muted small mt-1" id="preview_label">Imagen actual</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-editar').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var url    = this.dataset.url;
                var update = this.dataset.update;

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(function(d) {
                        document.getElementById('edit_nombre').value      = d.nombre      || '';
                        document.getElementById('edit_categoria').value   = d.categoria   || '';
                        document.getElementById('edit_descripcion').value = d.descripcion || '';
                        document.getElementById('edit_temperatura').value = d.temperatura_prom || '';

                        var cur = document.getElementById('current_imagen');
                        var pre = document.getElementById('preview_imagen');
                        cur.src = d.imagen_url || '';
                        cur.style.display = d.imagen_url ? 'inline-block' : 'none';
                        pre.style.display = 'none';
                        document.getElementById('preview_label').textContent = 'Imagen actual';
                        document.getElementById('edit_imagen').value = '';
                        document.querySelector('.custom-file-label').textContent = 'Seleccionar archivo...';

                        document.getElementById('formEditar').action = update;
                        $('#modalEditar').modal('show');
                    });
            });
        });

        function previewImagen(input) {
            var label = document.querySelector('.custom-file-label');
            label.textContent = input.files[0] ? input.files[0].name : 'Seleccionar archivo...';

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var pre = document.getElementById('preview_imagen');
                    var cur = document.getElementById('current_imagen');
                    pre.src = e.target.result;
                    pre.style.display = 'inline-block';
                    cur.style.display = 'none';
                    document.getElementById('preview_label').textContent = 'Nueva imagen';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
