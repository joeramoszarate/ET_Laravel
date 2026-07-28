<x-app-layout>
    <x-slot name="header">Gestión de Paquetes</x-slot>

    <div class="card">
        <div class="card-body">
            <h3 class="mb-1">Lista de Paquetes</h3>
            <p class="text-muted">Administra los paquetes turísticos</p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

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
                                <td style="width:160px;">
                                    @if($paquete->imagen_url)
                                        <img src="{{ $paquete->imagen_url }}" alt="{{ $paquete->nombre_paquete }}"
                                             class="img-fluid rounded" style="max-height:70px;object-fit:cover;width:130px;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                             style="height:70px;width:130px;font-size:0.75rem;color:#aaa;">Sin imagen</div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $paquete->nombre_paquete }}</strong>
                                    <div class="text-muted small">ID: {{ $paquete->id_paquete }}</div>
                                </td>
                                <td>{{ $paquete->descripcion }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary btn-editar-paquete"
                                            data-json="{{ route('paquetes.editJson', $paquete->id_paquete) }}"
                                            data-update="{{ route('paquetes.update', $paquete->id_paquete) }}"
                                            title="Editar">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No hay paquetes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Editar Paquete -->
    <div class="modal fade" id="modalEditarPaquete" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius:12px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold">Editar Paquete</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formEditarPaquete" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body pt-2">
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Nombre del Paquete *</label>
                            <input type="text" name="nombre_paquete" id="paq_nombre" class="form-control" required maxlength="150">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Descripción</label>
                            <textarea name="descripcion" id="paq_descripcion" rows="3" class="form-control" maxlength="255"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label small font-weight-bold">Nueva Imagen</label>
                                <div class="custom-file">
                                    <input type="file" name="imagen" id="paq_imagen" accept="image/jpg,image/jpeg,image/png,image/webp"
                                           class="custom-file-input" onchange="previewPaquete(this)">
                                    <label class="custom-file-label" for="paq_imagen">Seleccionar archivo...</label>
                                </div>
                                <small class="text-muted">JPG, PNG o WEBP · Máx 4MB</small>
                            </div>
                            <div class="col-md-6 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <img id="paq_preview" src="" alt="Vista previa"
                                         style="max-height:120px;max-width:100%;border-radius:8px;object-fit:cover;display:none;">
                                    <img id="paq_current" src="" alt="Imagen actual"
                                         style="max-height:120px;max-width:100%;border-radius:8px;object-fit:cover;">
                                    <div class="text-muted small mt-1" id="paq_img_label">Imagen actual</div>
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
        document.querySelectorAll('.btn-editar-paquete').forEach(function(btn) {
            btn.addEventListener('click', function() {
                fetch(this.dataset.json, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(function(d) {
                        document.getElementById('paq_nombre').value      = d.nombre_paquete || '';
                        document.getElementById('paq_descripcion').value = d.descripcion    || '';

                        var cur = document.getElementById('paq_current');
                        var pre = document.getElementById('preview_paquete') || document.getElementById('paq_preview');
                        cur.src = d.imagen_url || '';
                        cur.style.display = d.imagen_url ? 'inline-block' : 'none';
                        pre.style.display = 'none';
                        document.getElementById('paq_img_label').textContent = 'Imagen actual';
                        document.getElementById('paq_imagen').value = '';
                        document.querySelector('#modalEditarPaquete .custom-file-label').textContent = 'Seleccionar archivo...';

                        document.getElementById('formEditarPaquete').action = btn.dataset.update;
                        $('#modalEditarPaquete').modal('show');
                    });
            });
        });

        function previewPaquete(input) {
            document.querySelector('#modalEditarPaquete .custom-file-label').textContent =
                input.files[0] ? input.files[0].name : 'Seleccionar archivo...';
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var pre = document.getElementById('paq_preview');
                    var cur = document.getElementById('paq_current');
                    pre.src = e.target.result;
                    pre.style.display = 'inline-block';
                    cur.style.display = 'none';
                    document.getElementById('paq_img_label').textContent = 'Nueva imagen';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
