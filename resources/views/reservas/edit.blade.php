<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">Editar Reserva</h2>
                <p class="text-gray-600 text-sm mt-1">Actualiza la información de la reserva {{ $reserva->id_reserva }}</p>
            </div>
            <a href="{{ route('reservas.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg font-medium hover:bg-gray-300 transition">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-8">
                <form method="POST" action="{{ route('reservas.update', $reserva->id_reserva) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="cliente" class="block text-sm font-semibold text-gray-900 mb-2">Cliente</label>
                        <input type="text" id="cliente" value="{{ $reserva->cliente->nombre }} {{ $reserva->cliente->apellidos }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" disabled>
                        <p class="text-gray-600 text-sm mt-1">{{ $reserva->cliente->correo }}</p>
                    </div>

                    <div>
                        <label for="precio_publicado" class="block text-sm font-semibold text-gray-900 mb-2">Monto</label>
                        <input type="number" id="precio_publicado" name="precio_publicado" step="0.01" 
                            value="{{ $reserva->precio_publicado }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        @error('precio_publicado')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="estado" class="block text-sm font-semibold text-gray-900 mb-2">Estado</label>
                        <select id="estado" name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="P" {{ $reserva->estado === 'P' ? 'selected' : '' }}>Pendiente</option>
                            <option value="C" {{ $reserva->estado === 'C' ? 'selected' : '' }}>Confirmada/Pagada</option>
                            <option value="X" {{ $reserva->estado === 'X' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('estado')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="observaciones" class="block text-sm font-semibold text-gray-900 mb-2">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Notas adicionales sobre la reserva...">{{ $reserva->observaciones }}</textarea>
                        @error('observaciones')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            Guardar Cambios
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
