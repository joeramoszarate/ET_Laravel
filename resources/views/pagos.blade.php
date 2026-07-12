<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">Pagos Realizados</h2>
                <p class="text-gray-500 text-sm mt-1">Historial completo de transacciones</p>
            </div>
            <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50 font-medium text-sm">
                ⬇️ Exportar CSV
            </button>
        </div>
    </x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Tarjetas de Métricas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total Cobrado -->
                <div class="border border-gray-200 rounded p-6 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-gray-600 text-sm font-medium">Total Cobrado</p>
                        <div class="text-2xl">✓</div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">S/ {{ number_format($totalCobrado, 0) }}</p>
                    <p class="text-green-600 text-xs mt-2">↑ 18% vs mes anterior</p>
                </div>

                <!-- Por Cobrar -->
                <div class="border border-orange-300 rounded p-6 bg-white border-l-4 border-l-orange-400">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-gray-600 text-sm font-medium">Por Cobrar</p>
                        <div class="text-2xl">⏱️</div>
                    </div>
                    <p class="text-3xl font-bold text-orange-600">S/ {{ number_format($porCobrar, 0) }}</p>
                    <p class="text-gray-600 text-xs mt-2">{{ $countPendientes }} pagos pendientes</p>
                </div>

                <!-- Fallidos/Anulados -->
                <div class="border border-red-300 rounded p-6 bg-white border-l-4 border-l-red-400">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-gray-600 text-sm font-medium">Fallidos / Anulados</p>
                        <div class="text-2xl">⚠️</div>
                    </div>
                    <p class="text-3xl font-bold text-red-600">S/ {{ number_format($fallidos, 0) }}</p>
                    <p class="text-gray-600 text-xs mt-2">{{ $countFallidos }} transacciones</p>
                </div>

                <!-- Tasa de Éxito -->
                <div class="border border-blue-300 rounded p-6 bg-white border-l-4 border-l-blue-400">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-gray-600 text-sm font-medium">Tasa de Éxito</p>
                        <div class="text-2xl">📊</div>
                    </div>
                    <p class="text-3xl font-bold text-blue-600">{{ $tasaExito }}%</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $tasaExito }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Gráficos y Métodos de Pago -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Gráfico de Ingresos por Mes -->
                <div class="border border-gray-200 rounded p-6 bg-white">
                    <h3 class="font-bold text-gray-900 mb-6">Ingresos por Mes (S/)</h3>
                    <div style="position: relative; height: 300px;">
                        <canvas id="ingresosChart"></canvas>
                    </div>
                </div>

                <!-- Métodos de Pago -->
                <div class="border border-gray-200 rounded p-6 bg-white">
                    <h3 class="font-bold text-gray-900 mb-6">Métodos de Pago</h3>
                    <div class="space-y-4">
                        @forelse($metodosPago as $metodo)
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <p class="text-sm font-medium text-gray-700">{{ $metodo->descripcion }}</p>
                                    <p class="text-sm font-semibold text-gray-900">S/ {{ number_format($metodo->total, 0) }} ({{ number_format(($metodo->total / $totalMetodos) * 100, 0) }}%)</p>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full" style="width: {{ ($metodo->total / $totalMetodos) * 100 }}%; background-color: {{ ['#10B981', '#F59E0B', '#EF4444', '#3B82F6'][$loop->index % 4] }};"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No hay datos de métodos de pago</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Historial de Transacciones -->
            <div class="border border-gray-200 rounded p-6 bg-white">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-900">Historial de Transacciones</h3>
                    <div class="flex gap-4">
                        <div class="relative">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" placeholder="Buscar pago, cliente..." class="pl-10 pr-4 py-2 border border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <select class="px-4 py-2 border border-gray-300 rounded text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option>Todos</option>
                            <option>Completado</option>
                            <option>Pendiente</option>
                            <option>Fallido</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">ID Pago</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Cliente</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Tour</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Método</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Monto</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Fecha</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Estado</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-900">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($pagos as $pago)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-blue-600 font-semibold">{{ $pago->id_compag }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $pago->nombre }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $pago->nombre_tour ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $pago->metodo }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">S/ {{ number_format($pago->monto_facturado, 0) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($pago->fecha_emision)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($pago->estado === 'C')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">● Completado</span>
                                        @elseif($pago->estado === 'P')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">● Pendiente</span>
                                        @elseif($pago->estado === 'X')
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">● Fallido</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm">
                                        <button class="text-gray-600 hover:text-blue-600">👁️</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                        <p class="text-lg">📭 No hay pagos registrados</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($pagos->count() > 0)
                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <p class="text-sm text-gray-600 mb-4">{{ $pagos->total() }} registros encontrados</p>
                        {{ $pagos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Script para gráficos con Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = 'system-ui, -apple-system, sans-serif';
            Chart.defaults.color = '#6B7280';

            // Gráfico de Ingresos por Mes (Barras)
            try {
                const ctxIngresos = document.getElementById('ingresosChart');
                if (ctxIngresos) {
                    new Chart(ctxIngresos, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($meses) !!},
                            datasets: [{
                                label: 'Ingresos (S/)',
                                data: {!! json_encode($ingresosData) !!},
                                backgroundColor: '#3B82F6',
                                borderRadius: 6,
                                borderSkipped: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { drawBorder: false },
                                    ticks: {
                                        callback: function(value) {
                                            return 'S/ ' + value.toLocaleString();
                                        }
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
                console.log('Error en gráfico de ingresos:', e);
            }
        });
    </script>
</x-app-layout>
