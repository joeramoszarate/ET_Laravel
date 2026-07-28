<x-app-layout>
    <x-slot name="header">Calendario / Planning</x-slot>

    <style>
        /* ── CALENDARIO BASE ── */
        .cal-wrap        { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .cal-table       { border-collapse: collapse; min-width: 100%; table-layout: fixed; }
        .cal-table th,
        .cal-table td    { border: 1px solid var(--border); padding: 0; }

        /* Columna fija — ya no se usa, se mantiene por compatibilidad */
        .col-fixed       { display: none; }

        /* Cabecera de día */
        .day-header      { min-width: 80px; width: 80px; text-align: center; padding: 6px 2px;
                           background: var(--bg-table-head); }
        .day-header.today { background: #6d28d9 !important; color: #fff !important; }
        .day-header .dow  { font-size: 0.65rem; font-weight: 700; letter-spacing: .8px; text-transform: uppercase;
                            color: var(--text-secondary); }
        .day-header.today .dow { color: rgba(255,255,255,.8); }
        .day-header .num  { font-size: 1rem; font-weight: 800; color: var(--text-primary); line-height: 1.1; }
        .day-header.today .num { color: #fff; }
        .day-header .occ  { font-size: 0.65rem; font-weight: 700; margin-top: 2px; }
        .occ-green  { color: #16a34a; }
        .occ-orange { color: #d97706; }
        .occ-red    { color: #dc2626; }

        /* Fila separadora de paquete */
        .row-paquete td  { background: #fef3c7; color: #92400e; font-size: 0.78rem; font-weight: 700;
                           padding: 5px 10px; border-top: 2px solid #fbbf24; }
        [data-theme="dark"] .row-paquete td { background: #1c1408; color: #fbbf24; border-color: #78350f; }

        /* Fila de precio */
        .row-precio td   { font-size: 0.72rem; color: var(--text-secondary); padding: 3px 6px;
                           background: var(--bg-table-head); text-align: center; }

        /* Celda de reserva */
        .cell-reserva    { position: relative; height: 36px; padding: 0 !important; }

        /* Barra de reserva */
        .bar             { position: absolute; top: 3px; bottom: 3px; left: 2px; right: 2px;
                           border-radius: 20px; display: flex; align-items: center; padding: 0 8px;
                           cursor: pointer; overflow: hidden; white-space: nowrap;
                           font-size: 0.72rem; font-weight: 600; color: #fff;
                           transition: filter .15s, transform .1s;
                           box-shadow: 0 1px 4px rgba(0,0,0,.2); }
        .bar:hover       { filter: brightness(1.1); transform: scaleY(1.05); }
        .bar i           { margin-right: 5px; font-size: 0.75rem; flex-shrink: 0; }
        .bar .bar-dot    { position: absolute; top: 3px; right: 5px; width: 7px; height: 7px;
                           background: #ef4444; border-radius: 50%; border: 1.5px solid #fff; }

        /* Colores de barra */
        .bar-pendiente   { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .bar-confirmada  { background: linear-gradient(90deg, #10b981, #34d399); }
        .bar-cancelada   { background: linear-gradient(90deg, #ef4444, #f87171); }
        .bar-completada  { background: linear-gradient(90deg, #6b7280, #9ca3af); }

        /* Celda vacía */
        .cell-empty      { background: var(--bg-body); }

        /* ── MODAL ── */
        .modal-cal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5);
                             z-index: 1050; display: flex; align-items: center; justify-content: center; }
        .modal-cal-box     { background: var(--bg-card); border-radius: 16px; width: 100%; max-width: 520px;
                             padding: 28px; box-shadow: 0 20px 60px rgba(0,0,0,.3);
                             position: relative; max-height: 90vh; overflow-y: auto; }
        .modal-cal-close   { position: absolute; top: 16px; right: 16px; background: var(--bg-input);
                             border: 1px solid var(--border); border-radius: 50%; width: 32px; height: 32px;
                             display: flex; align-items: center; justify-content: center;
                             cursor: pointer; color: var(--text-secondary); font-size: 1rem; }
        .modal-cal-close:hover { background: var(--border); }
        .modal-section     { border-top: 1px solid var(--border); padding-top: 14px; margin-top: 14px; }
        .modal-label       { font-size: 0.72rem; color: var(--text-secondary); margin-bottom: 2px; }
        .modal-val         { font-size: 0.9rem; font-weight: 600; color: var(--text-primary); }
        .modal-val-blue    { color: var(--accent); }
        .modal-val-red     { color: #dc2626; }

        /* Filtros */
        .cal-filters       { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 16px; }
        .cal-filters select,
        .cal-filters input  { background: var(--bg-input); border: 1.5px solid var(--border-input);
                              color: var(--text-primary); border-radius: 8px; padding: 7px 12px;
                              font-size: 0.82rem; outline: none; }
        .cal-filters select:focus,
        .cal-filters input:focus { border-color: var(--accent); }

        /* Nav mes */
        .cal-nav           { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 14px; }
        .cal-nav-btn       { background: var(--bg-input); border: 1.5px solid var(--border);
                             color: var(--text-primary); border-radius: 8px; padding: 7px 14px;
                             font-size: 0.82rem; font-weight: 600; cursor: pointer; text-decoration: none;
                             transition: all .15s; }
        .cal-nav-btn:hover { border-color: var(--accent); color: var(--accent); }
        .cal-nav-btn.today { background: var(--accent); color: #fff; border-color: var(--accent); }
        .cal-nav-title     { font-size: 1.1rem; font-weight: 800; color: var(--text-primary); min-width: 160px; text-align: center; }

        /* Leyenda */
        .legend-dot        { width: 12px; height: 12px; border-radius: 50%; display: inline-block; }

        /* Timestamp */
        #ts-update         { font-size: 0.75rem; color: var(--text-secondary); }
    </style>

    {{-- ── CABECERA ── --}}
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3" style="gap:10px;">
        <div>
            <div style="font-size:1.5rem;font-weight:800;color:var(--accent);">Calendario / Planning</div>
            <div style="font-size:0.85rem;color:var(--text-secondary);">Vista Gantt de reservas activas</div>
        </div>
        <div class="d-flex align-items-center" style="gap:10px;">
            {{-- Leyenda --}}
            <div class="d-flex align-items-center" style="gap:8px;font-size:0.75rem;color:var(--text-secondary);">
                <span class="legend-dot" style="background:#f59e0b;"></span>Pendiente
                <span class="legend-dot" style="background:#10b981;"></span>Confirmada
                <span class="legend-dot" style="background:#ef4444;"></span>Cancelada
            </div>
            <span id="ts-update">Actualizado: {{ now()->format('H:i:s') }}</span>
        </div>
    </div>

    {{-- ── NAVEGACIÓN MES ── --}}
    <div class="cal-nav">
        @php
            $mesPrev = $mes == 1 ? 12 : $mes - 1;
            $anioPrev = $mes == 1 ? $anio - 1 : $anio;
            $mesSig  = $mes == 12 ? 1 : $mes + 1;
            $anioSig = $mes == 12 ? $anio + 1 : $anio;
            $meses   = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
            $diasSem = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
        @endphp

        <a href="{{ route('admin.calendario', ['mes'=>$mesPrev,'anio'=>$anioPrev,'estado'=>$filtroEstado,'paquete'=>$filtroPaquete,'busqueda'=>$busqueda]) }}"
           class="cal-nav-btn">← Anterior</a>

        <span class="cal-nav-title">{{ $meses[$mes] }} {{ $anio }}</span>

        <a href="{{ route('admin.calendario', ['mes'=>$mesSig,'anio'=>$anioSig,'estado'=>$filtroEstado,'paquete'=>$filtroPaquete,'busqueda'=>$busqueda]) }}"
           class="cal-nav-btn">Siguiente →</a>

        <a href="{{ route('admin.calendario') }}" class="cal-nav-btn today">Hoy</a>

        {{-- Selector rápido mes/año --}}
        <form method="GET" action="{{ route('admin.calendario') }}" style="display:flex;gap:6px;">
            <select name="mes" class="cal-filters" style="padding:7px 10px;" onchange="this.form.submit()">
                @for($m=1;$m<=12;$m++)
                    <option value="{{ $m }}" {{ $m==$mes?'selected':'' }}>{{ $meses[$m] }}</option>
                @endfor
            </select>
            <select name="anio" class="cal-filters" style="padding:7px 10px;" onchange="this.form.submit()">
                @for($y=2024;$y<=2027;$y++)
                    <option value="{{ $y }}" {{ $y==$anio?'selected':'' }}>{{ $y }}</option>
                @endfor
            </select>
            <input type="hidden" name="estado" value="{{ $filtroEstado }}">
            <input type="hidden" name="paquete" value="{{ $filtroPaquete }}">
            <input type="hidden" name="busqueda" value="{{ $busqueda }}">
        </form>
    </div>

    {{-- ── FILTROS ── --}}
    <form method="GET" action="{{ route('admin.calendario') }}" class="cal-filters mb-3">
        <input type="hidden" name="mes" value="{{ $mes }}">
        <input type="hidden" name="anio" value="{{ $anio }}">

        <select name="estado" onchange="this.form.submit()">
            <option value="todos" {{ $filtroEstado==='todos'?'selected':'' }}>Todos los estados</option>
            <option value="P"  {{ $filtroEstado==='P'?'selected':'' }}>Pendiente</option>
            <option value="CO" {{ $filtroEstado==='CO'?'selected':'' }}>Confirmada</option>
            <option value="C"  {{ $filtroEstado==='C'?'selected':'' }}>Cancelada</option>
        </select>

        <select name="paquete" onchange="this.form.submit()">
            <option value="todos">Todos los paquetes</option>
            @foreach($paquetes as $paq)
                <option value="{{ $paq->id_paquete }}" {{ $filtroPaquete==$paq->id_paquete?'selected':'' }}>
                    {{ $paq->nombre_paquete }}
                </option>
            @endforeach
        </select>

        <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="🔍 Buscar cliente..."
               style="min-width:200px;" oninput="clearTimeout(this._t);this._t=setTimeout(()=>this.form.submit(),400)">
    </form>

    {{-- ── CALENDARIO GANTT ── --}}
    <div class="card border-0 shadow-sm" style="overflow:hidden;">
        <div class="cal-wrap">
            <table class="cal-table">
                {{-- CABECERA: días --}}
                <thead>
                    <tr>
                        @foreach($dias as $dia)
                            @php
                                $esHoy = $dia->isToday();
                                $occ   = $ocupacionPorDia[$dia->day] ?? 0;
                                $pct   = $maxOcupacion > 0 ? round($occ / $maxOcupacion * 100) : 0;
                                $occClass = $pct <= 40 ? 'occ-green' : ($pct <= 75 ? 'occ-orange' : 'occ-red');
                            @endphp
                            <th class="day-header {{ $esHoy ? 'today' : '' }}">
                                <div class="dow">{{ $diasSem[$dia->dayOfWeek] }}</div>
                                <div class="num">{{ $dia->day }}</div>
                                <div class="occ {{ $esHoy ? '' : $occClass }}">
                                    {{ $occ > 0 ? $pct.'%' : '—' }}
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @forelse($filasPorPaquete as $idPaq => $filasGrupo)
                        @php $primerFila = $filasGrupo->first(); @endphp

                        {{-- Fila separadora de paquete --}}
                        <tr class="row-paquete">
                            <td colspan="{{ count($dias) }}" style="padding:5px 12px;">
                                <i class="fas fa-box-open mr-1"></i>
                                {{ $primerFila['nombre_paquete'] ?? 'Sin paquete' }}
                            </td>
                        </tr>

                        {{-- Fila de precios --}}
                        <tr class="row-precio">
                            @foreach($dias as $dia)
                                <td>S/ {{ number_format($primerFila['tour_precio'] ?? 0, 2) }}</td>
                            @endforeach
                        </tr>

                        {{-- Filas de reservas del grupo --}}
                        @foreach($filasGrupo as $fila)
                            <tr>
                                {{-- Celdas de días (sin columna fija) --}}
                                @foreach($dias as $idx => $dia)
                                    @php
                                        $enRango = $idx >= $fila['col_inicio'] && $idx < ($fila['col_inicio'] + $fila['col_span']);
                                        $esInicio = $idx === $fila['col_inicio'];
                                    @endphp
                                    @if($esInicio)
                                        <td class="cell-reserva" colspan="{{ $fila['col_span'] }}"
                                            style="position:relative;overflow:visible;">
                                            <div class="bar {{ $fila['color_class'] }}"
                                                 onclick="abrirModal('{{ $fila['id_reserva'] }}')"
                                                 title="{{ $fila['cliente_nombre'] }}">
                                                <span style="overflow:hidden;text-overflow:ellipsis;">
                                                    {{ $fila['cliente_nombre'] }}
                                                </span>
                                                @if($fila['tiene_notas'])
                                                    <span class="bar-dot"></span>
                                                @endif
                                            </div>
                                        </td>
                                    @elseif(!$enRango)
                                        <td class="cell-empty"></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach

                    @empty
                        <tr>
                            <td colspan="{{ count($dias) }}" style="padding:32px;text-align:center;color:var(--text-secondary);font-size:0.85rem;">
                                <i class="fas fa-calendar-times mr-2"></i>Sin reservas para este período
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── MODAL DETALLE RESERVA ── --}}
    <div id="modalCalOverlay" class="modal-cal-overlay" style="display:none;" onclick="if(event.target===this)cerrarModal()">
        <div class="modal-cal-box">
            <button class="modal-cal-close" onclick="cerrarModal()">
                <i class="fas fa-times"></i>
            </button>

            {{-- Título --}}
            <div class="d-flex align-items-center mb-3" style="gap:10px;">
                <span style="font-size:1.2rem;font-weight:800;color:var(--text-primary);">Reservación</span>
                <span id="modal-badge" style="padding:4px 12px;border-radius:20px;font-size:0.75rem;font-weight:700;"></span>
            </div>

            {{-- ID reserva --}}
            <div style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:14px;" id="modal-id-reserva"></div>

            {{-- Fechas --}}
            <div class="d-flex flex-wrap" style="gap:20px;margin-bottom:4px;">
                <div>
                    <div class="modal-label"><i class="fas fa-calendar-check mr-1"></i>Fecha Reserva</div>
                    <div class="modal-val modal-val-blue" id="modal-fecha-inicio"></div>
                </div>
                <div>
                    <div class="modal-label"><i class="fas fa-calendar-times mr-1"></i>Fecha Fin</div>
                    <div class="modal-val modal-val-blue" id="modal-fecha-fin"></div>
                </div>
                <div>
                    <div class="modal-label"><i class="fas fa-route mr-1"></i>Tour</div>
                    <div class="modal-val" id="modal-tour"></div>
                </div>
                <div>
                    <div class="modal-label"><i class="fas fa-users mr-1"></i>Personas</div>
                    <div class="modal-val" id="modal-personas"></div>
                </div>
            </div>

            {{-- Responsable --}}
            <div class="modal-section">
                <div style="font-size:0.85rem;font-weight:700;color:var(--text-primary);margin-bottom:10px;">Responsable</div>
                <div class="d-flex align-items-center" style="gap:12px;">
                    <div style="width:48px;height:48px;border-radius:50%;background:var(--accent-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-user" style="color:var(--accent);font-size:1.2rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:0.9rem;font-weight:700;color:var(--text-primary);text-transform:uppercase;" id="modal-cliente-nombre"></div>
                        <div style="font-size:0.78rem;color:var(--text-secondary);margin-top:2px;">
                            <i class="fas fa-phone mr-1"></i><span id="modal-telefono"></span>
                            &nbsp;&nbsp;
                            <i class="fas fa-envelope mr-1"></i><span id="modal-correo"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nota --}}
            <div class="modal-section" id="modal-nota-section">
                <div style="font-size:0.85rem;font-weight:700;color:var(--text-primary);margin-bottom:6px;">Nota</div>
                <div style="font-size:0.85rem;color:var(--text-secondary);" id="modal-nota"></div>
            </div>

            {{-- Monto --}}
            <div class="modal-section">
                <div style="font-size:0.85rem;font-weight:700;color:var(--text-primary);margin-bottom:10px;">Monto</div>
                <div class="d-flex justify-content-between" style="font-size:0.85rem;margin-bottom:6px;">
                    <span style="color:var(--text-secondary);">Monto de la reserva:</span>
                    <span style="font-weight:700;color:var(--text-primary);" id="modal-precio"></span>
                </div>
                <div class="d-flex justify-content-between" style="font-size:0.85rem;">
                    <span style="color:var(--text-secondary);">Precio por persona:</span>
                    <span class="modal-val-red font-weight-bold" id="modal-precio-unit"></span>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="modal-section d-flex" style="gap:10px;">
                <a id="modal-btn-ver" href="#"
                   style="flex:1;text-align:center;padding:10px;border:1.5px solid var(--border);border-radius:10px;font-size:0.85rem;font-weight:600;color:var(--text-primary);text-decoration:none;transition:all .2s;"
                   onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='var(--border)'">
                    Ir a la reserva
                </a>
                <button id="modal-btn-cancelar" onclick="cancelarReserva()"
                        style="flex:1;padding:10px;border:1.5px solid #fca5a5;border-radius:10px;font-size:0.85rem;font-weight:600;color:#dc2626;background:transparent;cursor:pointer;transition:all .2s;"
                        onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                    Eliminar reserva
                </button>
            </div>
        </div>
    </div>

    <script>
        let reservaActualId = null;

        function abrirModal(idReserva) {
            reservaActualId = idReserva;
            fetch(`/admin/calendario/${idReserva}/detalle`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(function(d) {
                // Badge estado
                const badgeEl = document.getElementById('modal-badge');
                const estados = {
                    'P':  { label: 'Pendiente',  bg: '#fef3c7', color: '#92400e' },
                    'CO': { label: 'Confirmada', bg: '#d1fae5', color: '#065f46' },
                    'C':  { label: 'Cancelada',  bg: '#fee2e2', color: '#991b1b' },
                };
                const est = estados[d.estado] || { label: d.estado, bg: '#e5e7eb', color: '#374151' };
                badgeEl.textContent = est.label;
                badgeEl.style.background = est.bg;
                badgeEl.style.color = est.color;

                document.getElementById('modal-id-reserva').textContent   = 'Reserva ' + d.id_reserva;
                document.getElementById('modal-fecha-inicio').textContent  = d.fecha_reserva ? d.fecha_reserva.substring(0,10) : '—';
                document.getElementById('modal-fecha-fin').textContent     = d.duracion_dias ? d.duracion_dias + ' día(s)' : '—';
                document.getElementById('modal-tour').textContent          = d.nombre_tour || '—';
                document.getElementById('modal-personas').textContent      = (d.cantidad_persona || 1) + ' persona(s)';
                document.getElementById('modal-cliente-nombre').textContent= ((d.cliente_nombre||'') + ' ' + (d.cliente_apellidos||'')).trim();
                document.getElementById('modal-telefono').textContent      = d.telefono || '—';
                document.getElementById('modal-correo').textContent        = d.correo   || '—';
                document.getElementById('modal-precio').textContent        = 'S/ ' + parseFloat(d.precio_publicado||0).toFixed(2);
                document.getElementById('modal-precio-unit').textContent   = 'S/ ' + parseFloat(d.precio_unitario||0).toFixed(2);

                const nota = d.observaciones || '';
                document.getElementById('modal-nota').textContent = nota || 'Sin notas';
                document.getElementById('modal-nota-section').style.display = nota ? '' : 'none';

                document.getElementById('modal-btn-ver').href = '/reservas/' + d.id_reserva;

                document.getElementById('modalCalOverlay').style.display = 'flex';
            })
            .catch(function() {
                alert('No se pudo cargar el detalle de la reserva.');
            });
        }

        function cerrarModal() {
            document.getElementById('modalCalOverlay').style.display = 'none';
            reservaActualId = null;
        }

        function cancelarReserva() {
            if (!reservaActualId) return;
            if (!confirm('¿Estás seguro de cancelar esta reserva?')) return;

            fetch(`/admin/calendario/${reservaActualId}/cancelar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(r => r.json())
            .then(function(d) {
                if (d.ok) {
                    cerrarModal();
                    location.reload();
                } else {
                    alert('Error al cancelar la reserva.');
                }
            });
        }

        // Auto-refresh timestamp cada 30s
        setInterval(function() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2,'0');
            const m = String(now.getMinutes()).padStart(2,'0');
            const s = String(now.getSeconds()).padStart(2,'0');
            document.getElementById('ts-update').textContent = 'Actualizado: ' + h + ':' + m + ':' + s;
        }, 30000);

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') cerrarModal();
        });
    </script>
</x-app-layout>
