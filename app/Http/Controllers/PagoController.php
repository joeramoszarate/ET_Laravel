<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PagoController extends Controller
{
    public function index()
    {
        // Total cobrado (pagos completados)
        $totalCobrado = DB::table('comprobantepago')
            ->sum('monto_facturado');

        // Por cobrar (reservas pendientes sin comprobante)
        $porCobrar = DB::table('reserva')
            ->where('estado', 'P')
            ->sum('precio_publicado');

        // Fallidos/Anulados (reservas canceladas)
        $fallidos = DB::table('reserva')
            ->where('estado', 'X')
            ->sum('precio_publicado');

        // Tasa de éxito
        $totalReservas = DB::table('reserva')->count();
        $reservasConfirmadas = DB::table('reserva')->where('estado', 'C')->count();
        $tasaExito = $totalReservas > 0 ? ($reservasConfirmadas / $totalReservas) * 100 : 0;

        // Contar por estado
        $countPendientes = DB::table('reserva')->where('estado', 'P')->count();
        $countFallidos = DB::table('reserva')->where('estado', 'X')->count();

        // Ingresos por mes (últimos 6 meses)
        $ingresosMensuales = DB::table('comprobantepago')
            ->selectRaw('MONTH(fecha_emision) as mes, YEAR(fecha_emision) as año, SUM(monto_facturado) as total')
            ->where('fecha_emision', '>=', Carbon::now()->subMonths(6))
            ->groupByRaw('YEAR(fecha_emision), MONTH(fecha_emision)')
            ->orderByRaw('YEAR(fecha_emision), MONTH(fecha_emision)')
            ->get();

        // Procesar datos de meses
        $meses = [];
        $ingresosData = [];
        foreach ($ingresosMensuales as $ingreso) {
            $fecha = Carbon::createFromDate($ingreso->año, $ingreso->mes, 1);
            $meses[] = $fecha->format('M');
            $ingresosData[] = $ingreso->total;
        }

        // Métodos de pago (resumen)
        $metodosPago = DB::table('comprobantepago')
            ->join('metodopago', 'comprobantepago.id_metpago', '=', 'metodopago.id_metpago')
            ->selectRaw('metodopago.descripcion, COUNT(*) as cantidad, SUM(comprobantepago.monto_facturado) as total')
            ->groupBy('metodopago.id_metpago', 'metodopago.descripcion')
            ->get();

        // Calcular totales para métodos de pago
        $totalMetodos = $metodosPago->sum('total');

        // Historial de transacciones completo
        $pagos = DB::table('comprobantepago')
            ->join('reserva', 'comprobantepago.id_reserva', '=', 'reserva.id_reserva')
            ->join('cliente', 'reserva.id_cliente', '=', 'cliente.id_cliente')
            ->join('metodopago', 'comprobantepago.id_metpago', '=', 'metodopago.id_metpago')
            ->leftJoin('detallereservatour', 'reserva.id_reserva', '=', 'detallereservatour.id_reserva')
            ->leftJoin('tour', 'detallereservatour.id_tour', '=', 'tour.id_tour')
            ->selectRaw('
                comprobantepago.id_compag,
                cliente.nombre,
                tour.nombre_tour,
                metodopago.descripcion as metodo,
                comprobantepago.monto_facturado,
                comprobantepago.fecha_emision,
                reserva.estado
            ')
            ->orderBy('comprobantepago.fecha_emision', 'desc')
            ->paginate(10);

        // Mapear estados
        $estadosMap = [
            'C' => 'Completado',
            'P' => 'Pendiente',
            'X' => 'Fallido'
        ];

        return view('pagos', [
            'totalCobrado' => round($totalCobrado, 2),
            'porCobrar' => round($porCobrar, 2),
            'fallidos' => round($fallidos, 2),
            'tasaExito' => round($tasaExito, 0),
            'meses' => $meses,
            'ingresosData' => $ingresosData,
            'metodosPago' => $metodosPago,
            'totalMetodos' => $totalMetodos,
            'pagos' => $pagos,
            'estadosMap' => $estadosMap,
            'countPendientes' => $countPendientes,
            'countFallidos' => $countFallidos
        ]);
    }
}

