@extends('cliente.layout_clie')
@section('title','Inicio - ExploreTuTumbes')
@section('content')

<style>
  *{box-sizing:border-box;margin:0;padding:0;}
  body{font-family:Inter,ui-sans-serif,system-ui,sans-serif;background:#f8fafc;}
  .et-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:#fff;font-size:0.8rem;font-weight:500;padding:6px 16px;border-radius:999px;backdrop-filter:blur(4px);}
  .tab-btn{flex:1;padding:12px 8px;background:transparent;border:none;font-size:0.9rem;font-weight:500;color:#64748b;cursor:pointer;border-radius:8px;transition:all 0.2s;}
  .tab-btn.active{background:#fff;color:#1e3a5f;font-weight:700;box-shadow:0 1px 4px rgba(0,0,0,0.1);}
  .search-input{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:10px 12px 10px 36px;font-size:0.9rem;color:#374151;outline:none;background:#f8fafc;}
  .search-input:focus{border-color:#1d6fa4;background:#fff;}
  .dest-card{background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);transition:transform 0.2s,box-shadow 0.2s;}
  .dest-card:hover{transform:translateY(-4px);box-shadow:0 8px 28px rgba(0,0,0,0.14);}
  .feat-card{background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);border-radius:14px;padding:28px 20px;text-align:center;}
  .feat-icon{background:#f59e0b;border-radius:12px;width:52px;height:52px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;}
  .stat-card-blue{background:#1d6fa4;border-radius:14px;padding:32px 24px;text-align:center;color:#fff;}
  .stat-card-green{background:#2d7a4f;border-radius:14px;padding:32px 24px;text-align:center;color:#fff;}
  .stat-card-yellow{background:#f59e0b;border-radius:14px;padding:32px 24px;text-align:center;color:#1e3a5f;}
  .stat-icon{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;}
  .search-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:14px;}
  .cards-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;}
  .features-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
  .stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
  .tabs-row{display:flex;gap:4px;background:#f1f5f9;border-radius:10px;padding:4px;margin-bottom:18px;}
  /* Navbar responsivo */
  .nav-links{display:flex;}
  @media(max-width:900px){
    .nav-links{display:none !important;}
    .features-grid{grid-template-columns:1fr 1fr !important;}
  }
  @media(max-width:640px){
    .search-grid{grid-template-columns:1fr !important;}
    .cards-grid{grid-template-columns:1fr !important;}
    .features-grid{grid-template-columns:1fr 1fr !important;}
    .stats-grid{grid-template-columns:1fr !important;}
    .tabs-row{flex-wrap:wrap;}
    .tab-btn{flex:none;width:100%;}
  }
</style>

{{-- ===== HERO ===== --}}
<section style="background:linear-gradient(135deg,#1565c0 0%,#1d6fa4 45%,#2d9e6b 100%);min-height:520px;display:flex;align-items:center;justify-content:center;padding:60px 24px;position:relative;overflow:hidden;">
  {{-- Círculos decorativos --}}
  <div style="position:absolute;top:-80px;left:-80px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,0.05);"></div>
  <div style="position:absolute;bottom:-60px;right:-60px;width:250px;height:250px;border-radius:50%;background:rgba(255,255,255,0.05);"></div>

  <div style="max-width:780px;width:100%;text-align:center;position:relative;z-index:1;">
    <span class="et-badge" style="margin-bottom:20px;display:inline-flex;">
      🌴 Región Tumbes - Norte del Perú
    </span>

    <h1 style="font-size:clamp(2rem,5vw,3.2rem);font-weight:800;color:#fff;line-height:1.15;margin-bottom:16px;">
      Descubre las Maravillas de <span style="color:#f59e0b;">Tumbes</span>
    </h1>
    <p style="color:rgba(255,255,255,0.85);font-size:1rem;max-width:520px;margin:0 auto 36px;line-height:1.6;">
      Playas paradisíacas, manglares únicos y aventura en el norte del Perú. Tours con guías certificados y los mejores precios de la región
    </p>

    {{-- Buscador --}}
    <div style="background:#fff;border-radius:16px;padding:16px 20px 20px;box-shadow:0 16px 48px rgba(0,0,0,0.2);">
      {{-- Tabs --}}
      <div class="tabs-row">
        <button class="tab-btn active" onclick="setTab(this)">Todos los Tours</button>
        <button class="tab-btn" onclick="setTab(this)">Full Day</button>
        <button class="tab-btn" onclick="setTab(this)">Aventura</button>
      </div>

      <form action="{{ route('cliente.tours') }}" method="GET">
        <div class="search-grid">
          {{-- Destino --}}
          <div>
            <label style="display:block;font-size:0.78rem;font-weight:600;color:#64748b;margin-bottom:6px;">Destino</label>
            <div style="position:relative;">
              <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
              </span>
              <input name="destino" placeholder="¿A dónde quieres ir?" class="search-input">
            </div>
          </div>
          {{-- Fecha --}}
          <div>
            <label style="display:block;font-size:0.78rem;font-weight:600;color:#64748b;margin-bottom:6px;">Fecha</label>
            <div style="position:relative;">
              <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18"/></svg>
              </span>
              <input type="date" name="fecha" class="search-input">
            </div>
          </div>
          {{-- Pasajeros --}}
          <div>
            <label style="display:block;font-size:0.78rem;font-weight:600;color:#64748b;margin-bottom:6px;">Pasajeros</label>
            <div style="position:relative;">
              <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
              </span>
              <select name="pasajeros" class="search-input" style="appearance:none;">
                <option value="1">1 persona</option>
                <option value="2" selected>2 personas</option>
                <option value="3">3 personas</option>
                <option value="4">4 personas</option>
                <option value="5">5+ personas</option>
              </select>
            </div>
          </div>
        </div>
        <button type="submit" style="width:100%;background:#f59e0b;color:#1e3a5f;font-size:1rem;font-weight:700;padding:13px;border:none;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:background 0.2s;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
          Buscar Tours
        </button>
      </form>
    </div>
  </div>
</section>

{{-- ===== DESTINOS / TOURS DESTACADOS ===== --}}
<section style="background:#f0f4f8;padding:64px 24px;">
  <div style="max-width:1100px;margin:0 auto;">
    {{-- Header --}}
    <div style="text-align:center;margin-bottom:40px;">
      <span style="display:inline-flex;align-items:center;gap:6px;background:#fff;border:1px solid #e2e8f0;color:#64748b;font-size:0.8rem;font-weight:500;padding:5px 14px;border-radius:999px;margin-bottom:14px;">
        ✨ Tours Destacados
      </span>
      <h2 style="font-size:2rem;font-weight:800;color:#1d6fa4;margin-bottom:10px;">Destinos de Tumbes</h2>
      <p style="color:#64748b;font-size:0.95rem;max-width:480px;margin:0 auto;line-height:1.6;">Explora los rincones más bellos de la región: playas, manglares, ríos y naturaleza salvaje</p>
    </div>

    {{-- Cards de destinos --}}
    <div class="cards-grid">
      @forelse($destinos as $i => $destino)
      @php
        $badges = [['Más vendido','#f59e0b','#1e3a5f'],['Eco-turismo','#16a34a','#fff'],['Aventura extrema','#dc2626','#fff']];
        $badge = $badges[$i % 3];
        $precios = [120, 85, 95, 110, 75, 130];
        $precio = $precios[$i % count($precios)];
        $ratings = [4.9, 4.8, 4.7, 4.6, 4.9, 4.8];
        $reviews = [218, 143, 87, 165, 201, 94];
        $rating = $ratings[$i % count($ratings)];
        $review = $reviews[$i % count($reviews)];
      @endphp
      <div class="dest-card">
        {{-- Imagen --}}
        <div style="position:relative;height:200px;overflow:hidden;">
          @if($destino->imagen_url)
            <img src="{{ $destino->imagen_url }}" alt="{{ $destino->nombre }}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
          @else
            <div style="width:100%;height:100%;background:linear-gradient(135deg,#1d6fa4,#2d9e6b);display:flex;align-items:center;justify-content:center;">
              <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
            </div>
          @endif
          {{-- Badge categoría --}}
          <div style="position:absolute;top:10px;left:10px;display:flex;gap:6px;">
            <span style="background:{{ $badge[0] }};color:{{ $badge[1] }};font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">{{ $destino->categoria ?? $badge[0] }}</span>
          </div>
          {{-- Precio --}}
          <div style="position:absolute;top:10px;right:10px;background:#16a34a;color:#fff;font-size:0.85rem;font-weight:800;padding:4px 12px;border-radius:999px;">${{ $precio }}</div>
          {{-- Rating --}}
          <div style="position:absolute;bottom:10px;left:10px;background:rgba(0,0,0,0.55);backdrop-filter:blur(4px);color:#fff;font-size:0.75rem;font-weight:600;padding:4px 10px;border-radius:999px;display:flex;align-items:center;gap:4px;">
            <span style="color:#f59e0b;">★★★★</span><span style="color:#94a3b8;">★</span>
            {{ $rating }} ({{ $review }})
          </div>
        </div>
        {{-- Contenido --}}
        <div style="padding:18px 20px 20px;">
          <h3 style="font-size:1.05rem;font-weight:700;color:#1e293b;margin-bottom:8px;">{{ $destino->nombre }}</h3>
          <div style="display:flex;align-items:center;gap:6px;color:#64748b;font-size:0.8rem;margin-bottom:8px;">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="#1d6fa4" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
            <span>{{ $destino->nombre }}, Tumbes</span>
          </div>
          <p style="font-size:0.82rem;color:#64748b;line-height:1.5;margin-bottom:12px;">{{ Str::limit($destino->descripcion, 60) }}</p>
          <div style="display:flex;align-items:center;gap:6px;font-size:0.8rem;color:#64748b;padding:10px 0;border-top:1px solid #f1f5f9;margin-bottom:14px;">
            <span>📅</span> 1 día
          </div>
          <a href="{{ route('cliente.destinos') }}" style="display:block;width:100%;background:#1d6fa4;color:#fff;text-align:center;font-size:0.875rem;font-weight:600;padding:11px;border-radius:8px;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#1e3a5f'" onmouseout="this.style.background='#1d6fa4'">
            Ver Detalles →
          </a>
        </div>
      </div>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:40px;color:#64748b;">No hay destinos disponibles.</div>
      @endforelse
    </div>

    {{-- Botón ver todos --}}
    <div style="text-align:center;margin-top:40px;">
      <a href="{{ route('cliente.tours') }}" style="display:inline-block;background:#f59e0b;color:#1e3a5f;font-size:0.95rem;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
        Ver Todos los Tours →
      </a>
    </div>
  </div>
</section>

{{-- ===== ¿POR QUÉ ELEGIRNOS? ===== --}}
<section style="background:linear-gradient(135deg,#2d7a4f 0%,#1d6fa4 100%);padding:64px 24px;">
  <div style="max-width:1100px;margin:0 auto;text-align:center;">
    <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;font-size:0.8rem;font-weight:500;padding:5px 14px;border-radius:999px;margin-bottom:16px;">
      🏆 Calidad Garantizada
    </span>
    <h2 style="font-size:2rem;font-weight:800;color:#fff;margin-bottom:10px;">¿Por Qué Elegirnos?</h2>
    <p style="color:rgba(255,255,255,0.8);font-size:0.95rem;margin-bottom:40px;">Somos líderes en turismo regional con más de 10 años de experiencia</p>

    <div class="features-grid">
      @php
        $features = [
          ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>','title'=>'Soporte 24/7','desc'=>'Asistencia inmediata en cualquier momento de tu viaje'],
          ['icon'=>'<rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>','title'=>'Pagos Seguros','desc'=>'Transacciones protegidas con encriptación de última generación'],
          ['icon'=>'<circle cx="12" cy="8" r="6"/><path stroke-linecap="round" stroke-linejoin="round" d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>','title'=>'Guías Certificados','desc'=>'Profesionales expertos con licencia oficial de turismo'],
          ['icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>','title'=>'Seguridad Total','desc'=>'Seguro de viaje incluido en todos nuestros paquetes'],
        ];
      @endphp
      @foreach($features as $f)
      <div class="feat-card">
        <div class="feat-icon">
          <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#1e3a5f" stroke-width="2">{!! $f['icon'] !!}</svg>
        </div>
        <h3 style="font-size:1rem;font-weight:700;color:#fff;margin-bottom:8px;">{{ $f['title'] }}</h3>
        <p style="font-size:0.82rem;color:rgba(255,255,255,0.75);line-height:1.5;">{{ $f['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== ESTADÍSTICAS ===== --}}
<section style="background:#f0f4f8;padding:64px 24px;">
  <div style="max-width:900px;margin:0 auto;text-align:center;">
    <span style="display:inline-flex;align-items:center;gap:6px;background:#fff;border:1px solid #e2e8f0;color:#64748b;font-size:0.8rem;font-weight:500;padding:5px 14px;border-radius:999px;margin-bottom:16px;">
      📊 Nuestros Números
    </span>
    <h2 style="font-size:2rem;font-weight:800;color:#1d6fa4;margin-bottom:40px;">Líderes en Turismo Tumbesino</h2>

    <div class="stats-grid">
      <div class="stat-card-blue">
        <div class="stat-icon" style="background:#f59e0b;">
          <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#1e3a5f" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div style="font-size:2.2rem;font-weight:800;margin-bottom:6px;">15,000+</div>
        <div style="font-size:0.875rem;opacity:0.85;">Viajeros Satisfechos</div>
      </div>
      <div class="stat-card-green">
        <div class="stat-icon" style="background:#f59e0b;">
          <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#1e3a5f" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        </div>
        <div style="font-size:2.2rem;font-weight:800;margin-bottom:6px;">4.9/5</div>
        <div style="font-size:0.875rem;opacity:0.85;">Calificación Promedio</div>
      </div>
      <div class="stat-card-yellow">
        <div class="stat-icon" style="background:#1d6fa4;">
          <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div style="font-size:2.2rem;font-weight:800;margin-bottom:6px;">10+</div>
        <div style="font-size:0.875rem;opacity:0.75;">Años de Experiencia</div>
      </div>
    </div>
  </div>
</section>

{{-- ===== CTA FINAL ===== --}}
<section style="background:linear-gradient(135deg,#1565c0 0%,#1d6fa4 50%,#2d9e6b 100%);padding:64px 24px;text-align:center;">
  <div style="max-width:560px;margin:0 auto;">
    <div style="margin-bottom:20px;">
      <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="1.5" style="display:inline-block;"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/></svg>
    </div>
    <h2 style="font-size:1.8rem;font-weight:800;color:#fff;margin-bottom:12px;">¿Listo para tu Próxima Aventura?</h2>
    <p style="color:rgba(255,255,255,0.8);font-size:0.95rem;line-height:1.6;margin-bottom:32px;">Descubre la belleza natural de Tumbes con nuestros tours exclusivos.<br>¡Reserva hoy y vive una experiencia inolvidable!</p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('cliente.tours') }}" style="background:#f59e0b;color:#1e3a5f;font-size:0.95rem;font-weight:700;padding:13px 28px;border-radius:10px;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
        Explorar Tours
      </a>
      @if(!session('cliente_id'))
      <a href="{{ route('cliente.register') }}" style="background:rgba(255,255,255,0.15);border:2px solid rgba(255,255,255,0.5);color:#fff;font-size:0.95rem;font-weight:700;padding:13px 28px;border-radius:10px;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
        Crear Cuenta
      </a>
      @endif
    </div>
  </div>
</section>

<script>
  function setTab(btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }
</script>

@endsection
