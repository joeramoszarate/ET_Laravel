<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        // Ingresos del mes actual
        $ingresosMesActual = DB::table('comprobantepago')
            ->whereYear('fecha_emision', Carbon::now()->year)
            ->whereMonth('fecha_emision', Carbon::now()->month)
            ->sum('monto_facturado');

        // Ingresos del mes anterior para comparación
        $ingresosMesAnterior = DB::table('comprobantepago')
            ->whereYear('fecha_emision', Carbon::now()->subMonth()->year)
            ->whereMonth('fecha_emision', Carbon::now()->subMonth()->month)
            ->sum('monto_facturado');

        // Cálculo del porcentaje de incremento
        $porcentajeIncremento = $ingresosMesAnterior > 0 
            ? (($ingresosMesActual - $ingresosMesAnterior) / $ingresosMesAnterior) * 100
            : 0;

        // Ticket promedio (monto promedio por reserva)
        $ticketPromedio = DB::table('comprobantepago')
            ->avg('monto_facturado');

        // Tasa de conversión (reservas confirmadas vs total de reservas)
        $totalReservas = DB::table('reserva')->count();
        $reservasConfirmadas = DB::table('reserva')
            ->where('estado', 'C')
            ->count();
        
        $tasaConversion = $totalReservas > 0 
            ? ($reservasConfirmadas / $totalReservas) * 100
            : 0;

        // Evolución de ventas mensuales (últimos 5 meses)
        $ventasMensuales = DB::table('comprobantepago')
            ->selectRaw('MONTH(fecha_emision) as mes, YEAR(fecha_emision) as año, SUM(monto_facturado) as total')
            ->where('fecha_emision', '>=', Carbon::now()->subMonths(5))
            ->groupByRaw('YEAR(fecha_emision), MONTH(fecha_emision)')
            ->orderByRaw('YEAR(fecha_emision), MONTH(fecha_emision)')
            ->get();

        // Top 5 tours por ingresos
        $top5Tours = DB::table('tour')
            ->join('detallereservatour', 'tour.id_tour', '=', 'detallereservatour.id_tour')
            ->selectRaw('tour.nombre_tour, SUM(detallereservatour.cantidad_persona * detallereservatour.precio_unitario) as ingresos')
            ->groupBy('tour.id_tour', 'tour.nombre_tour')
            ->orderByRaw('ingresos DESC')
            ->limit(5)
            ->get();

        // Distribución por categoría
        $distribucionCategoria = DB::table('categoriatour')
            ->join('tour', 'categoriatour.id_catto', '=', 'tour.id_catto')
            ->join('detallereservatour', 'tour.id_tour', '=', 'detallereservatour.id_tour')
            ->selectRaw('categoriatour.descripcion, SUM(detallereservatour.cantidad_persona * detallereservatour.precio_unitario) as ingresos, COUNT(*) as cantidad')
            ->groupBy('categoriatour.id_catto', 'categoriatour.descripcion')
            ->get();

        // Procesamiento de datos para gráfico de evolución mensual
        $ventasProcessadas = [];
        $meses = [];
        $ventasData = [];
        
        foreach ($ventasMensuales as $venta) {
            $fecha = Carbon::createFromDate($venta->año, $venta->mes, 1);
            $meses[] = $fecha->format('M');
            $ventasData[] = $venta->total;
        }

        // Total de ingresos por categoría para el gráfico de pastel
        $totalIngresos = $distribucionCategoria->sum('ingresos');
        $categoriasProcessadas = $distribucionCategoria->map(function ($item) use ($totalIngresos) {
            return [
                'categoria' => $item->descripcion,
                'ingresos' => $item->ingresos,
                'porcentaje' => $totalIngresos > 0 ? ($item->ingresos / $totalIngresos) * 100 : 0
            ];
        });

        return view('reportes', [
            'ingresosMesActual' => round($ingresosMesActual, 2),
            'porcentajeIncremento' => round($porcentajeIncremento, 1),
            'ticketPromedio' => round($ticketPromedio, 2),
            'tasaConversion' => round($tasaConversion, 0),
            'meses' => $meses,
            'ventasData' => $ventasData,
            'top5Tours' => $top5Tours,
            'categoriasProcessadas' => $categoriasProcessadas
        ]);
    }
}

