<x-app-layout>
    <x-slot name="header">Control de Caja</x-slot>

    <style>
        .caja-title { font-size:1.6rem; font-weight:800; color:#1a73e8; margin-bottom:2px; }
        .caja-date  { color:#888; font-size:0.88rem; margin-bottom:1rem; }
        /* Saldo banner */
        .saldo-banner { background: linear-gradient(135deg,#1a3a6e 0%,#1d6fa4 100%); border-radius:14px; padding:28px 32px; color:#fff; position:relative; overflow:hidden; margin-bottom:1.2rem; }
        .saldo-banner::after { content:''; position:absolute; right:-40px; top:-40px; width:220px; height:220px; background:rgba(255,255,255,.07); border-radius:50%; }
        .saldo-label { font-size:0.78rem; letter-spacing:1px; opacity:.8; margin-bottom:4px; }
        .saldo-monto { font-size:2.6rem; font-weight:800; margin-bottom:10px; }
        .saldo-stats { display:flex; gap:24px; flex-wrap:wrap; }
        .saldo-stat  { font-size:0.82rem; display:flex; align-items:center; gap:5px; }
        /* Tarjetas métricas */
        .metric-card { background:#fff; border:1px solid #e8edf3; border-radius:10px; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; }
        .metric-val  { font-size:1.6rem; font-weight:800; color:#1a1a1a; }
        .metric-lbl  { font-size:0.78rem; color:#888; margin-bottom:2px; }
        .metric-icon { width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1rem; }
        /* Botones acción */
        .btn-ingreso { background:#1a7a3a; color:#fff; border:none; border-radius:8px; padding:13px 20px; font-size:0.95rem; font-weight:700; width:100%; cursor:pointer; margin-bottom:10px; transition:background .2s; }
        .btn-ingreso:hover { background:#155f2d; }
        .btn-egreso  { background:#c0392b; color:#fff; border:none; border-radius:8px; padding:13px 20px; font-size:0.95rem; font-weight:700; width:100%; cursor:pointer; transition:background .2s; }
        .btn-egreso:hover  { background:#a93226; }
        /* Tabla movimientos */
        .mov-table th { font-size:0.78rem; color:#888; font-weight:600; padding:10px 12px; border-bottom:2px solid #f0f4f8; }
        .mov-table td { font-size:0.82rem; padding:10px 12px; border-bottom:1px solid #f5f7fa; vertical-align:middle; }
        .mov-table tr:last-child td { border-bottom:none; }
        .badge-ingreso { background:#dcfce7; color:#16a34a; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; }
        .badge-egreso  { background:#fee2e2; color:#dc2626; padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; }
        .mov-id { color:#94a3b8; font-size:0.75rem; font-weight:600; }
        /* Estado caja */
        .badge-abierta { background:#dcfce7; color:#16a34a; padding:5px 14px; border-radius:20px; font-size:0.82rem; font-weight:700; border:1px solid #86efac; }
        .badge-cerrada { background:#fee2e2; color:#dc2626; padding:5px 14px; border-radius:20px; font-size:0.82rem; font-weight:700; border:1px solid #fca5a5; }
    </style>

    {{-- Alertas --}}
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
            <div class="caja-title">Control de Caja</div>
            <div class="caja-date">{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [De] MMMM [De] YYYY') }}</div>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if($cajaHoy && $cajaHoy->estado === 'abierta')
                <span class="badge-abierta"><i class="fas fa-lock-open mr-1"></i>Caja Abierta</span>
                <form method="POST" action="{{ route('caja.cerrar') }}" class="d-inline"
                      onsubmit="return confirm('¿Cerrar la caja ahora?')">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm font-weight-bold">
                        <i class="fas fa-lock mr-1"></i>Cerrar Caja
                    </button>
                </form>
            @else
                <span class="badge-cerrada"><i class="fas fa-lock mr-1"></i>Caja Cerrada</span>
                <button class="btn btn-success btn-sm font-weight-bold" data-toggle="modal" data-target="#modalAbrirCaja">
                    <i class="fas fa-lock-open mr-1"></i>Abrir Caja
                </button>
            @endif
        </div>
    </div>

    {{-- Banner Saldo --}}
    <div class="saldo-banner mb-3">
        <div class="saldo-label">SALDO EN CAJA</div>
        <div class="saldo-monto">S/ {{ number_format($saldo, 0) }}</div>
        <div class="saldo-stats">
            <div class="saldo-stat"><i class="fas fa-arrow-circle-up" style="color:#4ade80;"></i>
                <span>Ingresos del día <strong>+S/ {{ number_format($totalIngresos, 0) }}</strong></span>
            </div>
            <div class="saldo-stat"><i class="fas fa-arrow-circle-down" style="color:#f87171;"></i>
                <span>Egresos del día <strong>-S/ {{ number_format($totalEgresos, 0) }}</strong></span>
            </div>
            @if($cajaHoy)
            <div class="saldo-stat"><i class="fas fa-wallet" style="color:#fbbf24;"></i>
                <span>Fondo inicial <strong>S/ {{ number_format($cajaHoy->fondo_inicial, 0) }}</strong></span>
            </div>
            @endif
        </div>
    </div>

    {{-- Tarjetas métricas --}}
    <div class="row mb-3">
        <div class="col-6 col-md-3 mb-3">
            <div class="metric-card">
                <div><div class="metric-lbl">Movimientos</div><div class="metric-val">{{ $movimientos->count() }}</div></div>
                <div class="metric-icon" style="background:#eff6ff;"><i class="fas fa-chart-line" style="color:#1a73e8;"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="metric-card">
                <div><div class="metric-lbl">Ingresos</div><div class="metric-val">{{ $countIngresos }}</div></div>
                <div class="metric-icon" style="background:#dcfce7;"><i class="fas fa-arrow-circle-up" style="color:#16a34a;"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="metric-card">
                <div><div class="metric-lbl">Egresos</div><div class="metric-val">{{ $countEgresos }}</div></div>
                <div class="metric-icon" style="background:#fee2e2;"><i class="fas fa-arrow-circle-down" style="color:#dc2626;"></i></div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="metric-card">
                <div><div class="metric-lbl">Promedio ingreso</div><div class="metric-val">S/ {{ number_format($promedio, 0) }}</div></div>
                <div class="metric-icon" style="background:#fef9c3;"><i class="fas fa-coins" style="color:#ca8a04;"></i></div>
            </div>
        </div>
    </div>

    {{-- Gráfico + Registrar --}}
    <div class="row mb-3">
        <div class="col-lg-8 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">Tendencia Semanal</h6>
                    <div style="position:relative;height:220px;">
                        <canvas id="cajaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3">Registrar Movimiento</h6>
                    <button class="btn-ingreso" data-toggle="modal" data-target="#modalMovimiento" onclick="setTipo('ingreso')">
                        + &nbsp;Registrar Ingreso
                    </button>
                    <button class="btn-egreso" data-toggle="modal" data-target="#modalMovimiento" onclick="setTipo('egreso')">
                        − &nbsp;Registrar Egreso
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla movimientos del día --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="font-weight-bold mb-0">Movimientos del Día</h6>
                <span class="badge badge-light border" style="font-size:0.8rem;">
                    <i class="fas fa-eye mr-1"></i>{{ $movimientos->count() }} registros
                </span>
            </div>
            <div class="table-responsive">
                <table class="table mov-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th><th>Hora</th><th>Concepto</th>
                            <th>Método</th><th>Tipo</th><th class="text-right">Monto</th><th class="text-right">Saldo Acum.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movimientos as $mov)
                            <tr>
                                <td class="mov-id">{{ $mov->id_movimiento }}</td>
                                <td>{{ $mov->hora }}</td>
                                <td style="color:#1a73e8;">{{ $mov->concepto }}</td>
                                <td><span style="font-size:0.8rem;color:#555;">{{ $mov->metodo_pago }}</span></td>
                                <td>
                                    @if($mov->tipo === 'ingreso')
                                        <span class="badge-ingreso"><i class="fas fa-circle" style="font-size:6px;vertical-align:middle;"></i> Ingreso</span>
                                    @else
                                        <span class="badge-egreso"><i class="fas fa-circle" style="font-size:6px;vertical-align:middle;"></i> Egreso</span>
                                    @endif
                                </td>
                                <td class="text-right font-weight-bold" style="color:{{ $mov->tipo==='ingreso'?'#16a34a':'#dc2626' }};">
                                    {{ $mov->tipo==='ingreso'?'+':'-' }}S/ {{ number_format($mov->monto, 0) }}
                                </td>
                                <td class="text-right" style="color:#1a73e8;font-weight:600;">
                                    S/ {{ number_format($mov->saldo_acumulado, 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No hay movimientos registrados hoy.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Abrir Caja --}}
    <div class="modal fade" id="modalAbrirCaja" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" style="border-radius:12px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-weight-bold">Abrir Caja</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('caja.abrir') }}">
                    @csrf
                    <div class="modal-body pt-0">
                        <label class="form-label small font-weight-bold">Fondo Inicial (S/)</label>
                        <input type="number" name="fondo_inicial" class="form-control" min="0" step="0.01" placeholder="Ej: 500" required>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success font-weight-bold">Abrir Caja</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Registrar Movimiento --}}
    <div class="modal fade" id="modalMovimiento" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius:12px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-weight-bold" id="modalMovTitulo">Registrar Movimiento</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('caja.movimiento') }}">
                    @csrf
                    <input type="hidden" name="tipo" id="inputTipo" value="ingreso">
                    <div class="modal-body pt-0">
                        <div class="mb-3">
                            <label class="form-label small font-weight-bold">Concepto *</label>
                            <input type="text" name="concepto" class="form-control" maxlength="200" required placeholder="Ej: Reserva B001 — Punta Sal">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small font-weight-bold">Método de Pago *</label>
                                <select name="metodo_pago" class="form-control" required>
                                    <option>Efectivo</option>
                                    <option>Yape</option>
                                    <option>Plin</option>
                                    <option>Transferencia</option>
                                    <option>Tarjeta</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small font-weight-bold">Monto (S/) *</label>
                                <input type="number" name="monto" class="form-control" min="0.01" step="0.01" required placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnSubmitMov" class="btn btn-success font-weight-bold">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Gráfico tendencia semanal
        const tendencia = @json($tendencia);
        const ctx = document.getElementById('cajaChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: tendencia.map(t => t.label),
                datasets: [
                    {
                        label: 'Ingresos',
                        data: tendencia.map(t => t.ingresos),
                        borderColor: '#16a34a', backgroundColor: 'rgba(22,163,74,.08)',
                        borderWidth: 2, tension: 0.4, pointRadius: 4,
                        pointBackgroundColor: '#16a34a', fill: true,
                    },
                    {
                        label: 'Egresos',
                        data: tendencia.map(t => t.egresos),
                        borderColor: '#dc2626', backgroundColor: 'rgba(220,38,38,.05)',
                        borderWidth: 2, tension: 0.4, pointRadius: 4,
                        pointBackgroundColor: '#dc2626', fill: true,
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: v => 'S/ ' + v } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Modal movimiento
        function setTipo(tipo) {
            document.getElementById('inputTipo').value = tipo;
            document.getElementById('modalMovTitulo').textContent =
                tipo === 'ingreso' ? 'Registrar Ingreso' : 'Registrar Egreso';
            var btn = document.getElementById('btnSubmitMov');
            btn.className = tipo === 'ingreso'
                ? 'btn btn-success font-weight-bold'
                : 'btn btn-danger font-weight-bold';
            btn.textContent = tipo === 'ingreso' ? 'Registrar Ingreso' : 'Registrar Egreso';
        }
    </script>
</x-app-layout>
