@extends('cliente.layout_clie')
@section('title','Paquetes Turísticos - ExploreTuTumbes')
@section('content')

<style>
  *{box-sizing:border-box;margin:0;padding:0;}
  body{font-family:Inter,ui-sans-serif,system-ui,sans-serif;}

  .badge-pill{display:inline-flex;align-items:center;gap:6px;font-size:0.8rem;font-weight:500;padding:5px 14px;border-radius:999px;}

  /* Steps */
  .step-card{background:#fff;border:1px solid #e8f0fe;border-radius:14px;padding:28px 20px;text-align:center;position:relative;flex:1;min-width:200px;}
  .step-num{font-size:2rem;font-weight:800;color:#e2e8f0;line-height:1;margin-bottom:12px;}
  .step-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
  .step-arrow{color:#cbd5e1;font-size:1.2rem;align-self:center;flex-shrink:0;padding:0 4px;}

  /* Tipo paquete cards */
  .tipo-card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:28px;position:relative;flex:1;min-width:280px;}

  /* Paquete cards */
  .paq-card{background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 2px 14px rgba(0,0,0,0.08);border:1px solid #e8f0fe;transition:transform 0.2s,box-shadow 0.2s;}
  .paq-card:hover{transform:translateY(-4px);box-shadow:0 10px 32px rgba(0,0,0,0.13);}

  /* Garantías */
  .garantia-card{background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);border-radius:14px;padding:28px 24px;text-align:center;flex:1;min-width:220px;}

  /* Include list */
  .inc-item{display:flex;align-items:center;gap:8px;font-size:0.85rem;color:#374151;margin-bottom:8px;}

  /* Responsive */
  .steps-row{display:flex;gap:12px;align-items:stretch;flex-wrap:wrap;}
  .tipos-row{display:grid;grid-template-columns:1fr 1fr;gap:24px;}
  .paq-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;}
  .garantias-row{display:flex;gap:20px;flex-wrap:wrap;}

  @media(max-width:900px){
    .tipos-row{grid-template-columns:1fr !important;}
    .steps-row{flex-direction:column;}
    .step-arrow{display:none;}
  }
  @media(max-width:600px){
    .paq-grid{grid-template-columns:1fr !important;}
    .garantias-row{flex-direction:column;}
    .cta-btns{flex-direction:column !important;align-items:center;}
    .cta-btns a{width:100%;max-width:300px;text-align:center;}
  }
</style>

{{-- ===== HERO ===== --}}
<section style="background:linear-gradient(135deg,#2d7a4f 0%,#1d6fa4 60%,#1565c0 100%);padding:72px 24px;text-align:center;position:relative;overflow:hidden;">
  <div style="position:absolute;top:-80px;right:-80px;width:280px;height:280px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>
  <div style="position:absolute;bottom:-60px;left:-60px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>
  <div style="position:relative;z-index:1;max-width:700px;margin:0 auto;">
    <span class="badge-pill" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:#fff;margin-bottom:20px;">
      🎯 Así funcionan nuestros paquetes
    </span>
    <h1 style="font-size:clamp(1.8rem,5vw,3rem);font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px;">
      Paquetes <span style="color:#f59e0b;">Turísticos</span> en Tumbes
    </h1>
    <p style="color:rgba(255,255,255,0.85);font-size:1rem;line-height:1.7;max-width:540px;margin:0 auto 28px;">
      Todo organizado para ti. Solo preocúpate por disfrutar: nosotros nos encargamos del transporte, guía, alimentación y seguro de viaje.
    </p>
    <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
      <span class="badge-pill" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;">⭐ 4.9/5 en Google</span>
      <span class="badge-pill" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;">👥 +15,000 viajeros</span>
      <span class="badge-pill" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:#fff;">🛡️ Seguro incluido</span>
    </div>
  </div>
</section>

{{-- ===== CÓMO FUNCIONA ===== --}}
<section style="background:#f8fafc;padding:64px 24px;">
  <div style="max-width:1060px;margin:0 auto;text-align:center;">
    <span class="badge-pill" style="background:#fff;border:1px solid #e2e8f0;color:#64748b;margin-bottom:14px;">
      📋 Proceso simple
    </span>
    <h2 style="font-size:1.9rem;font-weight:800;color:#1e3a5f;margin-bottom:10px;">¿Cómo Funciona?</h2>
    <p style="color:#64748b;font-size:0.95rem;max-width:500px;margin:0 auto 40px;line-height:1.6;">
      Reservar tu tour con ExploreTuTumbes es fácil. Sigue estos 4 pasos y en minutos tendrás tu aventura asegurada.
    </p>

    <div class="steps-row">
      @php
        $steps = [
          ['num'=>'01','color'=>'#1d6fa4','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>','title'=>'Elige tu Paquete','desc'=>'Explora nuestro catálogo y selecciona el paquete que mejor se adapte a tus intereses, fechas disponibles y presupuesto. Tenemos opciones desde 1 día hasta paquetes de varios días.'],
          ['num'=>'02','color'=>'#2d7a4f','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>','title'=>'Personaliza tu Viaje','desc'=>'Indica el número de personas, la fecha deseada y si tienes algún requerimiento especial (dieta vegetariana, silla de ruedas, niños pequeños, etc.). Adaptamos cada paquete a tu grupo.'],
          ['num'=>'03','color'=>'#f59e0b','icon'=>'<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>','title'=>'Confirma y Paga','desc'=>'Realiza el pago de la seña (50% del total) para asegurar tu reserva. Aceptamos transferencia bancaria, Yape, Plin y tarjetas de crédito/débito. El saldo restante lo pagas el día del tour.'],
          ['num'=>'04','color'=>'#1d6fa4','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>','title'=>'Nosotros nos Encargamos','desc'=>'Recibirás confirmación por WhatsApp con todos los detalles: punto de encuentro, hora de salida, qué llevar y contacto de tu guía. ¡Solo tienes que presentarte y disfrutar!'],
        ];
      @endphp
      @foreach($steps as $i => $step)
        <div class="step-card">
          <div class="step-num">{{ $step['num'] }}</div>
          <div class="step-icon" style="background:{{ $step['color'] }};">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">{!! $step['icon'] !!}</svg>
          </div>
          <h3 style="font-size:0.95rem;font-weight:700;color:#1e3a5f;margin-bottom:8px;">{{ $step['title'] }}</h3>
          <p style="font-size:0.82rem;color:#64748b;line-height:1.6;">{{ $step['desc'] }}</p>
        </div>
        @if($i < 3)<div class="step-arrow">→</div>@endif
      @endforeach
    </div>
  </div>
</section>

{{-- ===== TIPOS DE PAQUETES (desde BD agrupados) ===== --}}
<section style="background:#fff;padding:64px 24px;">
  <div style="max-width:1060px;margin:0 auto;text-align:center;">
    <span class="badge-pill" style="background:#f0f4f8;border:1px solid #e2e8f0;color:#64748b;margin-bottom:14px;">
      🎁 Nuestros productos
    </span>
    <h2 style="font-size:1.9rem;font-weight:800;color:#1d6fa4;margin-bottom:10px;">Tipos de Paquetes</h2>
    <p style="color:#64748b;font-size:0.95rem;max-width:460px;margin:0 auto 40px;line-height:1.6;">
      Cada paquete está diseñado para un tipo de viajero distinto. Encuentra el tuyo.
    </p>

    @php
      $tiposInfo = [
        'full day'   => ['emoji'=>'☀️','badge'=>'Más Popular','badge_color'=>'#f59e0b','badge_text'=>'#1e3a5f','duracion'=>'1 día (8–10 horas)','incluye'=>['Transporte ida y vuelta','Guía certificado','Almuerzo típico','Seguro de viaje','Ticket de acceso']],
        'nacional'   => ['emoji'=>'🗺️','badge'=>'Recomendado','badge_color'=>'#16a34a','badge_text'=>'#fff','duracion'=>'2 a 4 días','incluye'=>['Transporte completo','Hospedaje seleccionado','Desayunos y almuerzos','Guía turístico','Seguro de viaje','Entradas a parques']],
        'aventura'   => ['emoji'=>'🏔️','badge'=>'Nuevo','badge_color'=>'#1d6fa4','badge_text'=>'#fff','duracion'=>'1 a 3 días','incluye'=>['Equipo de aventura','Guía especializado','Hidratación incluida','Seguro de aventura','Certificado de participación']],
        'familiar'   => ['emoji'=>'👨‍👩‍👧','badge'=>'Familiar','badge_color'=>'#7c3aed','badge_text'=>'#fff','duracion'=>'1 a 2 días','incluye'=>['Transporte familiar','Actividades para niños','Almuerzo familiar','Guía con experiencia familiar','Seguro de viaje']],
      ];
      // Agrupar paquetes por tipo
      $grupos = $paquetes->groupBy('id_tippaq');
    @endphp

    <div class="tipos-row">
      @forelse($grupos as $tipo => $pkgs)
      @php
        $precioMin = $pkgs->min('precio_base');
        $nombreTipo = strtolower($pkgs->first()->nombre_paquete ?? '');
        $info = null;
        foreach($tiposInfo as $k => $v) {
          if(str_contains($nombreTipo, $k)) { $info = $v; break; }
        }
        if(!$info) $info = array_values($tiposInfo)[$loop->index % count($tiposInfo)];
      @endphp
      <div class="tipo-card">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px;">
          <span style="font-size:2rem;">{{ $info['emoji'] }}</span>
          <span style="background:{{ $info['badge_color'] }};color:{{ $info['badge_text'] }};font-size:0.72rem;font-weight:700;padding:3px 12px;border-radius:999px;">{{ $info['badge'] }}</span>
        </div>
        <h3 style="font-size:1.15rem;font-weight:800;color:#1e3a5f;margin-bottom:8px;">{{ $pkgs->first()->nombre_paquete }}</h3>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;flex-wrap:wrap;">
          <span style="font-size:0.8rem;color:#64748b;display:flex;align-items:center;gap:4px;">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            {{ $info['duracion'] }}
          </span>
          <span style="font-size:0.9rem;font-weight:700;color:#16a34a;">Desde S/ {{ number_format($precioMin, 2) }} / persona</span>
        </div>
        <p style="font-size:0.875rem;color:#64748b;line-height:1.6;margin-bottom:18px;">{{ Str::limit($pkgs->first()->descripcion, 120) }}</p>

        <div style="background:#f8fafc;border-radius:10px;padding:14px 16px;margin-bottom:18px;">
          <p style="font-size:0.8rem;font-weight:700;color:#f59e0b;margin-bottom:10px;">👑 ¿Qué incluye?</p>
          @foreach($info['incluye'] as $inc)
          <div class="inc-item">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span style="color:#16a34a;font-weight:500;">{{ $inc }}</span>
          </div>
          @endforeach
        </div>

        <a href="{{ route('cliente.register') }}" style="display:block;width:100%;background:#1d6fa4;color:#fff;text-align:center;font-size:0.9rem;font-weight:700;padding:12px;border-radius:8px;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#1e3a5f'" onmouseout="this.style.background='#1d6fa4'">
          Reservar este Paquete
        </a>
      </div>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:40px;color:#64748b;">No hay paquetes disponibles.</div>
      @endforelse
    </div>
  </div>
</section>

{{-- ===== TODOS LOS PAQUETES (cards individuales) ===== --}}
@if($paquetes->count() > 0)
<section style="background:#f0f4f8;padding:56px 24px;">
  <div style="max-width:1060px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:36px;">
      <h2 style="font-size:1.7rem;font-weight:800;color:#1e3a5f;margin-bottom:8px;">Todos Nuestros Paquetes</h2>
      <p style="color:#64748b;font-size:0.9rem;">Elige el que más se adapte a tu aventura</p>
    </div>
    <div class="paq-grid">
      @foreach($paquetes as $i => $paq)
      @php
        $colors = ['#1d6fa4','#2d7a4f','#f59e0b','#7c3aed','#dc2626'];
        $color = $colors[$i % count($colors)];
      @endphp
      <div class="paq-card">
        {{-- Imagen --}}
        <div style="height:180px;overflow:hidden;position:relative;">
          @if($paq->imagen_url)
            <img src="{{ $paq->imagen_url }}" alt="{{ $paq->nombre_paquete }}" style="width:100%;height:100%;object-fit:cover;">
          @else
            <div style="width:100%;height:100%;background:linear-gradient(135deg,{{ $color }},#1e3a5f);display:flex;align-items:center;justify-content:center;">
              <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
            </div>
          @endif
          <div style="position:absolute;top:10px;right:10px;background:{{ $color }};color:#fff;font-size:0.8rem;font-weight:800;padding:4px 12px;border-radius:999px;">
            S/ {{ number_format($paq->precio_base, 2) }}
          </div>
        </div>
        {{-- Info --}}
        <div style="padding:18px 20px 20px;">
          <h3 style="font-size:1rem;font-weight:700;color:#1e3a5f;margin-bottom:8px;">{{ $paq->nombre_paquete }}</h3>
          <p style="font-size:0.82rem;color:#64748b;line-height:1.5;margin-bottom:16px;">{{ Str::limit($paq->descripcion, 90) }}</p>
          <div style="display:flex;gap:10px;">
            <a href="{{ route('cliente.register') }}" style="flex:1;background:#1d6fa4;color:#fff;text-align:center;font-size:0.82rem;font-weight:700;padding:10px;border-radius:8px;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#1e3a5f'" onmouseout="this.style.background='#1d6fa4'">
              Reservar
            </a>
            <a href="{{ route('cliente.tours') }}" style="flex:1;background:#fff;color:#1d6fa4;text-align:center;font-size:0.82rem;font-weight:700;padding:10px;border-radius:8px;text-decoration:none;border:1.5px solid #1d6fa4;transition:all 0.2s;" onmouseover="this.style.background='#f0f7ff'" onmouseout="this.style.background='#fff'">
              Ver Tours
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- ===== GARANTÍAS ===== --}}
<section style="background:linear-gradient(135deg,#1565c0 0%,#1d6fa4 55%,#2d9e6b 100%);padding:64px 24px;">
  <div style="max-width:1060px;margin:0 auto;text-align:center;">
    <h2 style="font-size:1.9rem;font-weight:800;color:#fff;margin-bottom:10px;">Nuestras Garantías</h2>
    <p style="color:rgba(255,255,255,0.8);font-size:0.95rem;margin-bottom:40px;">Tu tranquilidad es nuestra responsabilidad.</p>
    <div class="garantias-row" style="justify-content:center;">
      @php
        $garantias = [
          ['emoji'=>'🛡️','title'=>'Cancelación Flexible','desc'=>'Cancela hasta 24h antes sin costo. Reprogramamos sin cargo adicional por clima adverso.'],
          ['emoji'=>'📞','title'=>'Soporte en Tiempo Real','desc'=>'Tu guía siempre disponible por WhatsApp durante el tour. Línea de emergencia 24/7.'],
          ['emoji'=>'⭐','title'=>'Satisfacción Garantizada','desc'=>'Si no cumplimos con lo prometido, te devolvemos el dinero. Así de sencillo.'],
        ];
      @endphp
      @foreach($garantias as $g)
      <div class="garantia-card">
        <div style="font-size:2.2rem;margin-bottom:14px;">{{ $g['emoji'] }}</div>
        <h3 style="font-size:1rem;font-weight:700;color:#fff;margin-bottom:8px;">{{ $g['title'] }}</h3>
        <p style="font-size:0.85rem;color:rgba(255,255,255,0.8);line-height:1.6;">{{ $g['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ===== CTA FINAL ===== --}}
<section style="background:#fffbeb;padding:64px 24px;text-align:center;">
  <div style="max-width:520px;margin:0 auto;">
    <h2 style="font-size:1.8rem;font-weight:800;color:#1d6fa4;margin-bottom:12px;">¿Listo para reservar?</h2>
    <p style="color:#64748b;font-size:0.95rem;line-height:1.7;margin-bottom:32px;">
      Nuestro equipo está disponible por WhatsApp para ayudarte a elegir el paquete perfecto para ti.
    </p>
    <div class="cta-btns" style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('cliente.paquetes') }}" style="background:#1d6fa4;color:#fff;font-size:0.95rem;font-weight:700;padding:13px 28px;border-radius:10px;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#1e3a5f'" onmouseout="this.style.background='#1d6fa4'">
        Ver Todos los Paquetes
      </a>
      <a href="https://wa.me/5172523456?text=Hola,%20quiero%20reservar%20un%20paquete%20turístico%20en%20Tumbes" target="_blank" style="background:#f59e0b;color:#1e3a5f;font-size:0.95rem;font-weight:700;padding:13px 28px;border-radius:10px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:background 0.2s;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
        Reservar por WhatsApp
      </a>
    </div>
  </div>
</section>

@endsection
