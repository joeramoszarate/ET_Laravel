<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">Nueva Reserva</h2>
                <p class="text-gray-600 text-sm mt-1">Crea una nueva reserva de tour</p>
            </div>
            <a href="{{ route('reservas.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg font-medium hover:bg-gray-300 transition">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">
                <form method="POST" action="{{ route('reservas.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="id_cliente" class="block text-sm font-semibold text-gray-900 mb-2">Cliente</label>
                        <select id="id_cliente" name="id_cliente" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Selecciona un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id_cliente }}">
                                    {{ $cliente->nombre }} {{ $cliente->apellidos }} ({{ $cliente->correo }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_cliente')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="precio_publicado" class="block text-sm font-semibold text-gray-900 mb-2">Monto</label>
                        <input type="number" id="precio_publicado" name="precio_publicado" step="0.01" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="0.00" required>
                        @error('precio_publicado')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-semibold text-gray-900 mb-2">Estado</label>
                        <select id="estado" name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="P">Pendiente</option>
                            <option value="C">Confirmada/Pagada</option>
                            <option value="X">Cancelada</option>
                        </select>
                        @error('estado')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="observaciones" class="block text-sm font-semibold text-gray-900 mb-2">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Notas adicionales sobre la reserva..."></textarea>
                        @error('observaciones')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            Crear Reserva
                        </button>
                        <a href="{{ route('reservas.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
