<nav class="bg-gradient-to-r from-green-700 via-blue-600 to-green-600 shadow-lg">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <div class="flex items-center space-x-4">
        <a href="{{ route('cliente.inicio') }}" class="flex items-center space-x-2 hover:opacity-80 transition">
          <img src="/build/assets/logo.png" alt="Logo" class="h-10 w-10 rounded-full">
          <span class="font-bold text-lg text-white">ExploreTuTumbes</span>
        </a>
      </div>

      <div class="hidden md:flex md:space-x-8">
        <a href="{{ route('cliente.inicio') }}" class="text-white hover:text-yellow-300 font-medium transition">Inicio</a>
        <a href="{{ route('cliente.tours') }}" class="text-white hover:text-yellow-300 font-medium transition">Tours</a>
        <a href="{{ route('cliente.destinos') }}" class="text-white hover:text-yellow-300 font-medium transition">Destinos</a>
        <a href="{{ route('cliente.paquetes') }}" class="text-white hover:text-yellow-300 font-medium transition">Paquetes</a>
      </div>

      <div class="flex items-center space-x-3">
        <a href="{{ route('cliente.login') }}" class="text-white hover:text-yellow-300 font-medium transition">Ingresar</a>
        <a href="{{ route('cliente.register') }}" class="bg-yellow-400 text-green-800 font-semibold px-4 py-2 rounded-lg hover:bg-yellow-300 transition shadow">Registrarse</a>
      </div>
    </div>
  </div>
</nav>
