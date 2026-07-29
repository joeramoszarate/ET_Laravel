@extends('cliente.layout_clie')

@section('title', 'Pago de Reserva')

@section('content')
<div style="background:linear-gradient(135deg,#f8fafc 0%,#eef2f7 100%); min-height:100vh; padding:40px 20px;">
  <div style="max-width:1000px; margin:0 auto;">
    <div style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
      <h1 style="margin:0; font-size:1.6rem; color:#0e7490;">Pago de reserva</h1>
      <a href="{{ route('cliente.inicio') }}" style="color:#0e7490; text-decoration:none; font-weight:600;">Volver al inicio</a>
    </div>

    <div style="display:grid; grid-template-columns:1fr 360px; gap:20px;">
      <div style="background:#fff; padding:22px; border-radius:12px; box-shadow:0 8px 24px rgba(2,6,23,0.06);">
        <h2 style="margin-top:0; color:#0f172a;">Reserva {{ $reserva->id_reserva }}</h2>
        <p style="color:#475569;">Cliente: <strong>{{ $reserva->id_cliente }}</strong></p>
        @if($detalle && isset($detalle->tour))
          <p style="color:#475569;">Tour: <strong>{{ $detalle->tour->nombre_tour }}</strong></p>
          <p style="color:#475569;">Personas: <strong>{{ $detalle->cantidad_persona }}</strong></p>
          <p style="color:#475569;">Precio unitario: <strong>S/ {{ number_format($detalle->precio_unitario,2) }}</strong></p>
        @endif
        <p style="color:#475569;">Total a pagar: <strong>S/ {{ number_format($reserva->precio_publicado,2) }}</strong></p>
        <p style="color:#475569;">Estado: <strong>{{ $reserva->estado == 'P' ? 'Pendiente' : ($reserva->estado=='C'?'Confirmada':'Anulada') }}</strong></p>

        <hr style="margin:18px 0;">

        <form action="{{ route('cliente.reservas.pago.store', $reserva->id_reserva) }}" method="POST">
          @csrf
          <input type="hidden" name="monto" value="{{ $reserva->precio_publicado }}">

          <div style="margin-bottom:12px;">
            <label style="display:block; margin-bottom:6px; color:#334155; font-weight:600;">Método de pago</label>
            <select name="id_metpago" required style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid #e2e8f0;">
              <option value="">Selecciona método...</option>
              @foreach($metodos as $met)
                <option value="{{ $met->id_metpago }}">{{ $met->descripcion }} @if(isset($met->detalles)) - {{ $met->detalles }} @endif</option>
              @endforeach
            </select>
          </div>

          <div style="margin-bottom:12px;">
            <label style="display:block; margin-bottom:6px; color:#334155; font-weight:600;">Referencia / N° Transacción (opcional)</label>
            <input type="text" name="descripcion" placeholder="Ej. código de transfer" style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid #e2e8f0;">
          </div>

          <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:18px;">
            <a href="{{ route('cliente.inicio') }}" style="padding:10px 16px; border-radius:8px; border:1px solid #cbd5e1; background:#fff; color:#475569; text-decoration:none;">Cancelar</a>
            <button type="submit" style="padding:10px 18px; border-radius:8px; background:linear-gradient(135deg,#0e7490 0%,#0d5f7a 100%); color:#fff; border:none; font-weight:700;">Pagar S/ {{ number_format($reserva->precio_publicado,2) }}</button>
          </div>
        </form>
      </div>

      <aside style="background:#fff; padding:18px; border-radius:12px; box-shadow:0 8px 24px rgba(2,6,23,0.06);">
        <h3 style="margin-top:0; color:#0e7490;">Información</h3>
        <p style="color:#475569; font-size:0.95rem;">Al finalizar el pago, registraremos el comprobante y confirmaremos tu reserva. Conserva el comprobante de pago.</p>

        <div style="margin-top:12px;">
          <h4 style="margin:0 0 8px 0; color:#0f172a;">Contacto</h4>
          <p style="color:#475569; margin:0;">Soporte: +51 9XXXXXXXX</p>
          <p style="color:#475569; margin:0;">Email: reservas@exploretumbes.pe</p>
        </div>
      </aside>
    </div>
  </div>
</div>
@endsection
