<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Tour;
use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        $mes  = (int) $request->get('mes',  now()->month);
        $anio = (int) $request->get('anio', now()->year);

        // Validar rango
        $mes  = max(1, min(12, $mes));
        $anio = max(2020, min(2099, $anio));

        $inicioPeriodo = Carbon::create($anio, $mes, 1)->startOfMonth();
        $finPeriodo    = Carbon::create($anio, $mes, 1)->endOfMonth();

        // Filtros
        $filtroEstado   = $request->get('estado', 'todos');
        $filtroPaquete  = $request->get('paquete', 'todos');
        $busqueda       = $request->get('busqueda', '');

        // Días del mes como array de Carbon
        $dias = [];
        $cursor = $inicioPeriodo->copy();
        while ($cursor->lte($finPeriodo)) {
            $dias[] = $cursor->copy();
            $cursor->addDay();
        }

        // Query principal: reserva → detalle → tour → paquete + cliente
        $query = DB::table('reserva as r')
            ->join('detallereservatour as d', 'r.id_reserva', '=', 'd.id_reserva')
            ->join('tour as t', 'd.id_tour', '=', 't.id_tour')
            ->join('paquetes as p', 't.id_destino', '=', 'p.id_paquete') // usamos destino como agrupador visual
            ->join('cliente as c', 'r.id_cliente', '=', 'c.id_cliente')
            ->select(
                'r.id_reserva',
                'r.estado',
                'r.precio_publicado',
                'r.observaciones',
                'r.fecha_reserva',
                'c.nombre as cliente_nombre',
                'c.apellidos as cliente_apellidos',
                'c.telefono as cliente_telefono',
                'c.correo as cliente_correo',
                'd.cantidad_persona',
                'd.precio_unitario',
                'd.id_tour',
                't.nombre_tour',
                't.duracion_dias',
                't.precio as tour_precio',
                't.estado as tour_estado',
                'p.nombre_paquete',
                'p.id_paquete'
            )
            ->where('r.estado', '!=', 'C') // C = cancelada en tu sistema
            ->whereNotNull('r.fecha_reserva');

        // Filtro estado
        if ($filtroEstado !== 'todos') {
            $query->where('r.estado', $filtroEstado);
        }

        // Filtro paquete
        if ($filtroPaquete !== 'todos') {
            $query->where('p.id_paquete', $filtroPaquete);
        }

        // Búsqueda cliente
        if ($busqueda !== '') {
            $query->where(function ($q) use ($busqueda) {
                $q->where('c.nombre', 'like', "%$busqueda%")
                  ->orWhere('c.apellidos', 'like', "%$busqueda%");
            });
        }

        $reservasRaw = $query->orderBy('r.fecha_reserva')->get();

        // Construir filas del calendario
        // Cada fila = una reserva con su rango de fechas calculado
        $filas = $reservasRaw->map(function ($r) use ($inicioPeriodo, $finPeriodo) {
            $fechaInicio = Carbon::parse($r->fecha_reserva);
            $fechaFin    = $fechaInicio->copy()->addDays(max(0, (int)$r->duracion_dias - 1));

            // Recortar al mes visible
            $inicio = $fechaInicio->lt($inicioPeriodo) ? $inicioPeriodo->copy() : $fechaInicio->copy();
            $fin    = $fechaFin->gt($finPeriodo)       ? $finPeriodo->copy()    : $fechaFin->copy();

            // Columna de inicio (0-based) dentro del mes
            $colInicio = $inicio->day - 1;
            $colSpan   = max(1, $inicio->diffInDays($fin) + 1);

            $colorClass = match(strtoupper($r->estado)) {
                'C'  => 'bar-cancelada',
                'P'  => 'bar-pendiente',
                'CO' => 'bar-confirmada',
                default => 'bar-pendiente',
            };

            return [
                'id_reserva'       => $r->id_reserva,
                'estado'           => $r->estado,
                'color_class'      => $colorClass,
                'cliente_nombre'   => trim($r->cliente_nombre . ' ' . $r->cliente_apellidos),
                'cliente_telefono' => $r->cliente_telefono,
                'cliente_correo'   => $r->cliente_correo,
                'cantidad_persona' => $r->cantidad_persona,
                'precio_publicado' => $r->precio_publicado,
                'precio_unitario'  => $r->precio_unitario,
                'tour_precio'      => $r->tour_precio,
                'nombre_tour'      => $r->nombre_tour,
                'nombre_paquete'   => $r->nombre_paquete,
                'id_paquete'       => $r->id_paquete,
                'duracion_dias'    => $r->duracion_dias,
                'observaciones'    => $r->observaciones,
                'fecha_reserva'    => $fechaInicio->format('d/m/Y'),
                'fecha_fin'        => $fechaFin->format('d/m/Y'),
                'col_inicio'       => $colInicio,
                'col_span'         => $colSpan,
                'tiene_notas'      => !empty($r->observaciones),
            ];
        });

        // Agrupar por paquete para las filas separadoras
        $filasPorPaquete = $filas->groupBy('id_paquete');

        // Lista de paquetes para filtro
        $paquetes = Paquete::orderBy('nombre_paquete')->get();

        // Ocupación por día: reservas activas que caen en ese día
        $ocupacionPorDia = [];
        foreach ($dias as $dia) {
            $count = $reservasRaw->filter(function ($r) use ($dia) {
                $inicio = Carbon::parse($r->fecha_reserva);
                $fin    = $inicio->copy()->addDays(max(0, (int)$r->duracion_dias - 1));
                return $dia->between($inicio, $fin);
            })->count();
            $ocupacionPorDia[$dia->day] = $count;
        }

        $maxOcupacion = max(1, max($ocupacionPorDia ?: [1]));

        return view('admin.calendario', compact(
            'dias', 'filas', 'filasPorPaquete', 'paquetes',
            'mes', 'anio', 'inicioPeriodo',
            'filtroEstado', 'filtroPaquete', 'busqueda',
            'ocupacionPorDia', 'maxOcupacion'
        ));
    }

    public function detalle(Request $request, $idReserva)
    {
        $reserva = DB::table('reserva as r')
            ->join('detallereservatour as d', 'r.id_reserva', '=', 'd.id_reserva')
            ->join('tour as t', 'd.id_tour', '=', 't.id_tour')
            ->join('cliente as c', 'r.id_cliente', '=', 'c.id_cliente')
            ->leftJoin('paquetes as p', 't.id_destino', '=', 'p.id_paquete')
            ->select(
                'r.*',
                'c.nombre as cliente_nombre', 'c.apellidos as cliente_apellidos',
                'c.telefono', 'c.correo', 'c.nro_documento',
                'd.cantidad_persona', 'd.precio_unitario', 'd.id_tour',
                't.nombre_tour', 't.duracion_dias', 't.precio as tour_precio',
                'p.nombre_paquete'
            )
            ->where('r.id_reserva', $idReserva)
            ->first();

        if (!$reserva) {
            return response()->json(['error' => 'Reserva no encontrada'], 404);
        }

        return response()->json($reserva);
    }

    public function cancelar(Request $request, $idReserva)
    {
        DB::transaction(function () use ($idReserva) {
            Reserva::where('id_reserva', $idReserva)->update(['estado' => 'C']);
        });

        return response()->json(['ok' => true, 'mensaje' => 'Reserva cancelada correctamente.']);
    }
}
