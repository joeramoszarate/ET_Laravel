<x-app-layout>
<x-slot name="header">
@include('partials.logo_header')
<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
    <div>
        <h2 style="font-size:1.4rem;font-weight:800;color:#1e3a5f;margin:0;">Pagos Realizados</h2>
        <p style="color:#64748b;font-size:0.85rem;margin:4px 0 0;">Historial completo de transacciones</p>
    </div>
    <button onclick="exportarCSV()" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border:1.5px solid #d1d5db;background:#fff;color:#374151;font-size:0.875rem;font-weight:600;border-radius:8px;cursor:pointer;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
        Exportar CSV
    </button>
</div>
</x-slot>

<style>
    .pago-metric{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:20px 22px;flex:1;min-width:160px;}
    .pago-table th{padding:11px 14px;font-size:0.78rem;font-weight:700;color:#374151;text-align:left;border-bottom:1px solid #f1f5f9;white-space:nowrap;}
    .pago-table td{padding:13px 14px;font-size:0.875rem;color:#374151;border-bottom:1px solid #f1f5f9;vertical-align:middle;}
    .pago-table tr:hover td{background:#f8fafc;}
    .action-btn{background:none;border:none;cursor:pointer;padding:5px;border-radius:6px;display:inline-flex;align-items:center;transition:background 0.15s;}
    .action-btn:hover{background:#f1f5f9;}
    @media(max-width:900px){
        .metrics-row{flex-direction:column!important;}
        .charts-row{grid-template-columns:1fr!important;}
    }
    @media(max-width:600px){
        .pago-table th,.pago-table td{padding:9px 8px;font-size:0.8rem;}
    }
</style>

<div style="padding:24px;background:#f8fafc;min-height:calc(100vh - 120px);">

    {{-- ===== MÉTRICAS ===== --}}
    <div class="metrics-row" style="display:flex;gap:16px;margin-bottom:24px;flex-wrap:wrap;">

        <div class="pago-metric" style="border-left:3px solid #16a34a;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                <span style="font-size:0.78rem;color:#64748b;font-weight:500;">Total Cobrado</span>
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p style="font-size:1.8rem;font-weight:800;color:#1e293b;margin-bottom:6px;">S/ {{ number_format($totalCobrado, 0) }}</p>
            <p style="font-size:0.75rem;color:#16a34a;display:flex;align-items:center;gap:3px;">
                <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
                +18% vs mes anterior
            </p>
        </div>

        <div class="pago-metric" style="border-left:3px solid #f59e0b;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                <span style="font-size:0.78rem;color:#64748b;font-weight:500;">Por Cobrar</span>
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <p style="font-size:1.8rem;font-weight:800;color:#f59e0b;margin-bottom:6px;">S/ {{ number_format($porCobrar, 0) }}</p>
            <p style="font-size:0.75rem;color:#94a3b8;">{{ $countPendientes }} pagos pendientes</p>
        </div>

        <div class="pago-metric" style="border-left:3px solid #dc2626;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                <span style="font-size:0.78rem;color:#64748b;font-weight:500;">Fallidos / Anulados</span>
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><polyline points="1 18 8.5 10.5 13.5 15.5 23 6"/><polyline points="17 6 23 6 23 12"/></svg>
            </div>
            <p style="font-size:1.8rem;font-weight:800;color:#dc2626;margin-bottom:6px;">S/ {{ number_format($fallidos, 0) }}</p>
            <p style="font-size:0.75rem;color:#94a3b8;">{{ $countFallidos }} transacciones</p>
        </div>

        <div class="pago-metric" style="border-left:3px solid #1d6fa4;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                <span style="font-size:0.78rem;color:#64748b;font-weight:500;">Tasa de Éxito</span>
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#1d6fa4" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <p style="font-size:1.8rem;font-weight:800;color:#1d6fa4;margin-bottom:10px;">{{ $tasaExito }}%</p>
            <div style="background:#e2e8f0;border-radius:999px;height:6px;overflow:hidden;">
                <div style="height:100%;background:#1d6fa4;border-radius:999px;width:{{ $tasaExito }}%;transition:width 0.6s;"></div>
            </div>
        </div>
    </div>

    {{-- ===== GRÁFICOS ===== --}}
    <div class="charts-row" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">

        {{-- Ingresos por Mes --}}
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:22px;">
            <h3 style="font-size:0.95rem;font-weight:700;color:#1e3a5f;margin:0 0 18px;">Ingresos por Mes (S/)</h3>
            <div style="position:relative;height:260px;">
                <canvas id="ingresosChart"></canvas>
            </div>
        </div>

        {{-- Métodos de Pago --}}
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:22px;">
            <h3 style="font-size:0.95rem;font-weight:700;color:#1e3a5f;margin:0 0 20px;">Métodos de Pago</h3>
            @php $colores = ['#1d6fa4','#16a34a','#f59e0b','#dc2626']; @endphp
            @forelse($metodosPago as $i => $metodo)
            @php $pct = $totalMetodos > 0 ? round(($metodo->total / $totalMetodos) * 100, 0) : 0; @endphp
            <div style="margin-bottom:18px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                    <span style="font-size:0.875rem;font-weight:600;color:#374151;">{{ $metodo->descripcion }}</span>
                    <span style="font-size:0.8rem;color:#64748b;">{{ $metodo->cantidad }} · {{ $pct }}%</span>
                </div>
                <div style="background:#f1f5f9;border-radius:999px;height:7px;overflow:hidden;">
                    <div style="height:100%;background:{{ $colores[$i % 4] }};border-radius:999px;width:{{ $pct }}%;"></div>
                </div>
            </div>
            @empty
            <p style="color:#94a3b8;text-align:center;padding:32px 0;font-size:0.875rem;">No hay datos de métodos de pago</p>
            @endforelse
        </div>
    </div>

    {{-- ===== HISTORIAL DE TRANSACCIONES ===== --}}
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">

        {{-- Header tabla --}}
        <div style="padding:18px 20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;border-bottom:1px solid #f1f5f9;">
            <h3 style="font-size:0.95rem;font-weight:700;color:#1e3a5f;margin:0;">Historial de Transacciones</h3>
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div style="position:relative;">
                    <svg style="position:absolute;left:9px;top:50%;transform:translateY(-50%);color:#94a3b8;" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" id="searchPago" placeholder="Buscar pago, cliente..."
                        style="padding:8px 12px 8px 30px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.8rem;outline:none;width:200px;"
                        onfocus="this.style.borderColor='#1d6fa4'" onblur="this.style.borderColor='#e5e7eb'"
                        oninput="filtrarTabla()">
                </div>
                <select id="filterEstado" onchange="filtrarTabla()" style="padding:8px 12px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.8rem;color:#374151;background:#fff;outline:none;">
                    <option value="">Todos</option>
                    <option value="C">Completado</option>
                    <option value="P">Pendiente</option>
                    <option value="X">Fallido</option>
                </select>
            </div>
        </div>

        {{-- Tabla --}}
        <div style="overflow-x:auto;">
            <table class="pago-table" style="width:100%;border-collapse:collapse;" id="pagoTable">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th>ID Pago</th>
                        <th>Cliente</th>
                        <th>Tour</th>
                        <th>Método</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th style="text-align:center;">Acción</th>
                    </tr>
                </thead>
                <tbody id="pagoTbody">
                    @forelse($pagos as $pago)
                    <tr data-estado="{{ $pago->estado }}" data-search="{{ strtolower($pago->id_compag . ' ' . $pago->nombre . ' ' . ($pago->nombre_tour ?? '')) }}">
                        <td style="color:#1d6fa4;font-weight:700;font-size:0.8rem;">{{ $pago->id_compag }}</td>
                        <td style="font-weight:600;color:#1e293b;">{{ $pago->nombre }}</td>
                        <td style="color:#1d6fa4;">{{ $pago->nombre_tour ?? '—' }}</td>
                        <td style="color:#64748b;">{{ $pago->metodo }}</td>
                        <td style="font-weight:700;color:#1e293b;">S/ {{ number_format($pago->monto_facturado, 0) }}</td>
                        <td style="color:#64748b;">{{ \Carbon\Carbon::parse($pago->fecha_emision)->format('d/m/Y') }}</td>
                        <td>
                            @if($pago->estado === 'C')
                                <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:#dcfce7;color:#16a34a;font-size:0.72rem;font-weight:700;border-radius:999px;">
                                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Completado
                                </span>
                            @elseif($pago->estado === 'P')
                                <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:#fef9c3;color:#ca8a04;font-size:0.72rem;font-weight:700;border-radius:999px;">
                                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    Pendiente
                                </span>
                            @elseif($pago->estado === 'X')
                                <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:#fee2e2;color:#dc2626;font-size:0.72rem;font-weight:700;border-radius:999px;">
                                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                                    Fallido
                                </span>
                            @else
                                <span style="color:#94a3b8;font-size:0.75rem;">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <button class="action-btn" title="Ver detalle"
                                onclick="verPago({{ json_encode(['id'=>$pago->id_compag,'cliente'=>$pago->nombre,'tour'=>$pago->nombre_tour??'—','metodo'=>$pago->metodo,'monto'=>$pago->monto_facturado,'fecha'=>\Carbon\Carbon::parse($pago->fecha_emision)->format('d/m/Y'),'estado'=>$pago->estado]) }})">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#64748b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:48px;color:#94a3b8;">
                            <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="#cbd5e1" stroke-width="1.5" style="display:block;margin:0 auto 10px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            No hay pagos registrados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        @if($pagos->count() > 0)
        <div style="padding:14px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
            <p style="font-size:0.8rem;color:#64748b;margin:0;" id="countLabel">{{ $pagos->total() }} registros encontrados</p>
            {{ $pagos->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modal Ver Pago --}}
<div id="modalPago" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:14px;padding:28px;max-width:420px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.2);position:relative;">
        <button onclick="cerrarModal()" style="position:absolute;top:14px;right:14px;background:none;border:none;cursor:pointer;color:#94a3b8;font-size:1.1rem;">✕</button>
        <h3 style="font-size:1rem;font-weight:800;color:#1e3a5f;margin:0 0 18px;">Detalle del Pago</h3>
        <div id="modalBody"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
    Chart.defaults.color = '#64748b';

    const ctx = document.getElementById('ingresosChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($meses) !!},
                datasets: [{
                    data: {!! json_encode($ingresosData) !!},
                    backgroundColor: (ctx) => {
                        const idx = ctx.dataIndex;
                        const total = {!! json_encode(count($ingresosData)) !!};
                        return idx === total - 1 ? '#1d6fa4' : '#93c5fd';
                    },
                    borderRadius: 5,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { callback: v => v.toLocaleString(), font: { size: 11 } }
                    },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    }
});

function filtrarTabla() {
    const search = document.getElementById('searchPago').value.toLowerCase();
    const estado = document.getElementById('filterEstado').value;
    const rows = document.querySelectorAll('#pagoTbody tr[data-estado]');
    let visible = 0;
    rows.forEach(row => {
        const matchSearch = !search || row.dataset.search.includes(search);
        const matchEstado = !estado || row.dataset.estado === estado;
        row.style.display = matchSearch && matchEstado ? '' : 'none';
        if (matchSearch && matchEstado) visible++;
    });
    document.getElementById('countLabel').textContent = visible + ' registros encontrados';
}

function verPago(data) {
    const estados = { C: '<span style="color:#16a34a;font-weight:700;">Completado</span>', P: '<span style="color:#ca8a04;font-weight:700;">Pendiente</span>', X: '<span style="color:#dc2626;font-weight:700;">Fallido</span>' };
    document.getElementById('modalBody').innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:0.875rem;">
            <div><span style="color:#94a3b8;font-size:0.72rem;display:block;">ID Pago</span><strong style="color:#1d6fa4;">${data.id}</strong></div>
            <div><span style="color:#94a3b8;font-size:0.72rem;display:block;">Monto</span><strong>S/ ${parseFloat(data.monto).toFixed(0)}</strong></div>
            <div><span style="color:#94a3b8;font-size:0.72rem;display:block;">Cliente</span><strong>${data.cliente}</strong></div>
            <div><span style="color:#94a3b8;font-size:0.72rem;display:block;">Método</span><strong>${data.metodo}</strong></div>
            <div><span style="color:#94a3b8;font-size:0.72rem;display:block;">Tour</span><strong>${data.tour}</strong></div>
            <div><span style="color:#94a3b8;font-size:0.72rem;display:block;">Fecha</span><strong>${data.fecha}</strong></div>
            <div style="grid-column:1/-1;"><span style="color:#94a3b8;font-size:0.72rem;display:block;">Estado</span>${estados[data.estado] || data.estado}</div>
        </div>`;
    document.getElementById('modalPago').style.display = 'flex';
}

function cerrarModal() { document.getElementById('modalPago').style.display = 'none'; }
document.getElementById('modalPago').addEventListener('click', e => { if (e.target === document.getElementById('modalPago')) cerrarModal(); });

function exportarCSV() {
    const rows = [['ID Pago','Cliente','Tour','Método','Monto','Fecha','Estado']];
    document.querySelectorAll('#pagoTbody tr[data-estado]').forEach(tr => {
        const tds = tr.querySelectorAll('td');
        if (tds.length > 1) rows.push([...tds].slice(0,7).map(td => td.innerText.trim()));
    });
    const csv = rows.map(r => r.map(c => `"${(c||'').replace(/"/g,'""')}"`).join(',')).join('\n');
    const a = document.createElement('a');
    a.href = 'data:text/csv;charset=utf-8,\uFEFF' + encodeURIComponent(csv);
    a.download = 'pagos.csv';
    a.click();
}
</script>

</x-app-layout>
