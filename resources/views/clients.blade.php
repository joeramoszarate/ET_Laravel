<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Gestión de Clientes</h2>
                <p class="text-muted mb-0">Administra y visualiza información de tus clientes</p>
            </div>
            <div>
                <button class="btn btn-outline-primary me-2" onclick="exportarClientes()">
                    <i class="fas fa-download me-2"></i>Exportar
                </button>
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Agregar Cliente
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Tarjetas de Estadísticas -->
    <div class="row mb-4">
        <!-- Total Clientes -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-3">Total Clientes</p>
                    <h2 class="mb-2" style="color: #667eea;">{{ $totalClientes }}</h2>
                    <small class="text-muted">{{ $clientesActivos }} activos</small>
                </div>
            </div>
        </div>

        <!-- Ingresos Totales -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-3">Ingresos Totales</p>
                    <h2 class="mb-2" style="color: #f5576c;">${{ number_format($ingresosTotal, 2) }}</h2>
                    <small class="text-muted">De todos los clientes</small>
                </div>
            </div>
        </div>

        <!-- Promedio por Cliente -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <p class="text-muted small mb-3">Promedio por Cliente</p>
                    <h2 class="mb-2" style="color: #4facfe;">${{ number_format($promedioPorCliente, 2) }}</h2>
                    <small class="text-muted">Gasto promedio</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Clientes -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <!-- Búsqueda y Filtros -->
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-8">
                            <form action="{{ route('clients.search') }}" method="GET" class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="q" 
                                    class="form-control border-start-0" 
                                    placeholder="Buscar por nombre, email o teléfono..."
                                    value="{{ $busqueda ?? '' }}"
                                    onchange="this.form.submit()"
                                >
                                <select name="estado" class="form-select" style="max-width: 200px;" onchange="this.form.submit()">
                                    <option value="Todos" {{ (isset($estadoFiltro) && $estadoFiltro === 'Todos') ? 'selected' : '' }}>Todos</option>
                                    <option value="Activo" {{ (isset($estadoFiltro) && $estadoFiltro === 'Activo') ? 'selected' : '' }}>Activos</option>
                                    <option value="Inactivo" {{ (isset($estadoFiltro) && $estadoFiltro === 'Inactivo') ? 'selected' : '' }}>Inactivos</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="text-muted">{{ $clientes->total() }} clientes</span>
                        </div>
                    </div>

                    <!-- Tabla Responsiva -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 8%;">ID</th>
                                    <th style="width: 18%;">Cliente</th>
                                    <th style="width: 18%;">Contacto</th>
                                    <th style="width: 15%;">Fecha Registro</th>
                                    <th style="width: 10%;">Reservas</th>
                                    <th style="width: 15%;">Total Gastado</th>
                                    <th style="width: 8%;">Estado</th>
                                    <th style="width: 12%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clientes as $cliente)
                                    @php
                                        $tieneReservaConfirmada = $cliente->reservas->where('estado', 'C')->count() > 0;
                                        $estado = $tieneReservaConfirmada ? 'Activo' : 'Inactivo';
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong style="color: #667eea;">{{ $cliente->id_cliente }}</strong>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $cliente->nombre }} {{ $cliente->apellidos }}</strong>
                                                <div class="small text-muted">{{ $cliente->correo }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <i class="fas fa-phone text-muted me-2"></i>
                                                <span>{{ $cliente->telefono ?? 'N/A' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $cliente->fecha_registro }}
                                        </td>
                                        <td>
                                            <strong>{{ $cliente->cantidad_reservas ?? 0 }}</strong>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($cliente->total_gastado ?? 0, 2) }}</strong>
                                        </td>
                                        <td>
                                            @if($estado === 'Activo')
                                                <span class="badge" style="background-color: #51cf66;">Activo</span>
                                            @else
                                                <span class="badge bg-secondary">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-link text-muted" title="Ver" onclick="verCliente('{{ $cliente->id_cliente }}')">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('clients.edit', $cliente->id_cliente) }}" class="btn btn-sm btn-link text-muted" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            No hay clientes registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($clientes->hasPages())
                        <div class="d-flex justify-content-end mt-4">
                            {{ $clientes->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportarClientes() {
            alert('Funcionalidad de exportación en desarrollo');
        }

        function verCliente(idCliente) {
            alert('Ver cliente: ' + idCliente);
        }
    </script>
</x-app-layout>
