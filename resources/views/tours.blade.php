<x-app-layout>
<x-slot name="header">
<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
    <div>
        <h2 style="font-size:1.4rem;font-weight:800;color:#1e3a5f;margin:0;">Gestión de Tours</h2>
        <p style="color:#64748b;font-size:0.85rem;margin:4px 0 0;">Administra todos los paquetes turísticos disponibles</p>
    </div>
    <a href="{{ route('tours.create') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#fff;border:1.5px solid #d1d5db;color:#374151;font-size:0.875rem;font-weight:600;border-radius:8px;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Agregar Nuevo Tour
    </a>
</div>
</x-slot>

<style>
    .tour-table th{padding:11px 14px;font-size:0.78rem;font-weight:700;color:#64748b;text-align:left;border-bottom:2px solid #f1f5f9;white-space:nowrap;}
    .tour-table td{padding:13px 14px;font-size:0.875rem;color:#374151;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .tour-table tr:hover td{background:#f8fafc;}
    .cat-badge{display:inline-block;padding:3px 10px;border-radius:5px;font-size:0.72rem;font-weight:700;color:#fff;}
    .action-btn{background:none;border:none;cursor:pointer;padding:5px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;transition:background 0.15s;}
    .action-btn:hover{background:#f1f5f9;}
    @media(max-width:768px){
        .tour-table{font-size:0.8rem;}
        .tour-table th,.tour-table td{padding:9px 8px;}
    }
</style>

<div style="padding:24px;background:#f8fafc;min-height:calc(100vh - 120px);">

    @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #86efac;color:#16a34a;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:0.875rem;font-weight:500;">
        ✓ {{ session('success') }}
    </div>
    @endif

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">

        {{-- Buscador --}}
        <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <form method="GET" action="{{ route('tours') }}" style="display:flex;align-items:center;gap:8px;flex:1;min-width:200px;">
                <div style="position:relative;max-width:320px;width:100%;">
                    <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar tours por nombre o destino..."
                        style="width:100%;padding:8px 12px 8px 34px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.875rem;outline:none;color:#374151;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">
                </div>
                <button type="submit" style="display:none;"></button>
            </form>
            <span style="background:#f0f4f8;color:#64748b;font-size:0.78rem;font-weight:600;padding:4px 12px;border-radius:999px;">
                {{ $tours->count() }} tours
            </span>
        </div>

        {{-- Tabla --}}
        <div style="overflow-x:auto;">
            <table class="tour-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th style="color:#f59e0b;">Destino</th>
                        <th style="color:#f59e0b;">Categoría</th>
                        <th style="color:#1d6fa4;">Duración</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th style="text-align:right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tours as $i => $tour)
                    @php
                        $catColors = ['Full Day'=>'#16a34a','Aventura'=>'#16a34a','Paquete Nacional'=>'#16a34a','Eco-turismo'=>'#0891b2','Cultural'=>'#7c3aed'];
                        $catNombre = $tour->categoria->descripcion ?? 'General';
                        $catColor  = $catColors[$catNombre] ?? '#16a34a';
                    @endphp
                    <tr>
                        <td style="color:#94a3b8;font-weight:600;font-size:0.8rem;">{{ $i + 1 }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                {{-- Miniatura --}}
                                <div style="width:44px;height:36px;border-radius:6px;overflow:hidden;flex-shrink:0;background:#e2e8f0;">
                                    @if($tour->imagen_url)
                                        <img src="{{ $tour->imagen_url }}" alt="{{ $tour->nombre_tour }}" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <div style="width:100%;height:100%;background:linear-gradient(135deg,#1d6fa4,#2d9e6b);display:flex;align-items:center;justify-content:center;">
                                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.7)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <span style="font-weight:600;color:#1e293b;">{{ Str::limit($tour->nombre_tour, 28) }}</span>
                            </div>
                        </td>
                        <td>
                            @if($tour->destino)
                                <span style="color:#f59e0b;font-weight:500;">{{ $tour->destino->nombre }}, Tumbes</span>
                            @else
                                <span style="color:#94a3b8;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="cat-badge" style="background:{{ $catColor }};">{{ $catNombre }}</span>
                        </td>
                        <td style="color:#1d6fa4;font-weight:600;">
                            {{ $tour->duracion_dias ?? 1 }} {{ ($tour->duracion_dias ?? 1) == 1 ? 'día' : 'días' }}
                        </td>
                        <td style="font-weight:700;color:#1e293b;">
                            ${{ number_format($tour->precio, 0) }}
                        </td>
                        <td>
                            @if($tour->estado === 'activo')
                                <span style="display:inline-block;padding:3px 10px;background:#dcfce7;color:#16a34a;font-size:0.72rem;font-weight:700;border-radius:5px;">activo</span>
                            @else
                                <span style="display:inline-block;padding:3px 10px;background:#fee2e2;color:#dc2626;font-size:0.72rem;font-weight:700;border-radius:5px;">inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;justify-content:flex-end;gap:2px;">
                                {{-- Ver --}}
                                <button class="action-btn" title="Ver detalle" onclick="verTour({{ json_encode(['id'=>$tour->id_tour,'nombre'=>$tour->nombre_tour,'destino'=>$tour->destino->nombre??'—','precio'=>$tour->precio,'duracion'=>$tour->duracion_dias,'descripcion'=>$tour->descripcion,'ubicacion'=>$tour->ubicacion_exacta,'estado'=>$tour->estado]) }})">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#64748b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                {{-- Editar --}}
                                <button class="action-btn btn-editar-tour"
                                        data-json="{{ route('tours.editJson', $tour->id_tour) }}"
                                        data-update="{{ route('tours.update', $tour->id_tour) }}"
                                        title="Editar">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#64748b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                {{-- Eliminar --}}
                                <form method="POST" action="{{ route('tours.destroy', $tour->id_tour) }}" style="display:inline;" onsubmit="return confirm('¿Eliminar el tour «{{ $tour->nombre_tour }}»?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn" title="Eliminar">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path stroke-linecap="round" stroke-linejoin="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:48px;color:#94a3b8;">
                            <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="#cbd5e1" stroke-width="1.5" style="display:block;margin:0 auto 10px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064"/></svg>
                            No hay tours disponibles
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Ver Tour --}}
<div id="modalTour" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;padding:28px;max-width:480px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.2);position:relative;">
        <button onclick="cerrarModal()" style="position:absolute;top:14px;right:14px;background:none;border:none;cursor:pointer;color:#94a3b8;font-size:1.2rem;">✕</button>
        <h3 id="modalNombre" style="font-size:1.1rem;font-weight:800;color:#1e3a5f;margin:0 0 16px;padding-right:24px;"></h3>
        <div id="modalBody" style="font-size:0.875rem;color:#374151;line-height:1.7;"></div>
    </div>
</div>

<script>
function verTour(data) {
    document.getElementById('modalNombre').textContent = data.nombre;
    document.getElementById('modalBody').innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;">
            <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Destino</span><strong>${data.destino}</strong></div>
            <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Precio</span><strong style="color:#1d6fa4;">$${parseFloat(data.precio).toFixed(0)}</strong></div>
            <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Duración</span><strong>${data.duracion} día(s)</strong></div>
            <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Estado</span><strong>${data.estado}</strong></div>
        </div>
        <div style="margin-bottom:10px;"><span style="color:#94a3b8;font-size:0.75rem;display:block;">Ubicación</span>${data.ubicacion}</div>
        <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Descripción</span>${data.descripcion}</div>
    `;
    const modal = document.getElementById('modalTour');
    modal.style.display = 'flex';
}
function cerrarModal() {
    document.getElementById('modalTour').style.display = 'none';
}
document.getElementById('modalTour').addEventListener('click', function(e) {
    if (e.target === this) cerrarModal();
});
// Búsqueda en tiempo real
document.querySelector('input[name="busqueda"]').addEventListener('input', function() {
    clearTimeout(this._t);
    this._t = setTimeout(() => this.closest('form').submit(), 400);
});
</script>

{{-- Modal Editar Tour --}}
<div class="modal fade" id="modalEditarTour" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:12px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold">Editar Tour</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formEditarTour" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body pt-2">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small font-weight-bold">Nombre del Tour *</label>
                            <input type="text" name="nombre_tour" id="tour_nombre" class="form-control" required maxlength="150">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small font-weight-bold">Destino *</label>
                            <select name="id_destino" id="tour_destino" class="form-control" required>
                                @foreach($destinos as $d)
                                    <option value="{{ $d->id_destino }}">{{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small font-weight-bold">Categoría *</label>
                            <select name="id_catto" id="tour_categoria" class="form-control" required>
                                @foreach($categorias as $c)
                                    <option value="{{ $c->id_catto }}">{{ $c->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label small font-weight-bold">Precio ($) *</label>
                            <input type="number" name="precio" id="tour_precio" class="form-control" required min="0" step="0.01">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label small font-weight-bold">Duración (días) *</label>
                            <input type="number" name="duracion_dias" id="tour_duracion" class="form-control" required min="1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label small font-weight-bold">Ubicación exacta *</label>
                            <input type="text" name="ubicacion_exacta" id="tour_ubicacion" class="form-control" required maxlength="150">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small font-weight-bold">Estado *</label>
                            <select name="estado" id="tour_estado" class="form-control" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small font-weight-bold">Descripción *</label>
                        <textarea name="descripcion" id="tour_descripcion" rows="3" class="form-control" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label small font-weight-bold">Nueva Imagen</label>
                            <div class="custom-file">
                                <input type="file" name="imagen" id="tour_imagen" accept="image/jpg,image/jpeg,image/png,image/webp"
                                       class="custom-file-input" onchange="previewTour(this)">
                                <label class="custom-file-label" for="tour_imagen">Seleccionar archivo...</label>
                            </div>
                            <small class="text-muted">JPG, PNG o WEBP · Máx 4MB</small>
                        </div>
                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <img id="tour_preview" src="" alt="Vista previa"
                                     style="max-height:120px;max-width:100%;border-radius:8px;object-fit:cover;display:none;">
                                <img id="tour_current" src="" alt="Imagen actual"
                                     style="max-height:120px;max-width:100%;border-radius:8px;object-fit:cover;">
                                <div class="text-muted small mt-1" id="tour_img_label">Imagen actual</div>
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
document.querySelectorAll('.btn-editar-tour').forEach(function(btn) {
    btn.addEventListener('click', function() {
        fetch(this.dataset.json, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(function(d) {
                document.getElementById('tour_nombre').value      = d.nombre_tour      || '';
                document.getElementById('tour_precio').value      = d.precio           || '';
                document.getElementById('tour_duracion').value    = d.duracion_dias    || '';
                document.getElementById('tour_ubicacion').value   = d.ubicacion_exacta || '';
                document.getElementById('tour_descripcion').value = d.descripcion      || '';

                var sel = document.getElementById('tour_destino');
                for (var i = 0; i < sel.options.length; i++) {
                    if (sel.options[i].value == d.id_destino) { sel.selectedIndex = i; break; }
                }
                var selC = document.getElementById('tour_categoria');
                for (var i = 0; i < selC.options.length; i++) {
                    if (selC.options[i].value == d.id_catto) { selC.selectedIndex = i; break; }
                }
                var selE = document.getElementById('tour_estado');
                for (var i = 0; i < selE.options.length; i++) {
                    if (selE.options[i].value == d.estado) { selE.selectedIndex = i; break; }
                }

                var cur = document.getElementById('tour_current');
                var pre = document.getElementById('tour_preview');
                cur.src = d.imagen_url || '';
                cur.style.display = d.imagen_url ? 'inline-block' : 'none';
                pre.style.display = 'none';
                document.getElementById('tour_img_label').textContent = 'Imagen actual';
                document.getElementById('tour_imagen').value = '';
                document.querySelector('#modalEditarTour .custom-file-label').textContent = 'Seleccionar archivo...';

                document.getElementById('formEditarTour').action = btn.dataset.update;
                $('#modalEditarTour').modal('show');
            });
    });
});

function previewTour(input) {
    document.querySelector('#modalEditarTour .custom-file-label').textContent =
        input.files[0] ? input.files[0].name : 'Seleccionar archivo...';
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var pre = document.getElementById('tour_preview');
            var cur = document.getElementById('tour_current');
            pre.src = e.target.result;
            pre.style.display = 'inline-block';
            cur.style.display = 'none';
            document.getElementById('tour_img_label').textContent = 'Nueva imagen';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</x-app-layout>
