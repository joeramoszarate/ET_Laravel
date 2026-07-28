<x-app-layout>
<x-slot name="header">
@include('partials.logo_header')
<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
    <div>
        <h2 style="font-size:1.4rem;font-weight:800;color:#1e3a5f;margin:0;">Reportes y Análisis</h2>
        <p style="color:#64748b;font-size:0.85rem;margin:4px 0 0;">Visualiza métricas y estadísticas de <span style="color:#1d6fa4;font-weight:600;">tu negocio</span></p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        <select id="periodoSelect" style="padding:8px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-size:0.875rem;color:#374151;background:#fff;outline:none;cursor:pointer;">
            <option value="mes">Este Mes</option>
            <option value="trimestre">Este Trimestre</option>
            <option value="año">Este Año</option>
        </select>
        <button onclick="exportarTodo()" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border:1.5px solid #d1d5db;background:#fff;color:#374151;font-size:0.875rem;font-weight:600;border-radius:8px;cursor:pointer;transition:background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Exportar Todo
        </button>
    </div>
</div>
</x-slot>

<style>
    .rep-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:22px 24px;}
    .rep-tab{padding:10px 20px;font-size:0.875rem;font-weight:600;border:none;background:transparent;cursor:pointer;color:#64748b;border-bottom:2px solid transparent;transition:all 0.15s;white-space:nowrap;}
    .rep-tab.active{color:#1d6fa4;border-bottom:2px solid #1d6fa4;}
    .rep-tab:hover:not(.active){color:#374151;}
    .chart-card{background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:24px;}
    @media(max-width:768px){
        .metrics-grid{grid-template-columns:1fr!important;}
        .charts-grid{grid-template-columns:1fr!important;}
    }
</style>

<div style="padding:24px;background:#f8fafc;min-height:calc(100vh - 120px);">

    {{-- ===== TABS ===== --}}
    <div style="display:flex;gap:0;border-bottom:1px solid #e5e7eb;margin-bottom:24px;overflow-x:auto;">
        <button class="rep-tab active" onclick="setTab(this,'ventas')">Ventas</button>
        <button class="rep-tab" onclick="setTab(this,'reservas')">Reservas</button>
        <button class="rep-tab" onclick="setTab(this,'tours')">Tours</button>
        <button class="rep-tab" onclick="setTab(this,'clientes')">Clientes</button>
    </div>

    {{-- ===== MÉTRICAS ===== --}}
    <div class="metrics-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">

        {{-- Ingresos del Mes --}}
        <div class="rep-card">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                <span style="font-size:0.8rem;color:#64748b;font-weight:500;">Ingresos del Mes</span>
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            </div>
            <p style="font-size:2rem;font-weight:800;color:#1d6fa4;margin-bottom:6px;">
                ${{ number_format($ingresosMesActual, 0) }}
            </p>
            <p style="font-size:0.78rem;color:{{ $porcentajeIncremento >= 0 ? '#16a34a' : '#dc2626' }};display:flex;align-items:center;gap:4px;">
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="{{ $porcentajeIncremento >= 0 ? '23 6 13.5 15.5 8.5 10.5 1 18' : '1 18 8.5 10.5 13.5 15.5 23 6' }}"/></svg>
                {{ $porcentajeIncremento >= 0 ? '+' : '' }}{{ $porcentajeIncremento }}% vs mes anterior
            </p>
        </div>

        {{-- Ticket Promedio --}}
        <div class="rep-card">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                <span style="font-size:0.8rem;color:#64748b;font-weight:500;">Ticket Promedio</span>
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <p style="font-size:2rem;font-weight:800;color:#1d6fa4;margin-bottom:6px;">
                ${{ number_format($ticketPromedio, 0) }}
            </p>
            <p style="font-size:0.78rem;color:#94a3b8;">Por reserva</p>
        </div>

        {{-- Tasa de Conversión --}}
        <div class="rep-card">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                <span style="font-size:0.8rem;color:#64748b;font-weight:500;">Tasa de Conversión</span>
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            </div>
            <p style="font-size:2rem;font-weight:800;color:#1d6fa4;margin-bottom:6px;">
                {{ $tasaConversion }}%
            </p>
            <p style="font-size:0.78rem;color:#94a3b8;">De visitas a reservas</p>
        </div>
    </div>

    {{-- ===== GRÁFICO VENTAS MENSUALES ===== --}}
    <div class="chart-card" style="margin-bottom:24px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="font-size:1rem;font-weight:700;color:#1e3a5f;margin:0;">Evolución de Ventas Mensuales</h3>
            <button onclick="exportarGrafico('ventasChart','ventas-mensuales')" style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border:1.5px solid #e5e7eb;background:#fff;color:#374151;font-size:0.8rem;font-weight:600;border-radius:7px;cursor:pointer;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Exportar
            </button>
        </div>
        <div style="position:relative;height:300px;width:100%;">
            <canvas id="ventasChart"></canvas>
        </div>
    </div>

    {{-- ===== GRÁFICOS INFERIORES ===== --}}
    <div class="charts-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

        {{-- Top 5 Tours --}}
        <div class="chart-card">
            <h3 style="font-size:1rem;font-weight:700;color:#1e3a5f;margin:0 0 20px;">Top 5 Tours por Ingresos</h3>
            @if(count($top5Tours) > 0)
                <div style="position:relative;height:260px;width:100%;">
                    <canvas id="toursChart"></canvas>
                </div>
            @else
                <div style="text-align:center;padding:48px;color:#94a3b8;">
                    <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="#cbd5e1" stroke-width="1.5" style="display:block;margin:0 auto 10px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    No hay datos disponibles
                </div>
            @endif
        </div>

        {{-- Distribución por Categoría --}}
        <div class="chart-card">
            <h3 style="font-size:1rem;font-weight:700;color:#1e3a5f;margin:0 0 20px;">Distribución por Categoría</h3>
            @if(count($categoriasProcessadas) > 0)
                <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
                    <div style="position:relative;height:220px;flex:0 0 220px;">
                        <canvas id="categoriasChart"></canvas>
                    </div>
                    <div style="flex:1;min-width:140px;">
                        @php $colores = ['#0EA5E9','#1F2937','#F97316','#EC4899','#8B5CF6','#EF4444']; @endphp
                        @foreach($categoriasProcessadas as $i => $cat)
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                            <div style="width:12px;height:12px;border-radius:3px;background:{{ $colores[$i % 6] }};flex-shrink:0;"></div>
                            <span style="font-size:0.8rem;color:#374151;flex:1;">{{ $cat['categoria'] }}</span>
                            <span style="font-size:0.8rem;font-weight:700;color:#1e3a5f;">{{ number_format($cat['porcentaje'],1) }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div style="text-align:center;padding:48px;color:#94a3b8;">No hay datos disponibles</div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
    Chart.defaults.color = '#64748b';

    // Gráfico línea — Ventas mensuales
    const ctxV = document.getElementById('ventasChart');
    if (ctxV) {
        new Chart(ctxV, {
            type: 'line',
            data: {
                labels: {!! json_encode($meses) !!},
                datasets: [{
                    label: 'Ventas ($)',
                    data: {!! json_encode($ventasData) !!},
                    borderColor: '#0EA5E9',
                    backgroundColor: 'rgba(14,165,233,0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#0EA5E9',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 16, font: { size: 12 } }
                    }
                },
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

    // Gráfico barras horizontales — Top 5 Tours
    const ctxT = document.getElementById('toursChart');
    if (ctxT) {
        new Chart(ctxT, {
            type: 'bar',
            data: {
                labels: {!! json_encode($top5Tours->pluck('nombre_tour')->values()) !!},
                datasets: [{
                    data: {!! json_encode($top5Tours->pluck('ingresos')->values()) !!},
                    backgroundColor: '#0EA5E9',
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { callback: v => v.toLocaleString(), font: { size: 11 } }
                    },
                    y: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    }

    // Gráfico doughnut — Categorías
    const ctxC = document.getElementById('categoriasChart');
    if (ctxC) {
        new Chart(ctxC, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoriasProcessadas->pluck('categoria')) !!},
                datasets: [{
                    data: {!! json_encode($categoriasProcessadas->pluck('porcentaje')) !!},
                    backgroundColor: ['#0EA5E9','#1F2937','#F97316','#EC4899','#8B5CF6','#EF4444'],
                    borderColor: '#fff',
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ctx.label + ': ' + ctx.parsed.toFixed(1) + '%' } }
                }
            }
        });
    }
});

function setTab(btn, tab) {
    document.querySelectorAll('.rep-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

function exportarGrafico(canvasId, nombre) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;
    const a = document.createElement('a');
    a.href = canvas.toDataURL('image/png');
    a.download = nombre + '.png';
    a.click();
}

function exportarTodo() {
    exportarGrafico('ventasChart', 'ventas-mensuales');
    setTimeout(() => exportarGrafico('toursChart', 'top5-tours'), 300);
    setTimeout(() => exportarGrafico('categoriasChart', 'categorias'), 600);
}
</script>

</x-app-layout>
