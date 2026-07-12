<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cliente;
use App\Models\Tour;
use App\Models\ComprobantePago;
use App\Models\DetalleReservaTour;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de Ventas (suma de comprobantes pagados del último mes)
        $totalVentas = ComprobantePago::whereMonth('fecha_emision', Carbon::now()->month)
            ->whereYear('fecha_emision', Carbon::now()->year)
            ->sum('monto_facturado');

        // Reservas Activas (en proceso o confirmadas)
        $reservasActivas = Reserva::whereIn('estado', ['P', 'C'])
            ->whereMonth('fecha_reserva', Carbon::now()->month)
            ->whereYear('fecha_reserva', Carbon::now()->year)
            ->count();

        // Nuevos Usuarios (total de clientes)
        $nuevosUsuarios = Cliente::count();

        // Tour más vendido
        $tourMasVendido = DetalleReservaTour::select('id_tour', DB::raw('COUNT(*) as total'))
            ->groupBy('id_tour')
            ->orderByDesc('total')
            ->with('tour')
            ->first();

        // Tendencia de ventas últimos 5 meses
        $tendenciaVentas = $this->getTendenciaVentas();

        // Reservas recientes
        $reservasRecientes = Reserva::with(['cliente', 'detalles.tour'])
            ->latest('fecha_reserva')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalVentas' => $totalVentas,
            'reservasActivas' => $reservasActivas,
            'nuevosUsuarios' => $nuevosUsuarios,
            'tourMasVendido' => $tourMasVendido,
            'tendenciaVentas' => $tendenciaVentas,
            'reservasRecientes' => $reservasRecientes,
        ]);
    }

    private function getTendenciaVentas()
    {
        $meses = [];
        $datos = [];

        for ($i = 4; $i >= 0; $i--) {
            $fecha = Carbon::now()->subMonths($i);
            $mes = $fecha->format('M');
            $meses[] = $mes;

            $monto = ComprobantePago::whereMonth('fecha_emision', $fecha->month)
                ->whereYear('fecha_emision', $fecha->year)
                ->sum('monto_facturado');

            $datos[] = (float) $monto;
        }

        return [
            'meses' => $meses,
            'datos' => $datos,
        ];
    }
}
