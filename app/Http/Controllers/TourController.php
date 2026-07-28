<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Destino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->query('busqueda', '');

        $query = Tour::with(['destino', 'categoria'])
            ->orderBy('id_tour');

        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre_tour', 'like', "%$busqueda%")
                  ->orWhereHas('destino', fn($s) => $s->where('nombre', 'like', "%$busqueda%"));
            });
        }

        $tours    = $query->get();
        $destinos = Destino::orderBy('nombre')->get();
        $categorias = DB::table('categoriatour')->orderBy('descripcion')->get();

        return view('tours', compact('tours', 'destinos', 'categorias', 'busqueda'));
    }

    public function create()
    {
        $destinos   = Destino::orderBy('nombre')->get();
        $categorias = DB::table('categoriatour')->orderBy('descripcion')->get();
        return view('tours_form', compact('destinos', 'categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_tour'    => 'required|string|max:150',
            'descripcion'    => 'required|string',
            'id_destino'     => 'required|exists:destino,id_destino',
            'id_catto'       => 'required|exists:categoriatour,id_catto',
            'precio'         => 'required|numeric|min:0',
            'duracion_dias'  => 'required|integer|min:1',
            'ubicacion_exacta' => 'required|string|max:150',
            'estado'         => 'required|in:activo,inactivo',
            'imagen'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'imagen_url'     => 'nullable|string|max:255',
        ]);

        $ultimo = Tour::orderByDesc('id_tour')->first();
        $data['id_tour'] = $ultimo ? str_pad((int)$ultimo->id_tour + 1, 7, '0', STR_PAD_LEFT) : '0000001';

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('tours', 'public');
            $data['imagen_url'] = asset('storage/' . $path);
        }

        unset($data['imagen']);
        Tour::create($data);

        return redirect()->route('tours')->with('success', 'Tour creado correctamente.');
    }

    public function editJson($id)
    {
        $tour = Tour::with(['destino', 'categoria'])->findOrFail($id);
        return response()->json($tour);
    }

    public function edit($id)
    {
        $tour       = Tour::findOrFail($id);
        $destinos   = Destino::orderBy('nombre')->get();
        $categorias = DB::table('categoriatour')->orderBy('descripcion')->get();
        return view('tours_form', compact('tour', 'destinos', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $tour = Tour::findOrFail($id);

        $data = $request->validate([
            'nombre_tour'    => 'required|string|max:150',
            'descripcion'    => 'required|string',
            'id_destino'     => 'required|exists:destino,id_destino',
            'id_catto'       => 'required|exists:categoriatour,id_catto',
            'precio'         => 'required|numeric|min:0',
            'duracion_dias'  => 'required|integer|min:1',
            'ubicacion_exacta' => 'required|string|max:150',
            'estado'         => 'required|in:activo,inactivo',
            'imagen'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'imagen_url'     => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('tours', 'public');
            $data['imagen_url'] = asset('storage/' . $path);
        }

        unset($data['imagen']);
        $tour->update($data);

        return redirect()->route('tours')->with('success', 'Tour actualizado correctamente.');
    }

    public function destroy($id)
    {
        Tour::findOrFail($id)->delete();
        return redirect()->route('tours')->with('success', 'Tour eliminado correctamente.');
    }
}
