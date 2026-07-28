<nav style="background:#fff; border-bottom:1px solid #e5e7eb; box-shadow:0 1px 4px rgba(0,0,0,0.07);">
  <div style="max-width:1200px; margin:0 auto; padding:0 24px; display:flex; align-items:center; justify-content:space-between; height:64px;">

    {{-- Logo + Nombre --}}
@php $cfg = \App\Models\Configuracion::first(); @endphp
    <a href="{{ route('cliente.inicio') }}" style="display:flex; align-items:center; gap:12px; text-decoration:none;">
      @if($cfg && $cfg->logo_url)
        <img src="{{ $cfg->logo_url }}" alt="Logo" style="height:42px; width:auto; object-fit:contain; border-radius:8px;">
      @else
        <div style="background:#0e7490; border-radius:10px; width:42px; height:42px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
            <circle cx="12" cy="9" r="2.5" fill="#fff" stroke="none"/>
          </svg>
        </div>
      @endif
      <div style="line-height:1.2;">
        <div style="font-weight:700; font-size:1.05rem; color:#1e3a5f; letter-spacing:0.01em;">{{ $cfg->nombre_empresa ?? 'ExploreTuTumbes' }}</div>
        <div style="font-size:0.72rem; color:#16a34a; font-weight:500;">{{ $cfg->slogan ?? 'Región Tumbes' }}</div>
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
        <div style="position:relative; display:flex; align-items:center; gap:10px;">
          @php $cliente = \App\Models\Cliente::find(session('cliente_id')); @endphp
          <button id="btnPerfil" style="display:flex; align-items:center; gap:8px; background:#f0f9ff; border:1.5px solid #bae6fd; border-radius:8px; padding:6px 14px; cursor:pointer; font-size:0.875rem; font-weight:600; color:#0e7490; transition:all 0.15s;" onmouseover="this.style.background='#e0f2fe'" onmouseout="this.style.background='#f0f9ff'">
            @if($cliente && $cliente->foto_perfil)
              <img src="{{ asset('storage/' . $cliente->foto_perfil) }}" alt="Avatar" style="width:24px; height:24px; border-radius:50%; object-fit:cover;">
            @else
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            @endif
            <span>{{ session('cliente_nombre') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
          </button>
          <div id="dropdownPerfil" style="position:absolute; top:100%; right:0; margin-top:8px; background:#fff; border:1.5px solid #e5e7eb; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.12); min-width:200px; display:none; z-index:1000;">
            <a href="{{ route('cliente.perfil') }}" style="display:flex; align-items:center; gap:10px; padding:12px 16px; color:#1e3a5f; text-decoration:none; border-bottom:1px solid #e5e7eb; font-size:0.875rem; transition:background 0.15s;" onmouseover="this.style.background='#f0f9ff'" onmouseout="this.style.background='transparent'">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Mi perfil
            </a>
            <form action="{{ route('cliente.logout') }}" method="POST" style="margin:0;">
              @csrf
              <button type="submit" style="width:100%; display:flex; align-items:center; gap:10px; padding:12px 16px; background:none; border:none; color:#ef4444; text-decoration:none; font-size:0.875rem; cursor:pointer; transition:background 0.15s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                </svg>
                Salir
              </button>
            </form>
          </div>
        </div>
        <script>
          const btnPerfil = document.getElementById('btnPerfil');
          const dropdownPerfil = document.getElementById('dropdownPerfil');
          btnPerfil.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownPerfil.style.display = dropdownPerfil.style.display === 'none' ? 'block' : 'none';
          });
          document.addEventListener('click', function() {
            dropdownPerfil.style.display = 'none';
          });
        </script>
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
