<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ClienteAuthController extends Controller
{
    public function showLogin()
    {
        return view('cliente.login_Clie');
    }

    /**
     * Vista pública de inicio (no requiere sesión cliente)
     */
    public function publicInicio()
    {
        $destinos = \App\Models\Destino::orderBy('nombre')->take(6)->get();
        $tours = \App\Models\Tour::with('destino')->where('estado', 'activo')->take(6)->get();
        $reservas = collect();

        return view('cliente.inicio_Clie', compact('destinos', 'tours', 'reservas'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo'   => 'required|email',
            'password' => 'required',
        ]);

        $cliente = Cliente::where('correo', $request->correo)->first();

        if (! $cliente || $cliente->contraseña !== $request->password) {
            return back()->withErrors(['correo' => 'Correo o contraseña incorrectos.'])->withInput();
        }

        Session::put('cliente_id', $cliente->id_cliente);
        Session::put('cliente_nombre', $cliente->nombre);
        return redirect()->route('cliente.inicio');
    }

    public function logout()
    {
        Session::forget('cliente_id');
        return redirect()->route('cliente.login');
    }

    public function showRegister()
    {
        $tiposDocumento = \App\Models\TipoDocumento::all();
        return view('cliente.registro_Clie', compact('tiposDocumento'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'apellidos'    => 'required|string|max:100',
            'id_tipdoc'    => 'required|exists:tipodocumento,id_tipdoc',
            'nro_documento'=> 'required|string|max:18',
            'correo'       => 'required|email|max:100|unique:cliente,correo',
            'nacionalidad' => 'nullable|string|max:18',
            'telefono'     => 'nullable|string|max:18',
            'password'     => 'required|string|max:8|confirmed',
            'terminos'     => 'accepted',
        ]);

        $cliente = new Cliente();
        $cliente->id_cliente    = strtoupper(substr(uniqid('C'), 0, 7));
        $cliente->nombre        = $request->nombre;
        $cliente->apellidos     = $request->apellidos;
        $cliente->id_tipdoc     = $request->id_tipdoc;
        $cliente->nro_documento = $request->nro_documento;
        $cliente->correo        = $request->correo;
        $cliente->contraseña    = $request->password;
        $cliente->nacionalidad  = $request->nacionalidad;
        $cliente->telefono      = $request->telefono;
        $cliente->save();

        Session::put('cliente_id', $cliente->id_cliente);
        Session::put('cliente_nombre', $cliente->nombre);
        return redirect()->route('cliente.inicio');
    }

    public function inicio()
    {
        $destinos = \App\Models\Destino::orderBy('nombre')->take(6)->get();
        $tours = \App\Models\Tour::with('destino')->where('estado', 'activo')->take(6)->get();

        $reservas = collect();
        if (Session::has('cliente_id')) {
            $reservas = \App\Models\Reserva::with('detalles.tour')
                ->where('id_cliente', Session::get('cliente_id'))
                ->orderBy('fecha_reserva', 'desc')
                ->take(3)
                ->get();
        }

        return view('cliente.inicio_Clie', compact('destinos', 'tours', 'reservas'));
    }
}
