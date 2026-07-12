<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">Gestión de Reservas</h2>
                <p class="text-gray-500 text-sm mt-1">Administra todas las reservas de tours y paquetes turísticos</p>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50 font-medium text-sm">
                    ⬇️ Exportar
                </button>
                <a href="{{ route('reservas.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-medium text-sm">
                    ➕ Nueva Reserva
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Tarjetas de Métricas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total Reservas -->
                <div class="border border-gray-200 rounded p-6 border-t-4 border-t-blue-600 bg-white">
                    <p class="text-gray-600 text-sm font-medium">Total Reservas</p>
                    <p class="text-4xl font-bold text-blue-600 mt-2">{{ $totalReservas }}</p>
                    <p class="text-gray-600 text-xs mt-2">Todas las reservas</p>
                </div>

                <!-- Pagadas -->
                <div class="border border-gray-200 rounded p-6 border-t-4 border-t-green-600 bg-white">
                    <p class="text-gray-600 text-sm font-medium">Pagadas</p>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $countPagadas }}</p>
                    <p class="text-gray-600 text-xs mt-2">${{ number_format($reservasPagadas, 0) }}</p>
                </div>

                <!-- Pendientes -->
                <div class="border border-gray-200 rounded p-6 border-t-4 border-t-amber-600 bg-white">
                    <p class="text-gray-600 text-sm font-medium">Pendientes</p>
                    <p class="text-4xl font-bold text-amber-600 mt-2">{{ $countPendientes }}</p>
                    <p class="text-gray-600 text-xs mt-2">Por confirmar</p>
                </div>

                <!-- Canceladas -->
                <div class="border border-gray-200 rounded p-6 border-t-4 border-t-red-600 bg-white">
                    <p class="text-gray-600 text-sm font-medium">Canceladas</p>
                    <p class="text-4xl font-bold text-red-600 mt-2">{{ $countCanceladas }}</p>
                    <p class="text-gray-600 text-xs mt-2">Total canceladas</p>
                </div>
            </div>

            <!-- Pestañas de Filtro -->
            <div class="border-b border-gray-200 mb-8">
                <div class="flex gap-8">
                    <a href="{{ route('reservas.index', ['filtro' => 'todas']) }}" class="pb-4 font-semibold text-sm {{ $filtro === 'todas' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                        Todas
                    </a>
                    <a href="{{ route('reservas.index', ['filtro' => 'pagadas']) }}" class="pb-4 font-semibold text-sm {{ $filtro === 'pagadas' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                        Pagadas
                    </a>
                    <a href="{{ route('reservas.index', ['filtro' => 'pendientes']) }}" class="pb-4 font-semibold text-sm {{ $filtro === 'pendientes' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                        Pendientes
                    </a>
                    <a href="{{ route('reservas.index', ['filtro' => 'canceladas']) }}" class="pb-4 font-semibold text-sm {{ $filtro === 'canceladas' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                        Canceladas
                    </a>
                </div>
            </div>

            <!-- Búsqueda y Filtros -->
            <div class="flex gap-4 mb-6">
                <div class="flex-1 relative">
                    <form method="GET" action="{{ route('reservas.index') }}" class="flex gap-2">
                        <div class="flex-1 relative">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="busqueda" placeholder="Buscar por ID, cliente o tour..." 
                                value="{{ $busqueda }}"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <input type="hidden" name="filtro" value="{{ $filtro }}">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            🔍
                        </button>
                    </form>
                </div>
                <select class="px-4 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    <option>Todos</option>
                    <option>Pagadas</option>
                    <option>Pendientes</option>
                    <option>Canceladas</option>
                </select>
            </div>

            <!-- Tabla de Reservas -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">ID</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Cliente</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tour</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Fecha Viaje</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Pasajeros</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Monto</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Estado</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($reservas as $reserva)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $reserva->id_reserva }}</td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $reserva->cliente->nombre }} {{ $reserva->cliente->apellidos }}</p>
                                            <p class="text-xs text-gray-600">{{ $reserva->cliente->correo }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        @if($reserva->detalles->count() > 0)
                                            {{ $reserva->detalles->first()->tour->nombre_tour ?? 'N/A' }}
                                        @else
                                            <span class="text-gray-400">Sin tour asignado</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $reserva->fecha_reserva ? $reserva->fecha_reserva->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        @if($reserva->detalles->count() > 0)
                                            {{ $reserva->detalles->first()->cantidad_persona }} 
                                            @if($reserva->detalles->sum(function($d) { return $d->cantidad_persona; }) > 0)
                                                adultos
                                            @endif
                                        @else
                                            0 personas
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                        $/ {{ number_format($reserva->precio_publicado, 0) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($reserva->estado === 'C')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">paid</span>
                                        @elseif($reserva->estado === 'P')
                                            <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded text-xs font-semibold">pending</span>
                                        @elseif($reserva->estado === 'X')
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">cancelled</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-3">
                                            <button class="text-gray-600 hover:text-blue-600" title="Ver">
                                                👁️
                                            </button>
                                            <a href="{{ route('reservas.edit', $reserva->id_reserva) }}" class="text-gray-600 hover:text-amber-600" title="Editar">
                                                ✏️
                                            </a>
                                            <form method="POST" action="{{ route('reservas.destroy', $reserva->id_reserva) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-600 hover:text-red-600" title="Eliminar" onclick="return confirm('¿Estás seguro?')">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                        <p class="text-lg">📭 No hay reservas disponibles</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($reservas->count() > 0)
                    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                        {{ $reservas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
