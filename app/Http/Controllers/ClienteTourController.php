<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\CategoriaTour;
use Illuminate\Http\Request;

class ClienteTourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::with(['destino', 'categoria'])->where('estado', 'activo');

        // Filtro precio
        $precioMax = $request->get('precio_max', 500);
        $query->where('precio', '<=', $precioMax);

        // Filtro duración
        if ($request->filled('duracion')) {
            $query->whereIn('duracion_dias', $request->duracion);
        }

        // Filtro categoría
        if ($request->filled('categorias')) {
            $query->whereIn('id_catto', $request->categorias);
        }

        // Ordenar
        $orden = $request->get('orden', 'popular');
        match ($orden) {
            'precio_asc'  => $query->orderBy('precio', 'asc'),
            'precio_desc' => $query->orderBy('precio', 'desc'),
            'duracion'    => $query->orderBy('duracion_dias', 'asc'),
            default       => $query->orderBy('nombre_tour', 'asc'),
        };

        $tours      = $query->get();
        $categorias = CategoriaTour::orderBy('descripcion')->get();
        $total      = $tours->count();

        return view('cliente.tours_Clie', compact('tours', 'categorias', 'total', 'precioMax', 'orden'));
    }
}
