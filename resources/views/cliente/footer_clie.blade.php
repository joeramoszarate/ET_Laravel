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

      {{-- Columna 1: Logo + descripción + redes --}}
      <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
          <div style="background: #f59e0b; border-radius: 10px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#1e3a5f" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
              <circle cx="12" cy="9" r="2.5" fill="#1e3a5f" stroke="none"/>
            </svg>
          </div>
          <span style="font-size: 1.2rem; font-weight: 800; color: #fff; letter-spacing: 0.01em;">ExploreTuTumbes</span>
        </div>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.875rem; line-height: 1.7; max-width: 300px; margin-bottom: 24px;">
          Tu agencia de confianza para descubrir las maravillas naturales de la región Tumbes. Experiencias únicas en playas, manglares y naturaleza salvaje del norte del Perú.
        </p>
        {{-- Redes sociales --}}
        <div style="display: flex; gap: 10px;">
          <a href="#" class="footer-social" style="width: 38px; height: 38px; border-radius: 8px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; transition: background 0.2s; text-decoration: none;">
            <svg width="16" height="16" fill="#fff" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
          </a>
          <a href="#" class="footer-social" style="width: 38px; height: 38px; border-radius: 8px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; transition: background 0.2s; text-decoration: none;">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path stroke-linecap="round" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
          <a href="#" class="footer-social" style="width: 38px; height: 38px; border-radius: 8px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; transition: background 0.2s; text-decoration: none;">
            <svg width="16" height="16" fill="#fff" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
          </a>
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
          © {{ date('Y') }} ExploreTuTumbes. Todos los derechos reservados.
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
