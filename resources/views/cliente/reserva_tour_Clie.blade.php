@extends('cliente.layout_clie')

@section('title', 'Reservar ' . $tour->nombre_tour)

@section('content')
<div style="background:linear-gradient(135deg,#f5f7fa 0%,#e8ecf1 100%); min-height:100vh; padding:40px 20px;">
  <div style="max-width:1200px; margin:0 auto;">
    {{-- Encabezado --}}
    <div style="margin-bottom:28px;">
      <a href="{{ route('cliente.tours') }}" style="display:inline-flex; align-items:center; gap:6px; color:#0e7490; text-decoration:none; font-weight:600; margin-bottom:16px; transition:color 0.15s;" onmouseover="this.style.color='#0d5f7a'" onmouseout="this.style.color='#0e7490'">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a tours
      </a>
      <h1 style="margin:0 0 8px; font-size:2rem; color:#1e3a5f;">Reservar {{ $tour->nombre_tour }}</h1>
      <p style="margin:0; color:#64748b; font-size:0.95rem;">{{ $tour->destino->nombre ?? 'Destino' }} • Duración: {{ $tour->duracion_dias }} días</p>
    </div>

    <div style="display:grid; gap:24px; grid-template-columns:1fr 420px;">
      {{-- Formulario principal --}}
      <div style="background:#fff; border-radius:16px; padding:32px; box-shadow:0 8px 24px rgba(0,0,0,0.08);">
        <form action="{{ route('cliente.tours.reserva.store', $tour->id_tour) }}" method="POST" id="formReserva" style="display:grid; gap:28px;">
          @csrf

          {{-- Sección 1: Estadia --}}
          <div style="border-bottom:2px solid #e2e8f0; padding-bottom:28px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
              <div style="width:28px; height:28px; background:#0e7490; color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem;">1</div>
              <h2 style="margin:0; font-size:1.1rem; color:#1e3a5f; font-weight:700;">Estadia</h2>
            </div>

            <div style="display:grid; gap:16px; grid-template-columns:1fr 1fr;">
              <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">Tipo de habitación *</label>
                <select name="tipo_habitacion" style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; background:#fff; cursor:pointer; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
                  <option value="">Selecciona tipo...</option>
                  <option value="familiar_estandar">Familiar Estándar</option>
                  <option value="individual">Individual</option>
                  <option value="doble">Doble</option>
                  <option value="suite">Suite</option>
                </select>
              </div>
              <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">N° Habitación</label>
                <input type="text" name="nro_habitacion" value="212" style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
              </div>
            </div>
          </div>

          {{-- Sección 2: Huéspedes --}}
          <div style="border-bottom:2px solid #e2e8f0; padding-bottom:28px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
              <div style="width:28px; height:28px; background:#0e7490; color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem;">2</div>
              <h2 style="margin:0; font-size:1.1rem; color:#1e3a5f; font-weight:700;">Huéspedes</h2>
            </div>

            <div style="display:grid; gap:16px; grid-template-columns:1fr 1fr 1fr;">
              <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">Adultos *</label>
                <input type="number" name="adultos" value="1" min="1" required style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
              </div>
              <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">Niños</label>
                <input type="number" name="ninos" value="0" min="0" style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
              </div>
              <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">Desc. por noche</label>
                <input type="number" name="descuentos_noche" value="0" min="0" step="0.01" style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
              </div>
            </div>
          </div>

          {{-- Sección 3: Tipo de recepción --}}
          <div style="border-bottom:2px solid #e2e8f0; padding-bottom:28px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
              <div style="width:28px; height:28px; background:#0e7490; color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem;">3</div>
              <h2 style="margin:0; font-size:1.1rem; color:#1e3a5f; font-weight:700;">Tipo de recepción</h2>
            </div>

            <div style="display:grid; gap:12px; grid-template-columns:1fr 1fr;">
              <label style="display:flex; align-items:center; gap:10px; padding:12px 14px; border:1.5px solid #cbd5e1; border-radius:10px; cursor:pointer; transition:all 0.15s;">
                <input type="radio" name="tipo_recepcion" value="individual" checked style="width:16px; height:16px; cursor:pointer; accent-color:#0e7490;">
                <span style="color:#334155; font-weight:500;">Individual</span>
              </label>
              <label style="display:flex; align-items:center; gap:10px; padding:12px 14px; border:1.5px solid #cbd5e1; border-radius:10px; cursor:pointer; transition:all 0.15s;">
                <input type="radio" name="tipo_recepcion" value="grupal" style="width:16px; height:16px; cursor:pointer; accent-color:#0e7490;">
                <span style="color:#334155; font-weight:500;">Grupal</span>
              </label>
            </div>
          </div>

          {{-- Sección 4: Canal y detalles de reserva --}}
          <div style="border-bottom:2px solid #e2e8f0; padding-bottom:28px;">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
              <div style="width:28px; height:28px; background:#0e7490; color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.9rem;">4</div>
              <h2 style="margin:0; font-size:1.1rem; color:#1e3a5f; font-weight:700;">Detalles de reservación</h2>
            </div>

            <div style="display:grid; gap:16px; grid-template-columns:1fr 1fr;">
              <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">Canal *</label>
                <select name="canal" required style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; background:#fff; cursor:pointer; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
                  <option value="">Selecciona canal...</option>
                  <option value="agencia_wayra">Agencia Wayra Tours</option>
                  <option value="directo">Directo</option>
                  <option value="otro">Otro</option>
                </select>
              </div>
              <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">Fecha de reserva *</label>
                <input type="date" name="fecha_inicio" required style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
              </div>
            </div>

            <div style="display:grid; gap:16px; grid-template-columns:1fr 1fr; margin-top:16px;">
              <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">Hora de llegada *</label>
                <input type="time" name="hora_llegada" value="14:00" required style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
              </div>
              <div>
                <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">Hora de salida *</label>
                <input type="time" name="hora_salida" value="11:00" required style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'">
              </div>
            </div>

            <div style="margin-top:16px;">
              <label style="display:block; margin-bottom:8px; font-weight:600; color:#334155; font-size:0.9rem;">Observaciones</label>
              <textarea name="observaciones" rows="3" placeholder="Agrega notas o solicitudes especiales..." style="width:100%; padding:11px 13px; border-radius:10px; border:1.5px solid #cbd5e1; font-size:0.95rem; resize:vertical; font-family:inherit; transition:border-color 0.15s;" onfocus="this.style.borderColor='#0e7490'" onblur="this.style.borderColor='#cbd5e1'"></textarea>
            </div>
          </div>

          {{-- Botones --}}
          <div style="display:flex; gap:12px; justify-content:flex-end;">
            <a href="{{ route('cliente.tours') }}" style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; border:1.5px solid #cbd5e1; border-radius:10px; background:#fff; color:#475569; font-weight:600; text-decoration:none; transition:all 0.15s;" onmouseover="this.style.borderColor='#94a3b8'; this.style.background='#f1f5f9'" onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#fff'">
              ← Cancelar
            </a>
            <button type="submit" style="display:inline-flex; align-items:center; gap:8px; padding:12px 28px; background:linear-gradient(135deg,#0e7490 0%,#0d5f7a 100%); color:#fff; border:none; border-radius:10px; font-weight:700; cursor:pointer; transition:all 0.15s; box-shadow:0 4px 12px rgba(14,116,144,0.25);" onmouseover="this.style.boxShadow='0 8px 20px rgba(14,116,144,0.35)'" onmouseout="this.style.boxShadow='0 4px 12px rgba(14,116,144,0.25)'">
              ✓ Confirmar reserva
            </button>
          </div>
        </form>
      </div>

      {{-- Panel lateral: Resumen --}}
      <div style="height:fit-content; position:sticky; top:20px;">
        <div style="background:#fff; border-radius:16px; padding:24px; box-shadow:0 8px 24px rgba(0,0,0,0.08); margin-bottom:20px;">
          <h3 style="margin-top:0; margin-bottom:16px; font-size:1rem; color:#1e3a5f; font-weight:700;">Consumos y pagos</h3>
          
          <div style="background:linear-gradient(135deg,#f5f7fa 0%,#e8ecf1 100%); border-radius:12px; padding:16px; margin-bottom:16px;">
            <div style="display:grid; gap:12px; font-size:0.9rem;">
              <div style="display:flex; justify-content:space-between; color:#64748b;">
                <span>Habitación Familiar Estándar</span>
                <span style="font-weight:600;">S/ {{ number_format($tour->precio, 2) }}</span>
              </div>
              <div style="border-top:1px solid #cbd5e1; padding-top:12px; display:flex; justify-content:space-between; color:#1e3a5f; font-weight:700;">
                <span>Subtotal</span>
                <span>S/ <span id="subtotal">{{ number_format($tour->precio, 2) }}</span></span>
              </div>
            </div>
          </div>

          <div style="background:#eff6ff; border-left:4px solid #0e7490; padding:12px; border-radius:8px; margin-bottom:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.9rem;">
              <span style="color:#0e7490; font-weight:600;">IGV: S/ 0.00</span>
              <span style="color:#0e7490; font-weight:600;">Sin IGV</span>
            </div>
          </div>

          <div style="background:linear-gradient(135deg,#0e7490 0%,#0d5f7a 100%); color:#fff; border-radius:12px; padding:16px; text-align:center; margin-bottom:20px;">
            <div style="font-size:0.85rem; color:rgba(255,255,255,0.8); margin-bottom:8px;">TOTAL</div>
            <div style="font-size:1.8rem; font-weight:800;">S/ <span id="total">{{ number_format($tour->precio, 2) }}</span></div>
          </div>

          <div style="background:#fef3c7; border-left:4px solid #f59e0b; padding:12px; border-radius:8px; font-size:0.85rem; color:#7c2d12;">
            <strong style="display:block; margin-bottom:4px;">ℹ️ Información</strong>
            <p style="margin:0;">Confirma tu reserva y nos contactaremos en 24 horas para validar tu pago.</p>
          </div>
        </div>

        {{-- Información del cliente --}}
        <div style="background:#fff; border-radius:16px; padding:20px; box-shadow:0 8px 24px rgba(0,0,0,0.08);">
          <h4 style="margin-top:0; margin-bottom:14px; font-size:0.95rem; color:#1e3a5f; font-weight:700;">Datos del cliente</h4>
          <div style="font-size:0.85rem; color:#64748b;">
            <div style="margin-bottom:10px;">
              <span style="color:#334155; font-weight:600;">{{ $cliente->nombre }} {{ $cliente->apellidos }}</span>
            </div>
            <div style="margin-bottom:10px;">
              <span style="color:#64748b;">📧 {{ $cliente->correo }}</span>
            </div>
            <div>
              <span style="color:#64748b;">📞 {{ $cliente->telefono ?? 'No registrado' }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelectorAll('input[name="adultos"], input[name="ninos"], input[name="descuentos_noche"]').forEach(input => {
    input.addEventListener('change', actualizarTotal);
  });

  function actualizarTotal() {
    const adultos = parseInt(document.querySelector('input[name="adultos"]').value) || 0;
    const ninos = parseInt(document.querySelector('input[name="ninos"]').value) || 0;
    const descuento = parseFloat(document.querySelector('input[name="descuentos_noche"]').value) || 0;
    const precioPorPersona = {{ $tour->precio }};
    
    const totalPersonas = adultos + ninos;
    let total = precioPorPersona * totalPersonas;
    total = Math.max(0, total - descuento);
    
    document.getElementById('subtotal').textContent = total.toFixed(2);
    document.getElementById('total').textContent = total.toFixed(2);
  }
</script>

<style>
  @media (max-width: 900px) {
    div[style*="grid-template-columns:1fr 420px"] { grid-template-columns: 1fr !important; }
    div[style*="position:sticky"] { position: static !important; }
  }
  @media (max-width: 600px) {
    div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
    h1[style*="2rem"] { font-size: 1.5rem !important; }
    div[style*="padding:32px"] { padding: 20px !important; }
  }
</style>
@endsection
