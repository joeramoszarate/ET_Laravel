<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use Illuminate\Http\Request;

class DestinoController extends Controller
{
    public function index()
    {
        $destinos = Destino::all();

        return view('destinos', compact('destinos'));
    }

    public function create()
    {
        $destinos = Destino::all();

        return view('destinos_form', compact('destinos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:18',
            'descripcion' => 'required|string|max:18',
            'categoria' => 'required|string|max:18',
            'temperatura_prom' => 'nullable|string|max:18',
            'imagen_url' => 'required|string|max:255',
        ]);

        $validated['id_destino'] = $this->generarIdDestino();

        Destino::create($validated);

        return redirect()->route('destinos')->with('success', 'Destino creado correctamente.');
    }

    private function generarIdDestino()
    {
        $ultimoDestino = Destino::orderByDesc('id_destino')->first();

        if (!$ultimoDestino) {
            return str_pad(1, 7, '0', STR_PAD_LEFT);
        }

        $numeroActual = (int) $ultimoDestino->id_destino;
        $numeroNuevo = $numeroActual + 1;

        return str_pad($numeroNuevo, 7, '0', STR_PAD_LEFT);
    }
}
