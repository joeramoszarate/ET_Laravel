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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $cliente = Cliente::where('email', $request->email)->first();
        if (! $cliente || ! Hash::check($request->password, $cliente->password)) {
            return back()->withErrors(['email' => 'Credenciales inválidas'])->withInput();
        }

        Session::put('cliente_id', $cliente->id);
        return redirect()->route('cliente.inicio');
    }

    public function logout()
    {
        Session::forget('cliente_id');
        return redirect()->route('cliente.login');
    }

    public function showRegister()
    {
        return view('cliente.registro_Clie');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->email = $request->email;
        $cliente->password = Hash::make($request->password);
        if ($request->filled('telefono')) {
            $cliente->telefono = $request->telefono;
        }
        $cliente->save();

        Session::put('cliente_id', $cliente->id);
        return redirect()->route('cliente.inicio');
    }

    public function inicio()
    {
        if (! Session::has('cliente_id')) {
            return redirect()->route('cliente.login');
        }

        $clienteId = Session::get('cliente_id');

        // Destinos y tours para mostrar en la landing
        $destinos = \App\Models\Destino::orderBy('nombre')->take(6)->get();
        $tours = \App\Models\Tour::with('destino')->where('estado', 'activo')->take(6)->get();

        // Reservas del cliente (últimas 3)
        $reservas = \App\Models\Reserva::with('detalles.tour')
            ->where('id_cliente', $clienteId)
            ->orderBy('fecha_reserva', 'desc')
            ->take(3)
            ->get();

        return view('cliente.inicio_Clie', compact('destinos', 'tours', 'reservas'));
    }
}
