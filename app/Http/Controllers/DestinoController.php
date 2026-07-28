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
            'nombre'          => 'required|string|max:18',
            'descripcion'     => 'required|string|max:18',
            'categoria'       => 'required|string|max:18',
            'temperatura_prom'=> 'nullable|string|max:18',
            'imagen'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'imagen_url'      => 'nullable|string|max:255',
        ]);

        $validated['id_destino'] = $this->generarIdDestino();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('destinos', 'public');
            $validated['imagen_url'] = asset('storage/' . $path);
        }

        unset($validated['imagen']);
        Destino::create($validated);

        return redirect()->route('destinos')->with('success', 'Destino creado correctamente.');
    }

    public function edit($id)
    {
        $destino = Destino::findOrFail($id);
        return response()->json($destino);
    }

    public function update(Request $request, $id)
    {
        $destino = Destino::findOrFail($id);

        $validated = $request->validate([
            'nombre'           => 'required|string|max:18',
            'descripcion'      => 'required|string|max:18',
            'categoria'        => 'required|string|max:18',
            'temperatura_prom' => 'nullable|string|max:18',
            'imagen'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('destinos', 'public');
            $validated['imagen_url'] = asset('storage/' . $path);
        }

        unset($validated['imagen']);
        $destino->update($validated);

        return redirect()->route('destinos')->with('success', 'Destino actualizado correctamente.');
    }

    public function destroy($id)
    {
        $destino = Destino::findOrFail($id);
        $destino->delete();
        return redirect()->route('destinos')->with('success', 'Destino eliminado correctamente.');
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
