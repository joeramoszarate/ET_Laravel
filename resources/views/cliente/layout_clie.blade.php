<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title','Cliente')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    {{-- Fallback: si los assets ya fueron compilados con `npm run build` y Vite no está en modo dev, cargar el CSS compilado directamente --}}
    @php $compiledCss = 'build/assets/app-CEwZte8_.css'; @endphp
    @if(file_exists(public_path($compiledCss)))
        <link href="{{ asset($compiledCss) }}" rel="stylesheet">
    @endif
    <style>body{font-family:Inter,ui-sans-serif,system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial}</style>
</head>
<body class="bg-gray-100 min-h-screen text-black">
    @unless(request()->routeIs('cliente.login') || request()->routeIs('cliente.register'))
        @include('cliente.navbar')
    @endunless

    <div class="container mx-auto px-4 mt-6">
        @yield('content')
    </div>
</body>
</html>
