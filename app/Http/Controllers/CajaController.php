<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CajaMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CajaController extends Controller
{
    public function index()
    {
        $cajaHoy = Caja::whereDate('fecha_apertura', today())
            ->orderByDesc('hora_apertura')->first();

        $movimientos   = $cajaHoy ? $cajaHoy->movimientos()->orderBy('hora')->get() : collect();
        $totalIngresos = $movimientos->where('tipo', 'ingreso')->sum('monto');
        $totalEgresos  = $movimientos->where('tipo', 'egreso')->sum('monto');
        $countIngresos = $movimientos->where('tipo', 'ingreso')->count();
        $countEgresos  = $movimientos->where('tipo', 'egreso')->count();
        $promedio      = $countIngresos > 0 ? $totalIngresos / $countIngresos : 0;
        $saldo         = $cajaHoy ? ($cajaHoy->fondo_inicial + $totalIngresos - $totalEgresos) : 0;

        // Tendencia semanal (últimos 7 días)
        $tendencia = [];
        for ($i = 6; $i >= 0; $i--) {
            $dia   = Carbon::today()->subDays($i);
            $label = $i === 0 ? 'Hoy' : $dia->locale('es')->isoFormat('ddd');
            $cajas = Caja::whereDate('fecha_apertura', $dia)->pluck('id_caja');
            $ing   = CajaMovimiento::whereIn('id_caja', $cajas)->where('tipo', 'ingreso')->sum('monto');
            $egr   = CajaMovimiento::whereIn('id_caja', $cajas)->where('tipo', 'egreso')->sum('monto');
            $tendencia[] = ['label' => ucfirst($label), 'ingresos' => (float)$ing, 'egresos' => (float)$egr];
        }

        return view('caja', compact(
            'cajaHoy', 'movimientos', 'totalIngresos', 'totalEgresos',
            'countIngresos', 'countEgresos', 'promedio', 'saldo', 'tendencia'
        ));
    }

    public function abrir(Request $request)
    {
        $cajaAbierta = Caja::whereDate('fecha_apertura', today())
            ->where('estado', 'abierta')->first();

        if ($cajaAbierta) {
            return back()->with('error', 'Ya hay una caja abierta hoy.');
        }

        $request->validate(['fondo_inicial' => 'required|numeric|min:0']);

        $ultimo   = Caja::orderByDesc('id_caja')->first();
        $nuevoId  = $ultimo ? str_pad((int)$ultimo->id_caja + 1, 7, '0', STR_PAD_LEFT) : '0000001';
        $ahora    = now();

        $caja = Caja::create([
            'id_caja'       => $nuevoId,
            'fecha_apertura'=> today(),
            'hora_apertura' => $ahora,
            'fondo_inicial' => $request->fondo_inicial,
            'estado'        => 'abierta',
            'id_usuario'    => auth()->id() ?? 'admin',
        ]);

        // Movimiento de apertura
        $this->registrarMovimiento($caja, [
            'concepto'    => 'Apertura de caja',
            'metodo_pago' => 'Efectivo',
            'tipo'        => 'ingreso',
            'monto'       => $request->fondo_inicial,
        ]);

        return back()->with('success', 'Caja abierta correctamente.');
    }

    public function cerrar()
    {
        $caja = Caja::whereDate('fecha_apertura', today())
            ->where('estado', 'abierta')->first();

        if (!$caja) {
            return back()->with('error', 'No hay caja abierta.');
        }

        $movimientos   = $caja->movimientos;
        $totalIngresos = $movimientos->where('tipo', 'ingreso')->sum('monto');
        $totalEgresos  = $movimientos->where('tipo', 'egreso')->sum('monto');

        $caja->update([
            'estado'      => 'cerrada',
            'hora_cierre' => now(),
            'saldo_final' => $caja->fondo_inicial + $totalIngresos - $totalEgresos,
        ]);

        return back()->with('success', 'Caja cerrada. Saldo final: S/ ' . number_format($caja->saldo_final, 2));
    }

    public function movimiento(Request $request)
    {
        $caja = Caja::whereDate('fecha_apertura', today())
            ->where('estado', 'abierta')->first();

        if (!$caja) {
            return back()->with('error', 'No hay caja abierta. Abre la caja primero.');
        }

        $request->validate([
            'concepto'    => 'required|string|max:200',
            'metodo_pago' => 'required|string|max:30',
            'tipo'        => 'required|in:ingreso,egreso',
            'monto'       => 'required|numeric|min:0.01',
        ]);

        $this->registrarMovimiento($caja, $request->only('concepto', 'metodo_pago', 'tipo', 'monto'));

        return back()->with('success', ucfirst($request->tipo) . ' registrado correctamente.');
    }

    private function registrarMovimiento(Caja $caja, array $data)
    {
        $movimientos   = $caja->movimientos()->orderBy('hora')->get();
        $totalIngresos = $movimientos->where('tipo', 'ingreso')->sum('monto');
        $totalEgresos  = $movimientos->where('tipo', 'egreso')->sum('monto');
        $saldoActual   = $caja->fondo_inicial + $totalIngresos - $totalEgresos;

        $nuevoSaldo = $data['tipo'] === 'ingreso'
            ? $saldoActual + $data['monto']
            : $saldoActual - $data['monto'];

        $ultimo  = CajaMovimiento::orderByDesc('id_movimiento')->first();
        $nuevoId = $ultimo ? 'MOV-' . str_pad((int)substr($ultimo->id_movimiento, -3) + 1, 3, '0', STR_PAD_LEFT) : 'MOV-001';

        // Evitar duplicados de ID
        while (CajaMovimiento::find($nuevoId)) {
            $num     = (int)substr($nuevoId, -3) + 1;
            $nuevoId = 'MOV-' . str_pad($num, 3, '0', STR_PAD_LEFT);
        }

        CajaMovimiento::create([
            'id_movimiento'   => $nuevoId,
            'id_caja'         => $caja->id_caja,
            'hora'            => now()->format('H:i'),
            'concepto'        => $data['concepto'],
            'metodo_pago'     => $data['metodo_pago'],
            'tipo'            => $data['tipo'],
            'monto'           => $data['monto'],
            'saldo_acumulado' => $nuevoSaldo,
        ]);
    }
}
