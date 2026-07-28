<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaqueteController extends Controller
{
    public function index()
    {
        $paquetes = Paquete::all();

        return view('paquetes', compact('paquetes'));
    }

    public function editJson($id)
    {
        return response()->json(Paquete::findOrFail($id));
    }

    public function edit($id)
    {
        $paquete = Paquete::findOrFail($id);

        return view('paquetes_edit', compact('paquete'));
    }

    public function update(Request $request, $id)
    {
        $paquete = Paquete::findOrFail($id);

        $validated = $request->validate([
            'nombre_paquete' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|max:4096',
        ]);

        $paquete->nombre_paquete = $validated['nombre_paquete'];
        $paquete->descripcion = $validated['descripcion'] ?? $paquete->descripcion;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $path = $file->store('paquetes', 'public');
            $paquete->imagen_url = asset('storage/' . $path);
        }

        $paquete->save();

        return redirect()->route('paquetes')->with('success', 'Paquete actualizado correctamente.');
    }
}

