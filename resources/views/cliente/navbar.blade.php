<nav style="background:#fff; border-bottom:1px solid #e5e7eb; box-shadow:0 1px 4px rgba(0,0,0,0.07);">
  <div style="max-width:1200px; margin:0 auto; padding:0 24px; display:flex; align-items:center; justify-content:space-between; height:64px;">

    {{-- Logo + Nombre --}}
    <a href="{{ route('cliente.inicio') }}" style="display:flex; align-items:center; gap:12px; text-decoration:none;">
      <div style="background:#0e7490; border-radius:10px; width:42px; height:42px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
          <circle cx="12" cy="9" r="2.5" fill="#fff" stroke="none"/>
        </svg>
      </div>
      <div style="line-height:1.2;">
        <div style="font-weight:700; font-size:1.05rem; color:#1e3a5f; letter-spacing:0.01em;">ExploreTuTumbes</div>
        <div style="font-size:0.72rem; color:#16a34a; font-weight:500;">Región Tumbes</div>
      </div>
    </a>

    {{-- Links de navegación --}}
    <div class="nav-links" style="display:flex; align-items:center; gap:32px;">
      <a href="{{ route('cliente.inicio') }}" class="nav-link">Inicio</a>
      <a href="{{ route('cliente.tours') }}" class="nav-link">Tours</a>
      <a href="{{ route('cliente.destinos') }}" class="nav-link">Destinos</a>
      <a href="{{ route('cliente.paquetes') }}" class="nav-link">Paquetes</a>
    </div>

    {{-- Botones auth --}}
    <div style="display:flex; align-items:center; gap:12px;">
      @if(session('cliente_id'))
        {{-- Usuario logueado --}}
        <div style="display:flex; align-items:center; gap:10px;">
          <div style="display:flex; align-items:center; gap:8px; background:#f0f9ff; border:1.5px solid #bae6fd; border-radius:8px; padding:6px 14px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#0e7490" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span style="font-size:0.875rem; font-weight:600; color:#0e7490;">{{ session('cliente_nombre') }}</span>
          </div>
          <form action="{{ route('cliente.logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" style="display:flex; align-items:center; gap:5px; background:none; border:1.5px solid #e5e7eb; color:#6b7280; font-size:0.875rem; font-weight:500; padding:6px 12px; border-radius:8px; cursor:pointer; transition:all 0.15s;" onmouseover="this.style.borderColor='#ef4444';this.style.color='#ef4444'" onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#6b7280'">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
              </svg>
              Salir
            </button>
          </form>
        </div>
      @else
        {{-- No logueado --}}
        <a href="{{ route('cliente.login') }}" style="display:flex; align-items:center; gap:6px; color:#374151; font-size:0.9rem; font-weight:500; text-decoration:none; padding:6px 10px; border-radius:6px; transition:background 0.15s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
          </svg>
          Ingresar
        </a>
        <a href="{{ route('cliente.register') }}" style="display:flex; align-items:center; gap:6px; background:#f59e0b; color:#fff; font-size:0.9rem; font-weight:600; padding:8px 18px; border-radius:8px; text-decoration:none; transition:background 0.15s; box-shadow:0 1px 3px rgba(0,0,0,0.12);" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          Registrarse
        </a>
      @endif
    </div>
  </div>
</nav>

<style>
  .nav-link {
    color: #374151;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    padding: 4px 2px;
    border-bottom: 2px solid transparent;
    transition: color 0.15s, border-color 0.15s;
  }
  .nav-link:hover {
    color: #0e7490;
    border-bottom-color: #0e7490;
  }
</style>
