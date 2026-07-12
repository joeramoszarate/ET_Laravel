@extends('cliente.layout_clie')

@section('title','Inicio Cliente')

@section('content')
<!-- Hero -->
<header class="bg-gradient-to-r from-green-700 via-blue-600 to-green-600 text-white py-24 shadow-xl">
    <div class="max-w-6xl mx-auto text-center px-4">
        <p class="inline-block bg-yellow-400 text-sm text-green-800 font-semibold rounded-full px-5 py-2 mb-6">🌴 Región Tumbes - Norte del Perú 🌴</p>
        <h1 class="text-4xl md:text-6xl font-extrabold mb-4 text-white">Descubre las Maravillas de <span class="text-yellow-300">Tumbes</span></h1>
        <p class="max-w-2xl mx-auto mb-10 text-lg text-gray-100">Playas paradisíacas, manglares únicos y aventura en el norte del Perú. Tours con guías certificados y los mejores precios de la región.</p>

        <!-- Buscador simplificado -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-3xl mx-auto">
            <form action="{{ route('cliente.tours') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-700">Destino</label>
                    <input name="destino" placeholder="¿A dónde quieres ir?" class="w-full border-2 border-green-200 rounded-lg px-4 py-3 focus:border-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Fecha</label>
                    <input type="date" name="fecha" class="w-full border-2 border-green-200 rounded-lg px-4 py-3 focus:border-green-500 focus:outline-none">
                </div>
                <div>
                    <button class="w-full bg-gradient-to-r from-yellow-400 to-yellow-500 text-green-800 font-bold py-3 rounded-lg hover:from-yellow-300 hover:to-yellow-400 transition shadow-lg">🔍 Buscar Tours</button>
                </div>
            </form>
        </div>
    </div>
</header>

<!-- Destinos destacados -->
<section class="py-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Destinos de Tumbes</h2>
            <p class="text-gray-600">Explora los rincones más bellos de la región: playas, manglares, ríos y naturaleza salvaje</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($destinos as $destino)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="h-44 bg-cover bg-center" style="background-image: url('{{ $destino->imagen_url ?? '/build/assets/default-destino.jpg' }}')"></div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg">{{ $destino->nombre }}</h3>
                      <p class="text-sm text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit($destino->descripcion, 120) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="{{ route('cliente.destinos') }}" class="text-blue-600 hover:underline">Ver destino</a>
                        <span class="text-sm text-gray-500">{{ $destino->temperatura_prom ?? '' }}°C</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('cliente.destinos') }}" class="bg-yellow-400 text-white px-6 py-2 rounded shadow">Ver todos los destinos</a>
        </div>
    </div>
</section>

<!-- Tours destacados -->
<section class="py-12 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Tours Destacados</h2>
            <p class="text-gray-600">Tours populares y recomendados</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($tours as $tour)
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                <div class="h-44 bg-cover bg-center" style="background-image: url('{{ $tour->imagen_url ?? '/build/assets/default-tour.jpg' }}')"></div>
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-semibold text-lg">{{ $tour->nombre_tour }}</h3>
                        <p class="text-sm text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit($tour->descripcion, 100) }}</p>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="bg-green-600 text-white px-3 py-1 rounded">S/ {{ number_format($tour->precio,2) }}</span>
                        <a href="{{ route('cliente.tours') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Ver Detalles</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('cliente.tours') }}" class="bg-blue-700 text-white px-6 py-2 rounded shadow">Ver Todos Los Tours →</a>
        </div>
    </div>
</section>

<!-- Reservas recientes del cliente -->
<section class="py-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Tus Reservas Recientes</h2>
            <p class="text-gray-600">Reservas realizadas por tu cuenta</p>
        </div>

        @if($reservas->isEmpty())
            <p class="text-center text-gray-600">No tienes reservas recientes.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($reservas as $res)
                    @php
                        $detalle = $res->detalles->first();
                        $img = $detalle && $detalle->tour ? ($detalle->tour->imagen_url ?? '/build/assets/default-tour.jpg') : '/build/assets/default-reserva.jpg';
                        $titulo = $detalle && $detalle->tour ? $detalle->tour->nombre_tour : 'Reserva ' . $res->id_reserva;
                    @endphp

                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $img }}')"></div>
                        <div class="p-4">
                            <h3 class="font-semibold">{{ $titulo }}</h3>
                            <p class="text-sm text-gray-600 mt-2">Fecha reserva: {{ $res->fecha_reserva?->format('d/m/Y') ?? '-' }}</p>
                            <p class="text-sm text-gray-600">Importe: S/ {{ number_format($res->precio_publicado,2) }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <a href="{{ route('cliente.inicio') }}" class="text-blue-600">Ver reserva</a>
                                <span class="text-sm text-gray-500">Estado: {{ $res->estado }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
