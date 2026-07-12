<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->query('filtro', 'todas');
        $busqueda = $request->query('busqueda', '');

        // Obtener todas las reservas con sus relaciones
        $query = Reserva::with(['cliente', 'detalles.tour'])
            ->orderBy('fecha_reserva', 'desc');

        // Aplicar filtro por estado
        if ($filtro === 'pagadas') {
            $query->where('estado', 'C');
        } elseif ($filtro === 'pendientes') {
            $query->where('estado', 'P');
        } elseif ($filtro === 'canceladas') {
            $query->where('estado', 'X');
        }

        // Aplicar búsqueda
        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('id_reserva', 'like', "%$busqueda%")
                  ->orWhereHas('cliente', function ($subQ) use ($busqueda) {
                      $subQ->where('nombre', 'like', "%$busqueda%")
                           ->orWhere('apellidos', 'like', "%$busqueda%")
                           ->orWhere('correo', 'like', "%$busqueda%");
                  })
                  ->orWhereHas('detalles.tour', function ($subQ) use ($busqueda) {
                      $subQ->where('nombre_tour', 'like', "%$busqueda%");
                  });
            });
        }

        $reservas = $query->paginate(10);

        // Calcular métricas
        $totalReservas = Reserva::count();
        $reservasPagadas = Reserva::where('estado', 'C')->sum(DB::raw('precio_publicado'));
        $reservasPendientes = Reserva::where('estado', 'P')->count();
        $reservasCanceladas = Reserva::where('estado', 'X')->count();

        // Contar por estado (número de reservas)
        $countPagadas = Reserva::where('estado', 'C')->count();
        $countCanceladas = Reserva::where('estado', 'X')->count();

        return view('reservas', [
            'reservas' => $reservas,
            'totalReservas' => $totalReservas,
            'reservasPagadas' => $reservasPagadas,
            'reservasPendientes' => $reservasPendientes,
            'reservasCanceladas' => $reservasCanceladas,
            'countPagadas' => $countPagadas,
            'countCanceladas' => $countCanceladas,
            'countPendientes' => $reservasPendientes,
            'filtro' => $filtro,
            'busqueda' => $busqueda,
        ]);
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('reservas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'precio_publicado' => 'required|numeric',
            'estado' => 'required|in:C,P,X',
            'observaciones' => 'nullable|string',
        ]);

        Reserva::create($validated);
        return redirect()->route('reservas.index')->with('success', 'Reserva creada correctamente');
    }

    public function show($id)
    {
        $reserva = Reserva::with(['cliente', 'detalles.tour', 'comprobantes'])->findOrFail($id);
        return view('reservas.show', compact('reserva'));
    }

    public function edit($id)
    {
        $reserva = Reserva::findOrFail($id);
        return view('reservas.edit', compact('reserva'));
    }

    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update($request->validate([
            'precio_publicado' => 'required|numeric',
            'estado' => 'required|in:C,P,X',
            'observaciones' => 'nullable|string',
        ]));
        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente');
    }

    public function destroy($id)
    {
        Reserva::findOrFail($id)->delete();
        return redirect()->route('reservas.index')->with('success', 'Reserva eliminada correctamente');
    }
}

