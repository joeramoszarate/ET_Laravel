<style>
.footer-social:hover { background: rgba(255,255,255,0.25) !important; }
.footer-link:hover { color: #f59e0b !important; }
.footer-bottom-link:hover { color: #f59e0b !important; }

@media (max-width: 768px) {
  .footer-grid { grid-template-columns: 1fr !important; gap: 32px !important; }
  .footer-bottom-inner { flex-direction: column !important; gap: 12px !important; text-align: center !important; }
  .footer-bottom-links { justify-content: center !important; }
}
</style>

<footer style="background: linear-gradient(135deg, #1565c0 0%, #1d6fa4 50%, #2d9e6b 100%); padding: 52px 24px 0;">
  <div style="max-width: 1100px; margin: 0 auto;">
    <div class="footer-grid" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 48px; padding-bottom: 40px;">

@php $cfg = $cfg ?? \App\Models\Configuracion::first(); @endphp
      {{-- Columna 1: Logo + descripción + redes --}}
      <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
          @if($cfg && $cfg->logo_url)
            <img src="{{ $cfg->logo_url }}" alt="Logo" style="height:40px; width:auto; object-fit:contain; border-radius:8px; background:#fff; padding:4px;">
          @else
            <div style="background: #f59e0b; border-radius: 10px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1e3a5f" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                <circle cx="12" cy="9" r="2.5" fill="#1e3a5f" stroke="none"/>
              </svg>
            </div>
          @endif
          <span style="font-size: 1.2rem; font-weight: 800; color: #fff; letter-spacing: 0.01em;">{{ $cfg->nombre_empresa ?? 'ExploreTuTumbes' }}</span>
        </div>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem; line-height: 1.7; max-width: 300px; margin-bottom: 24px;">
          {{ $cfg->seccion_nosotros_texto ?? 'Tu agencia de confianza para descubrir las maravillas naturales de la región Tumbes.' }}
        </p>
        {{-- Redes sociales --}}
        <div style="display: flex; gap: 10px;">
          <a href="{{ $cfg->facebook_url ?? '#' }}" class="footer-social" style="width:38px;height:38px;border-radius:8px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;transition:background 0.2s;text-decoration:none;">
            <svg width="16" height="16" fill="#fff" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
          </a>
          <a href="{{ $cfg->instagram_url ?? '#' }}" class="footer-social" style="width:38px;height:38px;border-radius:8px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;transition:background 0.2s;text-decoration:none;">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path stroke-linecap="round" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
          @if($cfg && $cfg->whatsapp)
          <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$cfg->whatsapp) }}" class="footer-social" style="width:38px;height:38px;border-radius:8px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;transition:background 0.2s;text-decoration:none;">
            <svg width="16" height="16" fill="#fff" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          </a>
          @endif
        </div>
      </div>

      {{-- Columna 2: Enlaces rápidos --}}
      <div>
        <h4 style="color: #f59e0b; font-size: 0.95rem; font-weight: 700; margin-bottom: 20px; letter-spacing: 0.02em;">Enlaces Rápidos</h4>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 12px;">
          @php
            $links = [
              ['label' => 'Inicio',        'route' => 'cliente.inicio'],
              ['label' => 'Tours',         'route' => 'cliente.tours'],
              ['label' => 'Destinos',      'route' => 'cliente.destinos'],
              ['label' => 'Paquetes',      'route' => 'cliente.paquetes'],
              ['label' => 'Iniciar Sesión','route' => 'cliente.login'],
              ['label' => 'Registrarse',   'route' => 'cliente.register'],
            ];
          @endphp
          @foreach($links as $link)
          <li style="display: flex; align-items: center; gap: 8px;">
            <span style="width: 6px; height: 6px; border-radius: 50%; background: #f59e0b; flex-shrink: 0;"></span>
            <a href="{{ route($link['route']) }}" class="footer-link" style="color: rgba(255,255,255,0.85); font-size: 0.875rem; text-decoration: none; transition: color 0.2s;">{{ $link['label'] }}</a>
          </li>
          @endforeach
        </ul>
      </div>

      {{-- Columna 3: Contacto --}}
      <div>
        <h4 style="color: #f59e0b; font-size: 0.95rem; font-weight: 700; margin-bottom: 20px; letter-spacing: 0.02em;">Contacto</h4>
        <div style="display: flex; flex-direction: column; gap: 18px;">
          {{-- Email --}}
          <div style="display: flex; align-items: flex-start; gap: 12px;">
            <div style="background: rgba(245,158,11,0.2); border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
              <p style="color: rgba(255,255,255,0.55); font-size: 0.72rem; margin-bottom: 2px;">Email</p>
              <p style="color: #fff; font-size: 0.85rem; font-weight: 500;">info@exploretutumbes.com</p>
            </div>
          </div>
          {{-- Teléfono --}}
          <div style="display: flex; align-items: flex-start; gap: 12px;">
            <div style="background: rgba(245,158,11,0.2); border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </div>
            <div>
              <p style="color: rgba(255,255,255,0.55); font-size: 0.72rem; margin-bottom: 2px;">Teléfono</p>
              <p style="color: #fff; font-size: 0.85rem; font-weight: 500;">+51 72 523 456</p>
            </div>
          </div>
          {{-- Ubicación --}}
          <div style="display: flex; align-items: flex-start; gap: 12px;">
            <div style="background: rgba(245,158,11,0.2); border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
            </div>
            <div>
              <p style="color: rgba(255,255,255,0.55); font-size: 0.72rem; margin-bottom: 2px;">Ubicación</p>
              <p style="color: #fff; font-size: 0.85rem; font-weight: 500;">Tumbes, Perú</p>
            </div>
          </div>
        </div>
      </div>

    </div>

    {{-- Línea divisora --}}
    <div style="border-top: 1px solid rgba(255,255,255,0.15); padding: 20px 0;">
      <div class="footer-bottom-inner" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <p style="color: rgba(255,255,255,0.6); font-size: 0.8rem; margin: 0;">
          © {{ date('Y') }} {{ $cfg->nombre_empresa ?? 'ExploreTuTumbes' }}. Todos los derechos reservados.
        </p>
        <div class="footer-bottom-links" style="display: flex; gap: 20px;">
          <a href="#" class="footer-bottom-link" style="color: rgba(255,255,255,0.6); font-size: 0.8rem; text-decoration: none; transition: color 0.2s;">Términos y Condiciones</a>
          <a href="#" class="footer-bottom-link" style="color: rgba(255,255,255,0.6); font-size: 0.8rem; text-decoration: none; transition: color 0.2s;">Política de Privacidad</a>
          <a href="#" class="footer-bottom-link" style="color: rgba(255,255,255,0.6); font-size: 0.8rem; text-decoration: none; transition: color 0.2s;">Ayuda</a>
        </div>
      </div>
    </div>
  </div>
</footer>
