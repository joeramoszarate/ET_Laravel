@extends('cliente.layout_clie')

@section('title','Login Cliente')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded shadow">
        <div class="text-center mb-6">
            <img src="/build/assets/logo.png" alt="Logo" class="mx-auto h-12 w-12 mb-2">
            <h1 class="text-2xl font-bold">Acceso Clientes</h1>
        </div>

        @if($errors->any())
            <div class="mb-4 text-red-600">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('cliente.login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Correo</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Contraseña</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('cliente.register') }}" class="text-sm text-blue-600">Crear cuenta</a>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Entrar</button>
        </form>
        <p class="text-sm text-gray-500 mt-3 text-center">¿Eres administrador? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Inicia sesión aquí</a></p>
    </div>
</div>
@endsection
