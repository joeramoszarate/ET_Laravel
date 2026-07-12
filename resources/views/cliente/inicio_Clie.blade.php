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
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-green-700">🗺️ Destinos de Tumbes</h2>
            <p class="text-gray-700 mt-2 text-lg">Explora los rincones más bellos de la región: playas, manglares, ríos y naturaleza salvaje</p>
            <div class="h-1 bg-gradient-to-r from-green-400 to-blue-500 w-20 mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($destinos as $destino)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl hover:scale-105 transition duration-300">
                <div class="h-48 bg-cover bg-center relative overflow-hidden">
                    <div style="background-image: url('{{ $destino->imagen_url ?? '/build/assets/default-destino.jpg' }}');" class="h-full bg-cover bg-center hover:scale-110 transition duration-300"></div>
                    <div class="absolute top-0 right-0 bg-yellow-400 text-green-800 font-bold px-3 py-1 m-3 rounded-full text-sm">{{ $destino->temperatura_prom ?? '' }}°C</div>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-lg text-green-700">{{ $destino->nombre }}</h3>
                    <p class="text-sm text-gray-600 mt-3">{{ \Illuminate\Support\Str::limit($destino->descripcion, 120) }}</p>
                    <div class="mt-5">
                        <a href="{{ route('cliente.destinos') }}" class="inline-block bg-gradient-to-r from-blue-600 to-green-600 text-white font-semibold px-5 py-2 rounded-lg hover:from-blue-700 hover:to-green-700 transition">Ver destino →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('cliente.destinos') }}" class="bg-gradient-to-r from-green-600 to-green-700 text-white font-bold px-8 py-3 rounded-lg shadow-lg hover:from-green-700 hover:to-green-800 transition inline-block">Ver todos los destinos →</a>
        </div>
    </div>
</section>

<!-- Tours destacados -->
<section class="py-16 bg-gradient-to-b from-green-50 to-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-blue-600">✈️ Tours Destacados</h2>
            <p class="text-gray-700 mt-2 text-lg">Tours populares y recomendados - ¡No te los pierdas!</p>
            <div class="h-1 bg-gradient-to-r from-blue-400 to-green-500 w-20 mx-auto mt-4"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($tours as $tour)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col hover:shadow-2xl hover:scale-105 transition duration-300">
                <div class="h-48 bg-cover bg-center relative overflow-hidden">
                    <div style="background-image: url('{{ $tour->imagen_url ?? '/build/assets/default-tour.jpg' }}');" class="h-full bg-cover bg-center hover:scale-110 transition duration-300"></div>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-lg text-green-700">{{ $tour->nombre_tour }}</h3>
                        <p class="text-sm text-gray-600 mt-3">{{ \Illuminate\Support\Str::limit($tour->descripcion, 100) }}</p>
                    </div>
                    <div class="mt-5 flex items-center justify-between">
                        <span class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-green-800 font-bold px-4 py-2 rounded-lg text-lg">S/ {{ number_format($tour->precio,2) }}</span>
                        <a href="{{ route('cliente.tours') }}" class="bg-gradient-to-r from-blue-600 to-green-600 text-white font-semibold px-4 py-2 rounded-lg hover:from-blue-700 hover:to-green-700 transition">Detalles →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('cliente.tours') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold px-8 py-3 rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-800 transition inline-block">Ver Todos Los Tours →</a>
        </div>
    </div>
</section>

<!-- Reservas recientes del cliente -->
<section class="py-16 bg-gradient-to-b from-white to-green-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-green-700">📋 Tus Reservas Recientes</h2>
            <p class="text-gray-700 mt-2 text-lg">Historial de reservas realizadas por tu cuenta</p>
            <div class="h-1 bg-gradient-to-r from-green-400 to-blue-500 w-20 mx-auto mt-4"></div>
        </div>

        @if($reservas->isEmpty())
            <div class="text-center bg-white rounded-xl p-10 shadow">
                <p class="text-gray-600 text-lg">📌 No tienes reservas recientes. ¡Comienza a explorar Tumbes ahora!</p>
                <a href="{{ route('cliente.tours') }}" class="inline-block mt-5 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold px-6 py-3 rounded-lg hover:from-green-700 hover:to-green-800 transition">Explorar Tours →</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($reservas as $res)
                    @php
                        $detalle = $res->detalles->first();
                        $img = $detalle && $detalle->tour ? ($detalle->tour->imagen_url ?? '/build/assets/default-tour.jpg') : '/build/assets/default-reserva.jpg';
                        $titulo = $detalle && $detalle->tour ? $detalle->tour->nombre_tour : 'Reserva ' . $res->id_reserva;
                    @endphp

                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition">
                        <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $img }}');"></div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-green-700">{{ $titulo }}</h3>
                            <p class="text-sm text-gray-600 mt-3">📅 Fecha: {{ $res->fecha_reserva?->format('d/m/Y') ?? '-' }}</p>
                            <p class="text-sm font-semibold text-gray-700">💰 Importe: S/ {{ number_format($res->precio_publicado,2) }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <a href="{{ route('cliente.inicio') }}" class="bg-blue-600 text-white px-3 py-1 rounded-lg font-semibold hover:bg-blue-700 transition">Ver detalles</a>
                                <span class="text-xs font-bold bg-gradient-to-r from-yellow-300 to-yellow-400 text-green-800 px-3 py-1 rounded-full">{{ $res->estado }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
