@extends('cliente.layout_clie')
@section('title','Destinos - ExploreTuTumbes')
@section('content')

<style>
  *{box-sizing:border-box;margin:0;padding:0;}
  body{font-family:Inter,ui-sans-serif,system-ui,sans-serif;}

  .dest-card-wrap{background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.09);border:1px solid #e8f0fe;display:grid;grid-template-columns:340px 1fr;margin-bottom:32px;transition:box-shadow 0.2s;}
  .dest-card-wrap:hover{box-shadow:0 8px 36px rgba(0,0,0,0.14);}

  .dest-img-side{position:relative;min-height:340px;overflow:hidden;}
  .dest-img-side img{width:100%;height:100%;object-fit:cover;display:block;}
  .dest-img-placeholder{width:100%;height:100%;background:linear-gradient(135deg,#1d6fa4,#2d9e6b);display:flex;align-items:center;justify-content:center;}

  .dest-info-side{padding:28px 32px;display:flex;flex-direction:column;justify-content:space-between;border-left:3px solid #f59e0b;}

  .check-item{display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;font-size:0.875rem;color:#374151;}
  .check-icon{color:#16a34a;font-weight:700;flex-shrink:0;margin-top:1px;}

  .how-box{background:#f0f7ff;border:1px solid #bfdbfe;border-radius:10px;padding:14px 16px;margin-top:16px;}

  .btn-primary{background:#1d6fa4;color:#fff;font-size:0.9rem;font-weight:700;padding:12px 24px;border-radius:8px;text-decoration:none;border:none;cursor:pointer;transition:background 0.2s;display:inline-block;}
  .btn-primary:hover{background:#1e3a5f;}
  .btn-outline{background:#fff;color:#f59e0b;font-size:0.9rem;font-weight:700;padding:12px 24px;border-radius:8px;text-decoration:none;border:2px solid #f59e0b;cursor:pointer;transition:all 0.2s;display:inline-block;}
  .btn-outline:hover{background:#f59e0b;color:#1e3a5f;}

  @media(max-width:900px){
    .dest-card-wrap{grid-template-columns:1fr;}
    .dest-img-side{min-height:220px;}
    .dest-info-side{border-left:none;border-top:3px solid #f59e0b;padding:20px;}
  }
  @media(max-width:480px){
    .dest-info-side{padding:16px;}
    .btn-row{flex-direction:column !important;}
    .btn-row a{width:100%;text-align:center;}
  }
</style>

{{-- ===== HERO ===== --}}
<section style="background:linear-gradient(135deg,#1565c0 0%,#1d6fa4 50%,#2d9e6b 100%);padding:72px 24px;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-60px;left:-60px;width:240px;height:240px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>
  <div style="position:absolute;bottom:-40px;right:-40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>
  <div style="position:relative;z-index:1;max-width:640px;margin:0 auto;">
    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:#fff;font-size:0.8rem;font-weight:500;padding:6px 16px;border-radius:999px;margin-bottom:20px;">
      📍 Región Tumbes, Norte del Perú
    </span>
    <h1 style="font-size:clamp(2rem,5vw,3rem);font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px;">
      Conoce Nuestros <span style="color:#f59e0b;">Destinos</span>
    </h1>
    <p style="color:rgba(255,255,255,0.85);font-size:1rem;line-height:1.7;max-width:520px;margin:0 auto;">
      Tumbes esconde playas de ensueño, manglares únicos en el Perú, selva seca y ríos llenos de vida. Descubre cada rincón antes de elegir tu aventura.
    </p>
  </div>
</section>

{{-- ===== DESTINOS ===== --}}
@php
$infoExtra = [
  'punta sal' => [
    'ubicacion'  => 'Distrito de Canoas de Punta Sal, a 30 km al norte de Tumbes',
    'descripcion_larga' => 'Punta Sal es la joya de las playas del norte peruano. Sus aguas cálidas y cristalinas, combinadas con arena blanca y suave, la convierten en el destino favorito de quienes buscan descanso y snorkel. El mar tranquilo es ideal para nadar, y sus fondos marinos esconden corales y peces tropicales.',
    'actividades'=> ['Aguas cálidas todo el año (24–27°C)','Snorkel y buceo con vida marina tropical','Atardeceres espectaculares sobre el Pacífico','Playas de arena blanca poco concurridas','Cabañas frente al mar y restaurantes de mariscos'],
    'como_llegar'=> 'Desde Tumbes, tomar la carretera Panamericana Norte hacia el km 1187. Hay transporte en combi desde el terminal terrestre de Tumbes (S/ 5–8 por persona) o taxi privado.',
    'temp'       => '26°C – 32°C todo el año',
    'distancia'  => '30 km de Tumbes (~40 min)',
    'categoria_label' => 'Playa Paradisíaca',
    'cat_icon'   => '🌊',
  ],
  'zorritos' => [
    'ubicacion'  => 'Distrito de Zorritos, a 27 km al sur de Tumbes',
    'descripcion_larga' => 'Zorritos es el balneario más antiguo del Perú, conocido por sus aguas tranquilas y cálidas perfectas para el baño familiar. Cuenta con una amplia oferta gastronómica de mariscos frescos y es punto de partida para excursiones a los manglares y la isla del Amor.',
    'actividades'=> ['Baño en aguas tranquilas y cálidas','Gastronomía de mariscos frescos','Paseos en bote por la bahía','Pesca artesanal con pescadores locales','Visita a la isla del Amor'],
    'como_llegar'=> 'Desde Tumbes, tomar la Panamericana Sur. Hay combis frecuentes desde el terminal de Tumbes (S/ 3–5). El trayecto dura aproximadamente 30 minutos.',
    'temp'       => '25°C – 31°C todo el año',
    'distancia'  => '27 km de Tumbes (~30 min)',
    'categoria_label' => 'Balneario Familiar',
    'cat_icon'   => '🏖️',
  ],
  'puerto pizarro' => [
    'ubicacion'  => 'Distrito de San Jacinto, a 14 km al norte de Tumbes',
    'descripcion_larga' => 'Puerto Pizarro alberga el único manglar del Pacífico sur americano declarado Reserva de Biosfera por la UNESCO. Sus canales de agua salobre son hogar de cocodrilos americanos, aves migratorias y una biodiversidad única. Los paseos en bote entre los manglares son una experiencia inolvidable.',
    'actividades'=> ['Paseos en bote por los canales del manglar','Avistamiento de cocodrilos americanos','Observación de aves migratorias y residentes','Visita al criadero de cocodrilos','Gastronomía de mariscos en el muelle'],
    'como_llegar'=> 'Desde Tumbes, tomar mototaxi o combi hacia Puerto Pizarro (S/ 2–4). El recorrido dura 20 minutos por la carretera costera.',
    'temp'       => '24°C – 30°C todo el año',
    'distancia'  => '14 km de Tumbes (~20 min)',
    'categoria_label' => 'Eco-turismo',
    'cat_icon'   => '🌿',
  ],
  'parque nacional cerros de amotape' => [
    'ubicacion'  => 'Provincias de Tumbes y Zarumilla, zona de amortiguamiento',
    'descripcion_larga' => 'El Parque Nacional Cerros de Amotape protege el bosque seco ecuatorial más extenso del Perú. Es hogar del oso de anteojos, el cocodrilo americano y más de 100 especies de aves. Sus senderos permiten explorar una naturaleza salvaje y poco visitada, ideal para el ecoturismo de aventura.',
    'actividades'=> ['Trekking por senderos de bosque seco tropical','Avistamiento de fauna silvestre endémica','Fotografía de naturaleza y paisajes únicos','Campamento bajo las estrellas','Guías locales especializados en flora y fauna'],
    'como_llegar'=> 'Acceso desde el caserío El Caucho o desde Zarumilla. Se recomienda contratar guía local y transporte privado desde Tumbes (1.5 horas aproximadamente).',
    'temp'       => '22°C – 35°C (varía por altitud)',
    'distancia'  => '45 km de Tumbes (~1.5 h)',
    'categoria_label' => 'Aventura Extrema',
    'cat_icon'   => '🏔️',
  ],
  'isla del amor' => [
    'ubicacion'  => 'Frente a Puerto Pizarro, acceso en bote desde el muelle',
    'descripcion_larga' => 'La Isla del Amor es un pequeño paraíso rodeado de manglares y aguas tranquilas. Perfecta para el descanso, el snorkel y el avistamiento de aves. Su nombre evoca la tranquilidad y romanticismo del lugar, ideal para parejas y familias que buscan alejarse del bullicio.',
    'actividades'=> ['Snorkel en aguas cristalinas','Descanso en playas privadas','Avistamiento de pelícanos y fragatas','Paseo en kayak por los alrededores','Picnic frente al mar'],
    'como_llegar'=> 'Desde el muelle de Puerto Pizarro, tomar bote (S/ 10–15 por persona, ida y vuelta). El trayecto dura 15 minutos.',
    'temp'       => '25°C – 31°C todo el año',
    'distancia'  => '14 km de Tumbes + 15 min en bote',
    'categoria_label' => 'Isla & Naturaleza',
    'cat_icon'   => '🏝️',
  ],
];

function getInfo(array $infoExtra, string $nombre): array {
    $key = strtolower(trim($nombre));
    foreach ($infoExtra as $k => $v) {
        if (str_contains($key, $k) || str_contains($k, $key)) return $v;
    }
    return [
        'ubicacion'  => 'Región Tumbes, Perú',
        'descripcion_larga' => 'Un destino único en la región Tumbes con paisajes naturales impresionantes y experiencias turísticas de primer nivel.',
        'actividades'=> ['Turismo de naturaleza','Fotografía de paisajes','Gastronomía local','Guías certificados disponibles'],
        'como_llegar'=> 'Consultar con nuestros guías locales para las mejores opciones de transporte desde Tumbes.',
        'temp'       => '24°C – 32°C',
        'distancia'  => 'Consultar distancia',
        'categoria_label' => 'Destino Natural',
        'cat_icon'   => '📍',
    ];
}
@endphp

<section style="background:#f0f4f8;padding:56px 24px;">
  <div style="max-width:1060px;margin:0 auto;">

    @forelse($destinos as $destino)
    @php $info = getInfo($infoExtra, $destino->nombre); @endphp

    <div class="dest-card-wrap">
      {{-- Lado imagen --}}
      <div class="dest-img-side">
        @if($destino->imagen_url)
          <img src="{{ $destino->imagen_url }}" alt="{{ $destino->nombre }}">
        @else
          <div class="dest-img-placeholder">
            <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.4)" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
          </div>
        @endif
        {{-- Overlay info inferior --}}
        <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,0.75));padding:20px 16px 16px;">
          <div style="display:inline-flex;align-items:center;gap:6px;background:#1d6fa4;color:#fff;font-size:0.72rem;font-weight:700;padding:4px 12px;border-radius:999px;margin-bottom:8px;">
            {{ $info['cat_icon'] }} {{ $destino->categoria ?? $info['categoria_label'] }}
          </div>
          <h3 style="color:#fff;font-size:1.3rem;font-weight:800;margin-bottom:6px;">{{ $destino->nombre }}</h3>
          <div style="display:flex;flex-direction:column;gap:3px;">
            <span style="color:rgba(255,255,255,0.85);font-size:0.78rem;display:flex;align-items:center;gap:5px;">
              🌡️ {{ $destino->temperatura_prom ?? $info['temp'] }}
            </span>
            <span style="color:rgba(255,255,255,0.85);font-size:0.78rem;display:flex;align-items:center;gap:5px;">
              📍 {{ $info['distancia'] }}
            </span>
          </div>
        </div>
      </div>

      {{-- Lado info --}}
      <div class="dest-info-side">
        {{-- Ubicación --}}
        <div style="display:flex;align-items:flex-start;gap:7px;margin-bottom:12px;">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#1d6fa4" stroke-width="2" style="flex-shrink:0;margin-top:2px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
          <span style="font-size:0.82rem;color:#1d6fa4;font-weight:500;">{{ $info['ubicacion'] }}</span>
        </div>

        {{-- Descripción --}}
        <p style="font-size:0.9rem;color:#374151;line-height:1.7;margin-bottom:18px;">
          {{ $destino->descripcion && strlen($destino->descripcion) > 30 ? $destino->descripcion : $info['descripcion_larga'] }}
        </p>

        {{-- Actividades --}}
        <p style="font-size:0.875rem;font-weight:700;color:#f59e0b;margin-bottom:10px;">¿Qué puedes hacer aquí?</p>
        <div style="margin-bottom:16px;">
          @foreach($info['actividades'] as $act)
          <div class="check-item">
            <span class="check-icon">✓</span>
            <span>{{ $act }}</span>
          </div>
          @endforeach
        </div>

        {{-- Cómo llegar --}}
        <div class="how-box">
          <div style="display:flex;align-items:flex-start;gap:8px;">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#1d6fa4" stroke-width="2" style="flex-shrink:0;margin-top:2px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <div>
              <p style="font-size:0.82rem;font-weight:700;color:#1e3a5f;margin-bottom:4px;">¿Cómo llegar?</p>
              <p style="font-size:0.82rem;color:#1d6fa4;line-height:1.6;">{{ $info['como_llegar'] }}</p>
            </div>
          </div>
        </div>

        {{-- Botones --}}
        <div class="btn-row" style="display:flex;gap:12px;margin-top:20px;flex-wrap:wrap;">
          <a href="{{ route('cliente.tours') }}" class="btn-primary">Ver Tours en este Destino</a>
          <a href="{{ route('cliente.register') }}" class="btn-outline">Reservar Ahora</a>
        </div>
      </div>
    </div>

    @empty
    <div style="text-align:center;padding:60px;color:#64748b;background:#fff;border-radius:16px;">
      <p style="font-size:1.1rem;">No hay destinos disponibles en este momento.</p>
    </div>
    @endforelse

  </div>
</section>

{{-- ===== CTA FINAL ===== --}}
<section style="background:linear-gradient(135deg,#1565c0 0%,#1d6fa4 50%,#2d9e6b 100%);padding:64px 24px;text-align:center;">
  <div style="max-width:560px;margin:0 auto;">
    <h2 style="font-size:1.8rem;font-weight:800;color:#fff;margin-bottom:12px;">¿Ya elegiste tu destino favorito?</h2>
    <p style="color:rgba(255,255,255,0.85);font-size:0.95rem;line-height:1.7;margin-bottom:32px;">
      Nuestros guías locales conocen cada rincón de Tumbes. Reserva tu tour y vive la experiencia de cerca.
    </p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('cliente.tours') }}" style="background:#f59e0b;color:#1e3a5f;font-size:0.95rem;font-weight:700;padding:13px 28px;border-radius:10px;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
        Ver Todos los Tours
      </a>
      <a href="{{ route('cliente.paquetes') }}" style="background:rgba(255,255,255,0.15);border:2px solid rgba(255,255,255,0.5);color:#fff;font-size:0.95rem;font-weight:700;padding:13px 28px;border-radius:10px;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
        Ver Paquetes
      </a>
    </div>
  </div>
</section>

@endsection
