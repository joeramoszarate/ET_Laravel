<x-app-layout>
    <x-slot name="header">
        Panel de Control
    </x-slot>

    <!-- Tarjetas de Estadísticas -->
    <div class="row mb-4">
        <!-- Total de Ventas -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">${{ number_format($totalVentas, 2) }}</h3>
                            <p class="mb-0 text-white-50">Total de Ventas</p>
                            @if($totalVentas > 0)
                                <small class="text-success"><i class="fas fa-arrow-up"></i> +12.5% vs mes anterior</small>
                            @endif
                        </div>
                        <i class="fas fa-dollar-sign fa-3x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservas Activas -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border: none;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ $reservasActivas }}</h3>
                            <p class="mb-0 text-white-50">Reservas Activas</p>
                            <small class="text-info">En proceso o confirmadas</small>
                        </div>
                        <i class="fas fa-calendar-check fa-3x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nuevos Usuarios -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border: none;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-0">{{ $nuevosUsuarios }}</h3>
                            <p class="mb-0 text-white-50">Nuevos Usuarios</p>
                            <small class="text-info">Este mes</small>
                        </div>
                        <i class="fas fa-users fa-3x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tour Más Vendido -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card text-white" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border: none;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if($tourMasVendido)
                                <h5 class="mb-0 text-truncate">{{ $tourMasVendido->tour->nombre_tour ?? 'N/A' }}</h5>
                                <p class="mb-0 text-white-50">${{ number_format($tourMasVendido->tour->precio ?? 0, 2) }} en ventas</p>
                            @else
                                <h3 class="mb-0">0</h3>
                                <p class="mb-0 text-white-50">Sin tours vendidos</p>
                            @endif
                        </div>
                        <i class="fas fa-arrow-up fa-3x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de Tendencia y Tabla -->
    <div class="row mb-4">
        <!-- Gráfico de Tendencia -->
        <div class="col-lg-8">
            <div class="card" style="border-top: 3px solid #667eea;">
                <div class="card-header">
                    <h3 class="card-title">Tendencia de Ventas (Últimos 5 meses)</h3>
                </div>
                <div class="card-body" style="position: relative; height: 300px;">
                    <canvas id="ventasChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Resumen -->
        <div class="col-lg-4">
            <div class="card" style="border-top: 3px solid #f5576c;">
                <div class="card-header">
                    <h3 class="card-title">Resumen Rápido</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ventas del Mes</span>
                            <strong>${{ number_format($totalVentas, 2) }}</strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" style="width: {{ min($totalVentas / 1000 * 100, 100) }}%; background-color: #667eea;"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Reservas Activas</span>
                            <strong>{{ $reservasActivas }}</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Nuevos Clientes</span>
                            <strong>{{ $nuevosUsuarios }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Reservas Recientes -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="border-top: 3px solid #4facfe;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Reservas Recientes</h3>
                    <a href="#" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="width: 10%;">ID</th>
                                    <th style="width: 20%;">Cliente</th>
                                    <th style="width: 20%;">Tour</th>
                                    <th style="width: 15%;">Fecha Viaje</th>
                                    <th style="width: 10%;">Total</th>
                                    <th style="width: 10%;">Estado</th>
                                    <th style="width: 15%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservasRecientes as $reserva)
                                    <tr>
                                        <td>
                                            <strong>{{ $reserva->id_reserva }}</strong>
                                        </td>
                                        <td>
                                            @if($reserva->cliente)
                                                {{ $reserva->cliente->nombre }} {{ $reserva->cliente->apellidos }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reserva->detalles->first())
                                                {{ $reserva->detalles->first()->tour->nombre_tour ?? 'N/A' }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $reserva->fecha_reserva->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <strong>${{ number_format($reserva->precio_publicado, 2) }}</strong>
                                        </td>
                                        <td>
                                            @if($reserva->estado === 'C')
                                                <span class="badge" style="background-color: #51cf66; color: white;">Confirmada</span>
                                            @elseif($reserva->estado === 'P')
                                                <span class="badge" style="background-color: #ffd43b; color: #333;">Pendiente</span>
                                            @else
                                                <span class="badge" style="background-color: #ff6b6b; color: white;">Cancelada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="btn btn-sm btn-outline-secondary" title="Editar"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            No hay reservas registradas aún
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        const ctx = document.getElementById('ventasChart').getContext('2d');
        const ventasChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($tendenciaVentas['meses']) !!},
                datasets: [{
                    label: 'Ventas ($)',
                    data: {!! json_encode($tendenciaVentas['datos']) !!},
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: Math.max(...{!! json_encode($tendenciaVentas['datos']) !!}) * 1.2,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString('en-US');
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
