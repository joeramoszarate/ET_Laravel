<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Reserva;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        // Total de clientes
        $totalClientes = Cliente::count();
        
        // Clientes activos (con al menos una reserva confirmada)
        $clientesActivos = Cliente::whereHas('reservas', function ($query) {
            $query->where('estado', 'C');
        })->count();

        // Ingresos totales (suma de todas las reservas)
        $ingresosTotal = Reserva::sum('precio_publicado');

        // Promedio por cliente
        $promedioPorCliente = $totalClientes > 0 ? $ingresosTotal / $totalClientes : 0;

        // Obtener lista de clientes con sus estadísticas
        $clientes = Cliente::with('reservas')
            ->select('cliente.*')
            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(*)')
                    ->from('reserva')
                    ->whereColumn('cliente.id_cliente', 'reserva.id_cliente');
            }, 'cantidad_reservas')
            ->selectSub(function ($query) {
                $query->selectRaw('COALESCE(SUM(precio_publicado), 0)')
                    ->from('reserva')
                    ->whereColumn('cliente.id_cliente', 'reserva.id_cliente');
            }, 'total_gastado')
            ->paginate(10);

        // Calcular estado basado en reservas
        foreach ($clientes as $cliente) {
            $tieneReservaConfirmada = $cliente->reservas->where('estado', 'C')->count() > 0;
            $cliente->estado = $tieneReservaConfirmada ? 'Activo' : 'Inactivo';
        }

        return view('clients', [
            'totalClientes' => $totalClientes,
            'clientesActivos' => $clientesActivos,
            'ingresosTotal' => $ingresosTotal,
            'promedioPorCliente' => $promedioPorCliente,
            'clientes' => $clientes,
            'busqueda' => '',
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $estado = $request->get('estado');

        $clientes = Cliente::with('reservas')
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%$query%")
                  ->orWhere('apellidos', 'LIKE', "%$query%")
                  ->orWhere('correo', 'LIKE', "%$query%")
                  ->orWhere('telefono', 'LIKE', "%$query%")
                  ->orWhere('id_cliente', 'LIKE', "%$query%");
            })
            ->select('cliente.*')
            ->selectSub(function ($q) {
                $q->selectRaw('COUNT(*)')
                    ->from('reserva')
                    ->whereColumn('cliente.id_cliente', 'reserva.id_cliente');
            }, 'cantidad_reservas')
            ->selectSub(function ($q) {
                $q->selectRaw('COALESCE(SUM(precio_publicado), 0)')
                    ->from('reserva')
                    ->whereColumn('cliente.id_cliente', 'reserva.id_cliente');
            }, 'total_gastado')
            ->paginate(10);

        foreach ($clientes as $cliente) {
            $tieneReservaConfirmada = $cliente->reservas->where('estado', 'C')->count() > 0;
            $cliente->estado = $tieneReservaConfirmada ? 'Activo' : 'Inactivo';
        }

        // Filtrar por estado si está especificado
        if ($estado && $estado !== 'Todos') {
            $clientes->getCollection()->transform(function ($item) use ($estado) {
                return ($item->estado === $estado) ? $item : null;
            })->filter();
        }

        return view('clients', [
            'totalClientes' => Cliente::count(),
            'clientesActivos' => Cliente::whereHas('reservas', function ($q) {
                $q->where('estado', 'C');
            })->count(),
            'ingresosTotal' => Reserva::sum('precio_publicado'),
            'promedioPorCliente' => Cliente::count() > 0 ? Reserva::sum('precio_publicado') / Cliente::count() : 0,
            'clientes' => $clientes,
            'busqueda' => $query,
            'estadoFiltro' => $estado,
        ]);
    }

    public function create()
    {
        $tiposDocumento = TipoDocumento::all();
        return view('client_form', compact('tiposDocumento'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'nro_documento' => 'required|string|max:18|unique:cliente,nro_documento',
            'correo' => 'required|email|max:100|unique:cliente,correo',
            'contraseña' => 'required|string|max:8',
            'id_tipdoc' => 'required|string|max:7',
            'telefono' => 'nullable|string|max:18',
            'nacionalidad' => 'nullable|string|max:18',
        ]);

        // Generar ID único automáticamente
        $validated['id_cliente'] = $this->generarIdCliente();

        Cliente::create($validated);

        return redirect()->route('clients')->with('success', 'Cliente creado exitosamente.');
    }

    public function edit(Cliente $cliente)
    {
        $tiposDocumento = TipoDocumento::all();
        return view('client_form', compact('cliente', 'tiposDocumento'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'nro_documento' => 'required|string|max:18|unique:cliente,nro_documento,' . $cliente->id_cliente . ',id_cliente',
            'correo' => 'required|email|max:100|unique:cliente,correo,' . $cliente->id_cliente . ',id_cliente',
            'contraseña' => 'nullable|string|max:8',
            'id_tipdoc' => 'required|string|max:7',
            'telefono' => 'nullable|string|max:18',
            'nacionalidad' => 'nullable|string|max:18',
        ]);

        // Si no proporciona contraseña, mantener la actual
        if (empty($validated['contraseña'])) {
            unset($validated['contraseña']);
        }

        $cliente->update($validated);

        return redirect()->route('clients')->with('success', 'Cliente actualizado exitosamente.');
    }

    private function generarIdCliente()
    {
        // Obtener el último cliente registrado ordenado por ID
        $ultimoCliente = Cliente::orderByDesc('id_cliente')->first();

        if (!$ultimoCliente) {
            // Si no hay clientes, empezar con C00001
            return 'C00001';
        }

        // Extraer el número del último ID (ej: C00005 -> 00005)
        $numeroActual = (int) substr($ultimoCliente->id_cliente, 1);
        $numeroNuevo = $numeroActual + 1;

        // Formatear el nuevo ID (ej: C00006)
        return 'C' . str_pad($numeroNuevo, 5, '0', STR_PAD_LEFT);
    }
}
