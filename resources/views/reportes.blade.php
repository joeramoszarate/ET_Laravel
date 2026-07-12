<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">Reportes y Análisis</h2>
                <p class="text-gray-600 text-sm mt-1">Visualiza métricas y estadísticas de tu negocio</p>
            </div>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                ⬇️ Exportar Todo
            </button>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tarjetas de métricas clave -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Ingresos del Mes -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-t-4 border-blue-600">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide mb-2">Ingresos del Mes</p>
                            <p class="text-4xl font-bold text-gray-900">${{ number_format($ingresosMesActual, 0) }}</p>
                            <div class="mt-3 flex items-center {{ $porcentajeIncremento >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V9.414l-4.293 4.293a1 1 0 01-1.414-1.414L13.586 8H12z" clip-rule="evenodd"/>
                                </svg>
                                @if($porcentajeIncremento >= 0)
                                    +{{ $porcentajeIncremento }}% vs mes anterior
                                @else
                                    {{ $porcentajeIncremento }}% vs mes anterior
                                @endif
                            </div>
                        </div>
                        <div class="text-blue-600 text-4xl">📊</div>
                    </div>
                </div>

                <!-- Ticket Promedio -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-t-4 border-amber-600">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide mb-2">Ticket Promedio</p>
                            <p class="text-4xl font-bold text-gray-900">${{ number_format($ticketPromedio, 0) }}</p>
                            <p class="text-gray-600 text-sm mt-3">Por reserva realizada</p>
                        </div>
                        <div class="text-amber-600 text-4xl">💳</div>
                    </div>
                </div>

                <!-- Tasa de Conversión -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition border-t-4 border-teal-600">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide mb-2">Tasa de Conversión</p>
                            <p class="text-4xl font-bold text-gray-900">{{ $tasaConversion }}%</p>
                            <p class="text-gray-600 text-sm mt-3">De visitas a reservas</p>
                        </div>
                        <div class="text-teal-600 text-4xl">🎯</div>
                    </div>
                </div>
            </div>

            <!-- Pestañas -->
            <div class="bg-white rounded-lg shadow mb-8">
                <div class="flex border-b border-gray-200">
                    <button class="px-6 py-4 text-blue-600 border-b-2 border-blue-600 font-semibold tab-btn" data-tab="ventas">
                        📈 Ventas
                    </button>
                    <button class="px-6 py-4 text-gray-600 hover:text-gray-800 font-semibold tab-btn" data-tab="reservas">
                        🗓️ Reservas
                    </button>
                    <button class="px-6 py-4 text-gray-600 hover:text-gray-800 font-semibold tab-btn" data-tab="tours">
                        ✈️ Tours
                    </button>
                    <button class="px-6 py-4 text-gray-600 hover:text-gray-800 font-semibold tab-btn" data-tab="clientes">
                        👥 Clientes
                    </button>
                </div>
            </div>

            <!-- Gráfico de Evolución de Ventas -->
            <div class="bg-white rounded-lg shadow p-8 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Evolución de Ventas Mensuales</h3>
                    <button class="text-blue-600 hover:text-blue-800 text-sm font-semibold">⬇️ Exportar</button>
                </div>
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="ventasChart"></canvas>
                </div>
            </div>

            <!-- Gráficos inferiores -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Top 5 Tours por Ingresos -->
                <div class="bg-white rounded-lg shadow p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-8">🏆 Top 5 Tours por Ingresos</h3>
                    @if(count($top5Tours) > 0)
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="toursChart"></canvas>
                        </div>
                        <div class="mt-6 space-y-3">
                            @foreach($top5Tours as $tour)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                    <span class="text-gray-700 font-medium">{{ $tour->nombre_tour }}</span>
                                    <span class="text-blue-600 font-bold">${{ number_format($tour->ingresos, 0) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">📭 No hay datos disponibles</p>
                    @endif
                </div>

                <!-- Distribución por Categoría -->
                <div class="bg-white rounded-lg shadow p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-8">📊 Distribución por Categoría</h3>
                    @if(count($categoriasProcessadas) > 0)
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="categoriasChart"></canvas>
                        </div>
                        <div class="mt-8 space-y-3">
                            @foreach($categoriasProcessadas as $cat)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                    <div class="flex items-center gap-3">
                                        <div class="w-4 h-4 rounded-full" style="background-color: {{ ['#0EA5E9', '#1F2937', '#F97316', '#EC4899', '#8B5CF6', '#EF4444'][$loop->index % 6] }}"></div>
                                        <span class="text-gray-700 font-medium">{{ $cat['categoria'] }}</span>
                                    </div>
                                    <span class="text-gray-900 font-bold">{{ number_format($cat['porcentaje'], 1) }}%</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">📭 No hay datos disponibles</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Script para gráficos con Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script>
        // Esperar a que el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración global de Chart.js
            Chart.defaults.font.family = 'system-ui, -apple-system, sans-serif';
            Chart.defaults.color = '#6B7280';

            // Gráfico de Evolución de Ventas (Línea)
            try {
                const ctxVentas = document.getElementById('ventasChart');
                if (ctxVentas) {
                    new Chart(ctxVentas, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($meses) !!},
                            datasets: [{
                                label: 'Ventas ($)',
                                data: {!! json_encode($ventasData) !!},
                                borderColor: '#0EA5E9',
                                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#0EA5E9',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 6,
                                pointHoverRadius: 8,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        font: { size: 13, weight: 'bold' }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { drawBorder: false },
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value.toLocaleString();
                                        },
                                        font: { size: 12 }
                                    }
                                },
                                x: {
                                    grid: { drawBorder: false, display: false }
                                }
                            }
                        }
                    });
                }
            } catch(e) {
                console.log('Error en gráfico de ventas:', e);
            }

            // Gráfico de Top 5 Tours (Barras)
            try {
                const ctxTours = document.getElementById('toursChart');
                if (ctxTours) {
                    const toursData = {!! json_encode($top5Tours->pluck('nombre_tour')->values()) !!};
                    const toursIngresos = {!! json_encode($top5Tours->pluck('ingresos')->values()) !!};

                    new Chart(ctxTours, {
                        type: 'bar',
                        data: {
                            labels: toursData,
                            datasets: [{
                                label: 'Ingresos ($)',
                                data: toursIngresos,
                                backgroundColor: [
                                    'rgba(14, 165, 233, 0.8)',
                                    'rgba(59, 130, 246, 0.8)',
                                    'rgba(99, 102, 241, 0.8)',
                                    'rgba(139, 92, 246, 0.8)',
                                    'rgba(168, 85, 247, 0.8)',
                                ],
                                borderRadius: 8,
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    grid: { drawBorder: false },
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value.toLocaleString();
                                        }
                                    }
                                },
                                y: {
                                    grid: { drawBorder: false, display: false }
                                }
                            }
                        }
                    });
                }
            } catch(e) {
                console.log('Error en gráfico de tours:', e);
            }

            // Gráfico de Categorías (Pastel/Doughnut)
            try {
                const ctxCategoria = document.getElementById('categoriasChart');
                if (ctxCategoria) {
                    const colores = ['#0EA5E9', '#1F2937', '#F97316', '#EC4899', '#8B5CF6', '#EF4444'];
                    
                    new Chart(ctxCategoria, {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode($categoriasProcessadas->pluck('categoria')) !!},
                            datasets: [{
                                data: {!! json_encode($categoriasProcessadas->pluck('porcentaje')) !!},
                                backgroundColor: colores.slice(0, {!! count($categoriasProcessadas) !!}),
                                borderColor: '#fff',
                                borderWidth: 3,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.label + ': ' + context.parsed + '%';
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            } catch(e) {
                console.log('Error en gráfico de categorías:', e);
            }
        });

        // Interactividad de pestañas
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
                    b.classList.add('text-gray-600');
                });
                this.classList.remove('text-gray-600');
                this.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
            });
        });
    </script>
</x-app-layout>
