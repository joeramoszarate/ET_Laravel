<x-app-layout>
    <x-slot name="header">Gestión de Usuarios</x-slot>

    <style>
        .uv-title    { font-size:1.6rem;font-weight:800;color:#1a73e8;margin-bottom:2px; }
        .uv-subtitle { color:#888;font-size:0.88rem;margin-bottom:1.2rem; }
        /* Métricas */
        .uv-metric   { background:#fff;border:1px solid #e8edf3;border-radius:10px;padding:18px 22px; }
        .uv-metric-lbl { font-size:0.78rem;color:#888;margin-bottom:4px; }
        .uv-metric-val { font-size:2rem;font-weight:800;line-height:1; }
        .uv-metric-sub { font-size:0.78rem;color:#888;margin-top:4px; }
        /* Tabs */
        .uv-tabs  { display:flex;background:#f0f4f8;border-radius:8px;padding:4px;margin-bottom:1.2rem;gap:2px; }
        .uv-tab   { flex:1;text-align:center;padding:8px 0;border-radius:6px;cursor:pointer;font-size:0.9rem;color:#555;border:none;background:transparent;font-weight:500;transition:all .2s; }
        .uv-tab.active { background:#fff;color:#1a73e8;font-weight:700;box-shadow:0 1px 4px rgba(0,0,0,.1); }
        /* Tabla */
        .uv-table th { font-size:0.78rem;color:#888;font-weight:600;padding:10px 14px;border-bottom:1px solid #f0f4f8; }
        .uv-table td { font-size:0.85rem;padding:12px 14px;border-bottom:1px solid #f5f7fa;vertical-align:middle; }
        .uv-table tr:last-child td { border-bottom:none; }
        .uv-table tr:hover td { background:#fafbff; }
        /* Badges rol */
        .rol-admin  { background:#fee2e2;color:#dc2626;padding:3px 10px;border-radius:5px;font-size:0.72rem;font-weight:700; }
        .rol-guia   { background:#dcfce7;color:#16a34a;padding:3px 10px;border-radius:5px;font-size:0.72rem;font-weight:700; }
        .rol-cliente{ background:#fef9c3;color:#ca8a04;padding:3px 10px;border-radius:5px;font-size:0.72rem;font-weight:700; }
        .rol-otro   { background:#e0e7ff;color:#4338ca;padding:3px 10px;border-radius:5px;font-size:0.72rem;font-weight:700; }
        .badge-activo   { background:#dcfce7;color:#16a34a;padding:3px 12px;border-radius:5px;font-size:0.72rem;font-weight:700; }
        .badge-inactivo { background:#fee2e2;color:#dc2626;padding:3px 12px;border-radius:5px;font-size:0.72rem;font-weight:700; }
        /* Acción */
        .act-btn { background:none;border:none;cursor:pointer;padding:5px 7px;border-radius:6px;transition:background .15s; }
        .act-btn:hover { background:#f1f5f9; }
        /* Avatar */
        .uv-avatar { width:36px;height:36px;border-radius:50%;background:#e0e7ff;display:flex;align-items:center;justify-content:center;color:#4338ca;font-size:1rem;flex-shrink:0; }
        /* Search */
        .uv-search { position:relative; }
        .uv-search input { padding:9px 12px 9px 36px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.875rem;width:100%;outline:none; }
        .uv-search input:focus { border-color:#1a73e8; }
        .uv-search .ico { position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#94a3b8; }
    </style>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3">
            {{ session('success') }}<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            {{ session('error') }}<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
        <div>
            <div class="uv-title">Gestión de Usuarios</div>
            <div class="uv-subtitle">Administra usuarios, clientes, guías y administradores del sistema</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('usuarios.vista', array_merge(request()->query(), ['export'=>1])) }}"
               class="btn btn-outline-secondary btn-sm font-weight-600">
                <i class="fas fa-download mr-1"></i> Exportar
            </a>
            <button class="btn btn-success btn-sm font-weight-bold" data-toggle="modal" data-target="#modalNuevoUsuario">
                <i class="fas fa-plus mr-1"></i> Nuevo Usuario
            </button>
        </div>
    </div>

    {{-- Métricas --}}
    <div class="row mb-3">
        <div class="col-6 col-md-3 mb-3">
            <div class="uv-metric">
                <div class="uv-metric-lbl">Total Usuarios</div>
                <div class="uv-metric-val" style="color:#1a73e8;">{{ $total }}</div>
                <div class="uv-metric-sub">{{ $totalActivos }} activos</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="uv-metric">
                <div class="uv-metric-lbl">Clientes</div>
                <div class="uv-metric-val" style="color:#ca8a04;">{{ $countClientes }}</div>
                <div class="uv-metric-sub">Usuarios registrados</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="uv-metric">
                <div class="uv-metric-lbl">Guías</div>
                <div class="uv-metric-val" style="color:#16a34a;">{{ $countGuias }}</div>
                <div class="uv-metric-sub">Guías certificados</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="uv-metric">
                <div class="uv-metric-lbl" style="color:#1a73e8;">Administradores</div>
                <div class="uv-metric-val" style="color:#dc2626;">{{ $countAdmins }}</div>
                <div class="uv-metric-sub">Con acceso total</div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="uv-tabs">
        <button class="uv-tab active" onclick="filtrarTab('todos', this)">Todos</button>
        <button class="uv-tab" onclick="filtrarTab('cliente', this)">Clientes</button>
        <button class="uv-tab" onclick="filtrarTab('guia', this)">Guías</button>
        <button class="uv-tab" onclick="filtrarTab('admin', this)">Administradores</button>
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            {{-- Buscador + filtros --}}
            <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                <form method="GET" action="{{ route('usuarios.vista') }}" class="d-flex align-items-center gap-2 flex-wrap flex-grow-1" id="formBusqueda">
                    <div class="uv-search flex-grow-1" style="max-width:340px;">
                        <i class="fas fa-search ico"></i>
                        <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar usuarios..."
                               oninput="clearTimeout(this._t);this._t=setTimeout(()=>this.closest('form').submit(),400)">
                    </div>
                    <select name="rol" class="form-control form-control-sm" style="width:auto;" onchange="this.closest('form').submit()">
                        <option value="todos" {{ $filtroRol==='todos'?'selected':'' }}>Todos los roles</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->descripcion }}" {{ $filtroRol===$r->descripcion?'selected':'' }}>
                                {{ ucfirst($r->descripcion) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="estado" class="form-control form-control-sm" style="width:auto;" onchange="this.closest('form').submit()">
                        <option value="">Todos</option>
                        <option value="activo" {{ request('estado')==='activo'?'selected':'' }}>Activo</option>
                        <option value="inactivo" {{ request('estado')==='inactivo'?'selected':'' }}>Inactivo</option>
                    </select>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table uv-table mb-0" id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Contacto</th>
                            <th>Rol</th>
                            <th>Registro</th>
                            <th>Último Acceso</th>
                            <th>Actividad</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $u)
                            @php
                                $rolDesc = strtolower($u->rol->descripcion ?? '');
                                $rolClass = str_contains($rolDesc,'admin') ? 'rol-admin'
                                    : (str_contains($rolDesc,'guia')||str_contains($rolDesc,'guía') ? 'rol-guia'
                                    : (str_contains($rolDesc,'cliente') ? 'rol-cliente' : 'rol-otro'));
                                $act = $actividad[$u->id_usuario] ?? null;
                            @endphp
                            <tr data-rol="{{ $rolDesc }}">
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="uv-avatar"><i class="fas fa-user"></i></div>
                                        <div>
                                            <div class="font-weight-bold" style="color:#1a1a1a;">{{ $u->nombre }} {{ $u->apellidos }}</div>
                                            <div style="font-size:0.78rem;color:#888;">{{ $u->correo }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-size:0.82rem;color:#555;">
                                        <i class="fas fa-phone-alt mr-1" style="color:#94a3b8;font-size:0.75rem;"></i>
                                        {{ $u->telefono ?? '—' }}
                                    </span>
                                </td>
                                <td><span class="{{ $rolClass }}">{{ ucfirst($u->rol->descripcion ?? 'Sin rol') }}</span></td>
                                <td style="font-size:0.82rem;color:#555;">{{ $u->fecha_registro ?? '—' }}</td>
                                <td style="font-size:0.82rem;color:#555;">—</td>
                                <td style="font-size:0.82rem;">
                                    <div style="color:#1a73e8;font-weight:600;">{{ $act ? $act->total_reservas : 0 }} reservas</div>
                                    <div style="color:#888;">S/ {{ $act ? number_format($act->total_monto, 0) : 0 }}</div>
                                </td>
                                <td>
                                    @if(strtolower($u->estado ?? 'activo') === 'activo')
                                        <span class="badge-activo">Activo</span>
                                    @else
                                        <span class="badge-inactivo">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{-- Ver --}}
                                    <button class="act-btn btn-ver-usuario"
                                            data-json="{{ route('usuarios.editJson', $u->id_usuario) }}"
                                            title="Ver detalle">
                                        <i class="fas fa-eye" style="color:#64748b;"></i>
                                    </button>
                                    {{-- Editar --}}
                                    <button class="act-btn btn-editar-usuario"
                                            data-json="{{ route('usuarios.editJson', $u->id_usuario) }}"
                                            data-update="{{ route('usuarios.update', $u->id_usuario) }}"
                                            title="Editar">
                                        <i class="fas fa-pencil-alt" style="color:#64748b;"></i>
                                    </button>
                                    {{-- Eliminar --}}
                                    <form method="POST" action="{{ route('usuarios.destroy', $u->id_usuario) }}"
                                          class="d-inline" onsubmit="return confirm('¿Eliminar a {{ addslashes($u->nombre) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="act-btn" title="Eliminar">
                                            <i class="fas fa-trash-alt" style="color:#dc2626;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Nuevo Usuario --}}
    <div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius:12px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-weight-bold">Nuevo Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('usuarios.store') }}">
                    @csrf
                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Nombre *</label>
                                <input type="text" name="nombre" class="form-control" required maxlength="18">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" maxlength="18">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Correo *</label>
                                <input type="text" name="correo" class="form-control" required maxlength="18">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" maxlength="18">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label small font-weight-bold">Rol *</label>
                                <select name="id_tiprol" class="form-control" required>
                                    @foreach($roles as $r)
                                        <option value="{{ $r->id_tiprol }}">{{ ucfirst($r->descripcion) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small font-weight-bold">Tipo Documento *</label>
                                <select name="id_tipdoc" class="form-control" required>
                                    @foreach(\App\Models\TipoDocumento::all() as $td)
                                        <option value="{{ $td->id_tipdoc }}">{{ $td->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small font-weight-bold">Nro. Documento</label>
                                <input type="text" name="nro_documento" class="form-control" maxlength="18">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Contraseña *</label>
                                <input type="password" name="contraseña" class="form-control" required maxlength="18">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Estado *</label>
                                <select name="estado" class="form-control" required>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success font-weight-bold">Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Editar Usuario --}}
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border-radius:12px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-weight-bold">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formEditarUsuario" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body pt-0">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Nombre *</label>
                                <input type="text" name="nombre" id="eu_nombre" class="form-control" required maxlength="18">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Apellidos</label>
                                <input type="text" name="apellidos" id="eu_apellidos" class="form-control" maxlength="18">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Correo *</label>
                                <input type="text" name="correo" id="eu_correo" class="form-control" required maxlength="18">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Teléfono</label>
                                <input type="text" name="telefono" id="eu_telefono" class="form-control" maxlength="18">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Dirección</label>
                                <input type="text" name="direccion" id="eu_direccion" class="form-control" maxlength="18">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small font-weight-bold">Rol *</label>
                                <select name="id_tiprol" id="eu_rol" class="form-control" required>
                                    @foreach($roles as $r)
                                        <option value="{{ $r->id_tiprol }}">{{ ucfirst($r->descripcion) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Estado *</label>
                            <select name="estado" id="eu_estado" class="form-control" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success font-weight-bold">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Ver Usuario --}}
    <div class="modal fade" id="modalVerUsuario" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius:12px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-weight-bold">Detalle de Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" id="verUsuarioBody"></div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filtro por tab (client-side)
        function filtrarTab(tipo, el) {
            document.querySelectorAll('.uv-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            document.querySelectorAll('#tablaUsuarios tbody tr').forEach(function(tr) {
                if (tipo === 'todos') { tr.style.display = ''; return; }
                var rol = tr.dataset.rol || '';
                tr.style.display = rol.includes(tipo) ? '' : 'none';
            });
        }

        // Modal Editar
        document.querySelectorAll('.btn-editar-usuario').forEach(function(btn) {
            btn.addEventListener('click', function() {
                fetch(this.dataset.json, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(function(d) {
                        document.getElementById('eu_nombre').value    = d.nombre    || '';
                        document.getElementById('eu_apellidos').value = d.apellidos || '';
                        document.getElementById('eu_correo').value    = d.correo    || '';
                        document.getElementById('eu_telefono').value  = d.telefono  || '';
                        document.getElementById('eu_direccion').value = d.direccion || '';

                        var selRol = document.getElementById('eu_rol');
                        for (var i = 0; i < selRol.options.length; i++) {
                            if (selRol.options[i].value == d.id_tiprol) { selRol.selectedIndex = i; break; }
                        }
                        var selEst = document.getElementById('eu_estado');
                        for (var i = 0; i < selEst.options.length; i++) {
                            if (selEst.options[i].value == (d.estado || 'activo')) { selEst.selectedIndex = i; break; }
                        }

                        document.getElementById('formEditarUsuario').action = btn.dataset.update;
                        $('#modalEditarUsuario').modal('show');
                    });
            });
        });

        // Modal Ver
        document.querySelectorAll('.btn-ver-usuario').forEach(function(btn) {
            btn.addEventListener('click', function() {
                fetch(this.dataset.json, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.json())
                    .then(function(d) {
                        document.getElementById('verUsuarioBody').innerHTML = `
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:0.875rem;">
                                <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Nombre</span><strong>${(d.nombre||'')+' '+(d.apellidos||'')}</strong></div>
                                <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Correo</span>${d.correo||'—'}</div>
                                <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Teléfono</span>${d.telefono||'—'}</div>
                                <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Dirección</span>${d.direccion||'—'}</div>
                                <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Rol</span>${d.rol ? d.rol.descripcion : '—'}</div>
                                <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Estado</span>${d.estado||'—'}</div>
                                <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Nro. Documento</span>${d.nro_documento||'—'}</div>
                                <div><span style="color:#94a3b8;font-size:0.75rem;display:block;">Fecha Registro</span>${d.fecha_registro||'—'}</div>
                            </div>`;
                        $('#modalVerUsuario').modal('show');
                    });
            });
        });
    </script>
</x-app-layout>
