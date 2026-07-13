<x-app-layout>
<x-slot name="header">
<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
    <div>
        <h2 style="font-size:1.4rem;font-weight:800;color:#1e3a5f;margin:0;">Gestión de Reservas</h2>
        <p style="color:#64748b;font-size:0.85rem;margin:4px 0 0;">Administra todas las reservas de tours y paquetes turísticos</p>
    </div>
    <div style="display:flex;gap:10px;">
        <button onclick="exportarCSV()" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border:1.5px solid #d1d5db;background:#fff;color:#374151;font-size:0.875rem;font-weight:600;border-radius:8px;cursor:pointer;">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Exportar
        </button>
        <a href="{{ route('reservas.create') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#16a34a;color:#fff;font-size:0.875rem;font-weight:600;border-radius:8px;text-decoration:none;">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Nueva Reserva
        </a>
    </div>
</div>
</x-slot>

<style>
    .res-metric{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px 22px;flex:1;min-width:160px;}
    .res-tab{padding:10px 24px;font-size:0.875rem;font-weight:600;border:none;background:transparent;cursor:pointer;color:#64748b;border-bottom:2px solid transparent;transition:all 0.15s;}
    .res-tab.active{background:#f0f7ff;color:#1d6fa4;border-radius:8px 8px 0 0;border-bottom:2px solid #1d6fa4;}
    .res-tab:hover:not(.active){color:#374151;}
    .badge-paid{display:inline-block;padding:3px 10px;background:#dcfce7;color:#16a34a;font-size:0.72rem;font-weight:700;border-radius:6px;}
    .badge-pending{display:inline-block;padding:3px 10px;background:#fef9c3;color:#ca8a04;font-size:0.72rem;font-weight:700;border-radius:6px;}
    .badge-cancelled{display:inline-block;padding:3px 10px;background:#fee2e2;color:#dc2626;font-size:0.72rem;font-weight:700;border-radius:6px;}
    .res-table th{padding:12px 16px;font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;text-align:left;border-bottom:1px solid #e5e7eb;white-space:nowrap;}
    .res-table td{padding:14px 16px;font-size:0.875rem;color:#374151;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .res-table tr:hover td{background:#f8fafc;}
    .action-btn{background:none;border:none;cursor:pointer;padding:5px;border-radius:6px;transition:background 0.15s;display:inline-flex;align-items:center;justify-content:center;}
    .action-btn:hover{background:#f1f5f9;}
    @media(max-width:768px){
        .metrics-row{flex-direction:column!important;}
        .res-table{font-size:0.8rem;}
        .res-table th,.res-table td{padding:10px 10px;}
    }
</style>

<div style="padding:24px;background:#f8fafc;min-height:calc(100vh - 120px);">

    @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #86efac;color:#16a34a;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:0.875rem;font-weight:500;">
        ✓ {{ session('success') }}
    </div>
    @endif

    {{-- ===== MÉTRICAS ===== --}}
    <div class="metrics-row" style="display:flex;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
        <div class="res-metric" style="border-top:3px solid #1d6fa4;">
            <p style="font-size:0.78rem;color:#64748b;font-weight:600;margin-bottom:8px;">Total Reservas</p>
            <p style="font-size:2.2rem;font-weight:800;color:#1d6fa4;margin-bottom:4px;">{{ $totalReservas }}</p>
            <p style="font-size:0.75rem;color:#94a3b8;">Todas las reservas</p>
        </div>
        <div class="res-metric" style="border-top:3px solid #16a34a;">
            <p style="font-size:0.78rem;color:#64748b;font-weight:600;margin-bottom:8px;">Pagadas</p>
            <p style="font-size:2.2rem;font-weight:800;color:#16a34a;margin-bottom:4px;">{{ $countPagadas }}</p>
            <p style="font-size:0.75rem;color:#94a3b8;">S/ {{ number_format($reservasPagadas, 0) }}</p>
        </div>
        <div class="res-metric" style="border-top:3px solid #f59e0b;">
            <p style="font-size:0.78rem;color:#64748b;font-weight:600;margin-bottom:8px;">Pendientes</p>
            <p style="font-size:2.2rem;font-weight:800;color:#f59e0b;margin-bottom:4px;">{{ $countPendientes }}</p>
            <p style="font-size:0.75rem;color:#94a3b8;">Por confirmar</p>
        </div>
        <div class="res-metric" style="border-top:3px solid #dc2626;">
            <p style="font-size:0.78rem;color:#64748b;font-weight:600;margin-bottom:8px;">Canceladas</p>
            <p style="font-size:2.2rem;font-weight:800;color:#dc2626;margin-bottom:4px;">{{ $countCanceladas }}</p>
            <p style="font-size:0.75rem;color:#94a3b8;">Total canceladas</p>
        </div>
    </div>

    {{-- ===== TABS ===== --}}
    <div style="background:#fff;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">
        <div style="display:flex;border-bottom:1px solid #e5e7eb;padding:0 8px;">
            <a href="{{ route('reservas.index', ['filtro'=>'todas','busqueda'=>$busqueda]) }}"
               class="res-tab {{ $filtro==='todas' ? 'active' : '' }}">Todas</a>
            <a href="{{ route('reservas.index', ['filtro'=>'pagadas','busqueda'=>$busqueda]) }}"
               class="res-tab {{ $filtro==='pagadas' ? 'active' : '' }}">Pagadas</a>
            <a href="{{ route('reservas.index', ['filtro'=>'pendientes','busqueda'=>$busqueda]) }}"
               class="res-tab {{ $filtro==='pendientes' ? 'active' : '' }}">Pendientes</a>
            <a href="{{ route('reservas.index', ['filtro'=>'canceladas','busqueda'=>$busqueda]) }}"
               class="res-tab {{ $filtro==='canceladas' ? 'active' : '' }}">Canceladas</a>
        </div>

        {{-- Buscador --}}
        <div style="padding:16px 20px;display:flex;gap:12px;align-items:center;border-bottom:1px solid #f1f5f9;flex-wrap:wrap;">
            <form method="GET" action="{{ route('reservas.index') }}" style="display:flex;gap:8px;flex:1;min-width:220px;">
                <input type="hidden" name="filtro" value="{{ $filtro }}">
                <div style="position:relative;flex:1;max-width:340px;">
                    <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" name="busqueda" value="{{ $busqueda }}" placeholder="Buscar por ID, cliente o tour..."
                        style="width:100%;padding:9px 12px 9px 34px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.875rem;outline:none;color:#374151;"
                        onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'">
                </div>
                <button type="submit" style="padding:9px 16px;background:#1d6fa4;color:#fff;border:none;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;">Buscar</button>
            </form>
            <select onchange="filtrarEstado(this.value)" style="padding:9px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.875rem;color:#374151;outline:none;background:#fff;">
                <option value="">Todos</option>
                <option value="C" {{ request('estado')==='C'?'selected':'' }}>Pagadas</option>
                <option value="P" {{ request('estado')==='P'?'selected':'' }}>Pendientes</option>
                <option value="X" {{ request('estado')==='X'?'selected':'' }}>Canceladas</option>
            </select>
        </div>

        {{-- Tabla --}}
        <div style="overflow-x:auto;">
            <table class="res-table" style="width:100%;border-collapse:collapse;">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Tour</th>
                        <th>Fecha Viaje</th>
                        <th>Pasajeros</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservas as $reserva)
                    <tr>
                        <td style="font-weight:700;color:#1d6fa4;">{{ $reserva->id_reserva }}</td>
                        <td>
                            <p style="font-weight:700;color:#1e293b;margin:0;">
                                {{ $reserva->cliente->nombre ?? '—' }} {{ $reserva->cliente->apellidos ?? '' }}
                            </p>
                            <p style="font-size:0.75rem;color:#94a3b8;margin:2px 0 0;">
                                {{ $reserva->cliente->correo ?? '' }}
                            </p>
                        </td>
                        <td style="font-weight:600;color:#1e293b;">
                            @if($reserva->detalles->count() > 0)
                                {{ $reserva->detalles->first()->tour->nombre_tour ?? 'N/A' }}
                            @else
                                <span style="color:#94a3b8;font-weight:400;">Sin tour</span>
                            @endif
                        </td>
                        <td style="color:#64748b;">
                            {{ $reserva->fecha_reserva ? $reserva->fecha_reserva->format('d/m/Y') : '—' }}
                        </td>
                        <td style="color:#64748b;">
                            @if($reserva->detalles->count() > 0)
                                {{ $reserva->detalles->sum('cantidad_persona') }} adultos
                            @else
                                0 personas
                            @endif
                        </td>
                        <td style="font-weight:700;color:#1e293b;">
                            S/ {{ number_format($reserva->precio_publicado, 0) }}
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:6px;">
                                @if($reserva->estado === 'C')
                                    <span class="badge-paid">paid</span>
                                @elseif($reserva->estado === 'P')
                                    <span class="badge-pending">pending</span>
                                @elseif($reserva->estado === 'X')
                                    <span class="badge-cancelled">cancelled</span>
                                @else
                                    <span style="color:#94a3b8;font-size:0.75rem;">—</span>
                                @endif
                                {{-- Cambio rápido de estado --}}
                                <form method="POST" action="{{ route('reservas.update', $reserva->id_reserva) }}" style="display:inline;">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="precio_publicado" value="{{ $reserva->precio_publicado }}">
                                    <input type="hidden" name="observaciones" value="{{ $reserva->observaciones }}">
                                    <select name="estado" onchange="this.form.submit()"
                                        style="border:1px solid #e5e7eb;border-radius:6px;padding:2px 6px;font-size:0.72rem;color:#374151;background:#fff;cursor:pointer;outline:none;">
                                        <option value="C" {{ $reserva->estado==='C'?'selected':'' }}>paid</option>
                                        <option value="P" {{ $reserva->estado==='P'?'selected':'' }}>pending</option>
                                        <option value="X" {{ $reserva->estado==='X'?'selected':'' }}>cancelled</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;justify-content:center;gap:4px;">
                                {{-- Ver --}}
                                <button class="action-btn" title="Ver detalle" onclick="verDetalle('{{ $reserva->id_reserva }}')">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#64748b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                {{-- Editar --}}
                                <a href="{{ route('reservas.edit', $reserva->id_reserva) }}" class="action-btn" title="Editar">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#64748b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                {{-- Eliminar --}}
                                <form method="POST" action="{{ route('reservas.destroy', $reserva->id_reserva) }}" style="display:inline;" onsubmit="return confirm('¿Eliminar esta reserva?')">
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
                            <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="#cbd5e1" stroke-width="1.5" style="display:block;margin:0 auto 12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            No hay reservas disponibles
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($reservas->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #f1f5f9;background:#f8fafc;">
            {{ $reservas->appends(['filtro'=>$filtro,'busqueda'=>$busqueda])->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function filtrarEstado(val) {
    const url = new URL(window.location.href);
    if (val) url.searchParams.set('estado', val);
    else url.searchParams.delete('estado');
    window.location.href = url.toString();
}
function exportarCSV() {
    const rows = [['ID','Cliente','Correo','Tour','Fecha','Monto','Estado']];
    document.querySelectorAll('.res-table tbody tr').forEach(tr => {
        const tds = tr.querySelectorAll('td');
        if (tds.length > 1) {
            rows.push([
                tds[0]?.innerText.trim(),
                tds[1]?.querySelector('p')?.innerText.trim(),
                tds[1]?.querySelectorAll('p')[1]?.innerText.trim(),
                tds[2]?.innerText.trim(),
                tds[3]?.innerText.trim(),
                tds[5]?.innerText.trim(),
                tds[6]?.querySelector('span')?.innerText.trim(),
            ]);
        }
    });
    const csv = rows.map(r => r.map(c => `"${(c||'').replace(/"/g,'""')}"`).join(',')).join('\n');
    const a = document.createElement('a');
    a.href = 'data:text/csv;charset=utf-8,\uFEFF' + encodeURIComponent(csv);
    a.download = 'reservas.csv';
    a.click();
}
function verDetalle(id) {
    alert('Reserva ID: ' + id + '\nPuedes crear una vista de detalle en reservas/show.blade.php');
}
</script>

</x-app-layout>
