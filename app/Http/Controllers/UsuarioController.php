<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\TipoRol;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        return $this->buildView($request, 'usuario');
    }

    public function vistaGestion(Request $request)
    {
        return $this->buildView($request, 'usuarios_vista');
    }

    public function editJson($id)
    {
        return response()->json(Usuario::with('rol')->findOrFail($id));
    }

    private function buildView(Request $request, string $viewName)
    {
        $busqueda = $request->query('busqueda', '');
        $filtroRol = $request->query('rol', 'todos');

        $query = Usuario::with('rol')->orderBy('nombre');

        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%$busqueda%")
                  ->orWhere('apellidos', 'like', "%$busqueda%")
                  ->orWhere('correo', 'like', "%$busqueda%");
            });
        }

        if ($filtroRol !== 'todos') {
            $query->whereHas('rol', fn($q) => $q->where('descripcion', 'like', "%$filtroRol%"));
        }

        $usuarios = $query->get();
        $roles    = TipoRol::orderBy('descripcion')->get();

        // Métricas
        $total         = Usuario::count();
        $totalActivos  = Usuario::where('estado', 'activo')->count();
        $countClientes = Usuario::whereHas('rol', fn($q) => $q->where('descripcion', 'like', '%cliente%'))->count();
        $countGuias    = Usuario::whereHas('rol', fn($q) => $q->where('descripcion', 'like', '%guia%')
                                                              ->orWhere('descripcion', 'like', '%guía%'))->count();
        $countAdmins   = Usuario::whereHas('rol', fn($q) => $q->where('descripcion', 'like', '%admin%'))->count();

        // Actividad: reservas por usuario
        $actividad = DB::table('reserva')
            ->select('id_usuario', DB::raw('COUNT(*) as total_reservas'), DB::raw('SUM(precio_publicado) as total_monto'))
            ->groupBy('id_usuario')
            ->get()
            ->keyBy('id_usuario');

        return view($viewName, compact(
            'usuarios', 'roles', 'busqueda', 'filtroRol',
            'total', 'totalActivos', 'countClientes', 'countGuias', 'countAdmins',
            'actividad'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:18',
            'apellidos'    => 'nullable|string|max:18',
            'correo'       => 'required|string|max:18',
            'telefono'     => 'nullable|string|max:18',
            'direccion'    => 'nullable|string|max:18',
            'id_tiprol'    => 'required|exists:tiporol,id_tiprol',
            'id_tipdoc'    => 'required|exists:tipodocumento,id_tipdoc',
            'nro_documento'=> 'nullable|string|max:18',
            'contraseña'   => 'required|string|max:18',
            'estado'       => 'required|string|max:18',
        ]);

        $ultimo = Usuario::orderByDesc('id_usuario')->first();
        $data['id_usuario']      = $ultimo ? str_pad((int)$ultimo->id_usuario + 1, 18, '0', STR_PAD_LEFT) : str_pad(1, 18, '0', STR_PAD_LEFT);
        $data['fecha_registro']  = now()->format('d/m/Y');

        Usuario::create($data);
        return redirect()->route('usuarios')->with('success', 'Usuario creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'nombre'       => 'required|string|max:18',
            'apellidos'    => 'nullable|string|max:18',
            'correo'       => 'required|string|max:18',
            'telefono'     => 'nullable|string|max:18',
            'direccion'    => 'nullable|string|max:18',
            'id_tiprol'    => 'required|exists:tiporol,id_tiprol',
            'estado'       => 'required|string|max:18',
        ]);

        $usuario->update($data);
        return redirect()->route('usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        Usuario::findOrFail($id)->delete();
        return redirect()->route('usuarios')->with('success', 'Usuario eliminado correctamente.');
    }
}
