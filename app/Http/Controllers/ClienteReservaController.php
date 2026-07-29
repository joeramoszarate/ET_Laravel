<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Paquete;
use App\Models\Reserva;
use App\Models\DetalleReservaTour;
use App\Models\Cliente;
use App\Models\TipoDocumento;
use App\Models\TipoRol;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ClienteReservaController extends Controller
{
    protected function resolveUsuarioReservaId(): string
    {
        $usuario = Usuario::query()->first();

        if ($usuario) {
            return $usuario->id_usuario;
        }

        $tipoRol = TipoRol::query()->first();
        if (! $tipoRol) {
            $tipoRol = TipoRol::create([
                'id_tiprol' => 'TR001',
                'descripcion' => 'Cliente',
            ]);
        }

        $tipoDocumento = TipoDocumento::query()->first();
        if (! $tipoDocumento) {
            $tipoDocumento = TipoDocumento::create([
                'id_tipdoc' => 'TD001',
                'descripcion' => 'DNI',
            ]);
        }

        $usuario = Usuario::create([
            'id_tiprol' => $tipoRol->id_tiprol,
            'id_usuario' => 'U' . str_pad((string) random_int(1, 999999), 17, '0', STR_PAD_LEFT),
            'nombre' => 'Sistema',
            'correo' => 'sistema@reserva.local',
            'contraseña' => '123456',
            'telefono' => '000000000',
            'direccion' => 'N/A',
            'apellidos' => 'Reserva',
            'id_tipdoc' => $tipoDocumento->id_tipdoc,
            'nro_documento' => '00000000',
            'fecha_registro' => now()->format('YmdHis'),
            'estado' => 'A',
        ]);

        return $usuario->id_usuario;
    }

    public function showTourReserva($id_tour)
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login')->with('info', 'Debes iniciar sesión para hacer una reserva.');
        }

        $tour = Tour::with('destino', 'categoria')->findOrFail($id_tour);
        $cliente = Cliente::findOrFail(Session::get('cliente_id'));

        return view('cliente.reserva_tour_Clie', compact('tour', 'cliente'));
    }

    public function storeTourReserva(Request $request, $id_tour)
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login');
        }

        $tour = Tour::findOrFail($id_tour);
        $cliente = Cliente::findOrFail(Session::get('cliente_id'));

        $request->validate([
            'adultos' => 'required|integer|min:1',
            'ninos' => 'required|integer|min:0',
            'descuentos_noche' => 'nullable|numeric|min:0',
            'tipo_recepcion' => 'required|string',
            'canal' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'hora_llegada' => 'required',
            'hora_salida' => 'required',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $total_personas = $request->adultos + $request->ninos;
        $precio_unitario = $tour->precio;
        $precio_total = $precio_unitario * $total_personas;

        if ($request->descuentos_noche) {
            $precio_total -= $request->descuentos_noche;
        }

        $observaciones = trim((string) $request->observaciones);
        $extras = [];

        if ($request->filled('tipo_habitacion')) {
            $extras[] = 'Tipo habitación: ' . $request->tipo_habitacion;
        }

        if ($request->filled('tipo_recepcion')) {
            $extras[] = 'Recepción: ' . $request->tipo_recepcion;
        }

        if ($request->filled('canal')) {
            $extras[] = 'Canal: ' . $request->canal;
        }

        if ($request->filled('hora_llegada')) {
            $extras[] = 'Llegada: ' . $request->hora_llegada;
        }

        if ($request->filled('hora_salida')) {
            $extras[] = 'Salida: ' . $request->hora_salida;
        }

        if (!empty($extras)) {
            $observaciones = $observaciones ? $observaciones . ' | ' . implode(' | ', $extras) : implode(' | ', $extras);
        }

        // Crear reserva
        $reserva = new Reserva();
        $reserva->id_reserva = strtoupper(substr(uniqid('R'), 0, 7));
        $reserva->id_cliente = $cliente->id_cliente;
        $reserva->id_usuario = $this->resolveUsuarioReservaId();
        $reserva->precio_publicado = $precio_total;
        $reserva->estado = 'P';
        $reserva->fecha_reserva = now();
        $reserva->observaciones = $observaciones;
        $reserva->save();

        // Crear detalle de reserva para el tour
        $detalle = new DetalleReservaTour();
        $detalle->id_numreto = strtoupper(substr(uniqid('D'), 0, 7));
        $detalle->id_reserva = $reserva->id_reserva;
        $detalle->id_tour = $tour->id_tour;
        $detalle->cantidad_persona = $total_personas;
        $detalle->precio_unitario = $precio_unitario;
        $detalle->save();

        return redirect()->route('cliente.inicio')->with('success', 'Tu reserva ha sido registrada correctamente. Nos pondremos en contacto pronto.');
    }

    public function showPaqueteReserva($id_paquete)
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login')->with('info', 'Debes iniciar sesión para hacer una reserva.');
        }

        $paquete = Paquete::findOrFail($id_paquete);
        $cliente = Cliente::findOrFail(Session::get('cliente_id'));

        return view('cliente.reserva_paquete_Clie', compact('paquete', 'cliente'));
    }

    public function storePaqueteReserva(Request $request, $id_paquete)
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login');
        }

        $paquete = Paquete::findOrFail($id_paquete);
        $cliente = Cliente::findOrFail(Session::get('cliente_id'));

        $request->validate([
            'adultos' => 'required|integer|min:1',
            'ninos' => 'required|integer|min:0',
            'precio_total' => 'required|numeric|min:0',
            'tipo_recepcion' => 'required|string',
            'canal' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'hora_llegada' => 'required',
            'hora_salida' => 'required',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Crear reserva
        $reserva = new Reserva();
        $reserva->id_reserva = strtoupper(substr(uniqid('R'), 0, 7));
        $reserva->id_cliente = $cliente->id_cliente;
        $reserva->id_usuario = $this->resolveUsuarioReservaId();
        $reserva->precio_publicado = $request->precio_total;
        $reserva->estado = 'P';
        $reserva->fecha_reserva = now();
        $reserva->observaciones = $request->observaciones;
        $reserva->save();

        return redirect()->route('cliente.inicio')->with('success', 'Tu reserva de paquete ha sido registrada. Nos contactaremos pronto.');
    }

    public function showPago($id_reserva)
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login')->with('info', 'Debes iniciar sesión para realizar el pago.');
        }

        $reserva = Reserva::with('cliente')->findOrFail($id_reserva);
        // obtener detalles del tour si existen
        $detalle = DetalleReservaTour::where('id_reserva', $reserva->id_reserva)->with('tour')->first();

        $metodos = DB::table('metodopago')->where('estado', 'A')->get();

        return view('cliente.pago_reserva_Clie', compact('reserva', 'detalle', 'metodos'));
    }

    public function storePago(Request $request, $id_reserva)
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login');
        }

        $request->validate([
            'id_metpago' => 'required|string',
            'monto' => 'required|numeric|min:0'
        ]);

        $reserva = Reserva::findOrFail($id_reserva);

        // insertar comprobante en tabla comprobantepago
        $id_compag = strtoupper(substr(uniqid('CP'), 0, 8));
        DB::table('comprobantepago')->insert([
            'id_compag' => $id_compag,
            'id_reserva' => $reserva->id_reserva,
            'id_metpago' => $request->id_metpago,
            'monto_facturado' => $request->monto,
            'fecha_emision' => now(),
            'descripcion' => $request->descripcion ?? 'Pago desde cliente',
        ]);

        // actualizar estado de reserva a confirmado
        $reserva->estado = 'C';
        $reserva->save();

        return redirect()->route('cliente.inicio')->with('success', 'Pago registrado correctamente. Gracias.');
    }
}
