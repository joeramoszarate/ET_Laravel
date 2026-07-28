@extends('cliente.layout_clie')

@section('title', 'Mi perfil')

@section('content')
<div style="background:linear-gradient(135deg,#0f766e 0%,#0e7490 60%,#1e3a5f 100%); min-height:100vh; padding:40px 20px;">
  <div style="max-width:1100px; margin:0 auto; display:grid; gap:24px;">
    {{-- Header --}}
    <div style="background:rgba(255,255,255,0.95); border-radius:24px; padding:30px; box-shadow:0 20px 45px rgba(0,0,0,0.15);">
      <div style="display:flex; justify-content:space-between; align-items:center; gap:20px; flex-wrap:wrap;">
        <div>
          <p style="margin:0; font-size:0.85rem; font-weight:700; text-transform:uppercase; letter-spacing:0.16em; color:#0e7490;">Mi perfil</p>
          <h1 style="margin:6px 0 0; font-size:1.8rem; color:#1e3a5f;">Gestiona tu cuenta</h1>
          <p style="margin:8px 0 0; color:#64748b; max-width:600px; font-size:0.9rem;">Actualiza tus datos personales, sube una foto, agrega una descripción y cambia tu contraseña.</p>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
          @if($cliente->foto_perfil)
            <img src="{{ asset('storage/' . $cliente->foto_perfil) }}" alt="Foto de perfil" style="width:80px; height:80px; object-fit:cover; border-radius:50%; border:3px solid #0e7490; box-shadow:0 8px 18px rgba(14,116,144,0.25);">
          @else
            <div style="width:80px; height:80px; border-radius:50%; border:3px solid #0e7490; background:linear-gradient(135deg,#0e7490 0%,#0f766e 100%); display:flex; align-items:center; justify-content:center; color:#fff; font-size:2rem; font-weight:700; box-shadow:0 8px 18px rgba(14,116,144,0.25);">{{ substr($cliente->nombre, 0, 1) }}</div>
          @endif
        </div>
      </div>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
      <div style="background:#ecfdf5; border-left:4px solid #10b981; color:#047857; border-radius:12px; padding:14px 16px; font-weight:600; font-size:0.9rem;">✓ {{ session('success') }}</div>
    @endif
    @if(session('success_password'))
      <div style="background:#ecfdf5; border-left:4px solid #10b981; color:#047857; border-radius:12px; padding:14px 16px; font-weight:600; font-size:0.9rem;">✓ {{ session('success_password') }}</div>
    @endif
    @if($errors->any())
      <div style="background:#fef2f2; border-left:4px solid #ef4444; color:#b91c1c; border-radius:12px; padding:14px 16px; font-size:0.9rem;">
        <strong style="display:block; margin-bottom:8px;">Errores encontrados:</strong>
        <ul style="margin:0; padding-left:20px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Contenido principal --}}
    <div style="display:grid; gap:24px; grid-template-columns:1.15fr 0.85fr;">
      {{-- Formulario de información personal --}}
      <div style="background:#fff; border-radius:20px; padding:28px; box-shadow:0 12px 30px rgba(0,0,0,0.08);">
        <h2 style="margin-top:0; margin-bottom:20px; font-size:1.2rem; color:#1e3a5f;">Información personal</h2>
        <form action="{{ route('cliente.perfil.actualizar') }}" method="POST" enctype="multipart/form-data" style="display:grid; gap:16px;">
          @csrf
          
          {{-- Nombres y apellidos --}}
          <div style="display:grid; gap:14px; grid-template-columns:1fr 1fr;">
            <div>
              <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.9rem;">Nombres *</label>
              <input type="text" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required style="width:100%; padding:11px 13px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
            </div>
            <div>
              <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.9rem;">Apellidos *</label>
              <input type="text" name="apellidos" value="{{ old('apellidos', $cliente->apellidos) }}" required style="width:100%; padding:11px 13px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
            </div>
          </div>

          {{-- Correo y teléfono --}}
          <div style="display:grid; gap:14px; grid-template-columns:1fr 1fr;">
            <div>
              <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.9rem;">Correo electrónico *</label>
              <input type="email" name="correo" value="{{ old('correo', $cliente->correo) }}" required style="width:100%; padding:11px 13px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
            </div>
            <div>
              <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.9rem;">Teléfono</label>
              <input type="text" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" style="width:100%; padding:11px 13px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
            </div>
          </div>

          {{-- Nacionalidad y foto --}}
          <div style="display:grid; gap:14px; grid-template-columns:1fr 1fr;">
            <div>
              <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.9rem;">Nacionalidad</label>
              <input type="text" name="nacionalidad" value="{{ old('nacionalidad', $cliente->nacionalidad) }}" style="width:100%; padding:11px 13px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
            </div>
            <div>
              <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.9rem;">Foto de perfil</label>
              <input type="file" name="foto_perfil" accept="image/jpeg,image/png,image/webp" id="fotoPerfil" style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.9rem; cursor:pointer; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
              <small style="display:block; margin-top:4px; color:#64748b; font-size:0.8rem;">JPG, PNG, WebP • Máx 2 MB</small>
            </div>
          </div>

          {{-- Descripción --}}
          <div>
            <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.9rem;">Descripción personal</label>
            <textarea name="descripcion" rows="4" placeholder="Cuéntanos sobre ti, tus intereses o experiencias..." style="width:100%; padding:11px 13px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.95rem; resize:vertical; font-family:inherit; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">{{ old('descripcion', $cliente->descripcion) }}</textarea>
            <small style="display:block; margin-top:4px; color:#64748b; font-size:0.8rem;">Máximo 500 caracteres</small>
          </div>

          {{-- Botón enviar --}}
          <button type="submit" style="background:#0e7490; color:#fff; border:none; border-radius:8px; padding:12px 18px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:background 0.15s; margin-top:8px;" onmouseover="this.style.background='#0d5f7a'" onmouseout="this.style.background='#0e7490'">💾 Guardar cambios</button>
        </form>
      </div>

      {{-- Panel lateral --}}
      <div style="display:grid; gap:20px;">
        {{-- Cambiar contraseña --}}
        <div style="background:#fff; border-radius:20px; padding:24px; box-shadow:0 12px 30px rgba(0,0,0,0.08);">
          <h3 style="margin-top:0; margin-bottom:16px; font-size:1.05rem; color:#1e3a5f;">Cambiar contraseña</h3>
          <form action="{{ route('cliente.perfil.password') }}" method="POST" style="display:grid; gap:12px;">
            @csrf
            <div>
              <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.85rem;">Contraseña actual *</label>
              <input type="password" name="current_password" required style="width:100%; padding:11px 13px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.9rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
            </div>
            <div>
              <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.85rem;">Nueva contraseña *</label>
              <input type="password" name="password" required style="width:100%; padding:11px 13px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.9rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
            </div>
            <div>
              <label style="display:block; margin-bottom:6px; font-weight:600; color:#334155; font-size:0.85rem;">Confirmar contraseña *</label>
              <input type="password" name="password_confirmation" required style="width:100%; padding:11px 13px; border-radius:8px; border:1px solid #cbd5e1; font-size:0.9rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
            </div>
            <button type="submit" style="background:#f59e0b; color:#fff; border:none; border-radius:8px; padding:11px 16px; font-weight:600; font-size:0.9rem; cursor:pointer; transition:background 0.15s;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">🔐 Actualizar</button>
          </form>
        </div>

        {{-- Información de cuenta --}}
        <div style="background:linear-gradient(135deg,#f0f9ff 0%,#e0f2fe 100%); border-radius:20px; padding:24px; border:1px solid #bae6fd;">
          <h3 style="margin-top:0; margin-bottom:14px; font-size:1.05rem; color:#0e7490;">Tu cuenta</h3>
          <div style="display:grid; gap:10px; font-size:0.85rem;">
            <div>
              <span style="color:#0e7490; font-weight:600;">Documento:</span>
              <span style="color:#334155;">{{ $cliente->nro_documento }}</span>
            </div>
            <div>
              <span style="color:#0e7490; font-weight:600;">Correo:</span>
              <span style="color:#334155;">{{ $cliente->correo }}</span>
            </div>
            <div>
              <span style="color:#0e7490; font-weight:600;">Estado:</span>
              <span style="color:#10b981; font-weight:600;">✓ Activa</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  @media (max-width: 900px) {
    div[style*="grid-template-columns:1.15fr 0.85fr"] { grid-template-columns: 1fr !important; }
    div[style*="flex-wrap:wrap"] { flex-direction: column !important; text-align: center !important; }
  }
  @media (max-width: 600px) {
    div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
    [style*="max-width:1100px"] { padding: 20px 16px !important; }
    h1[style*="1.8rem"] { font-size: 1.4rem !important; }
  }
</style>
@endsection
