<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ClienteTourController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\Admin\CalendarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteAuthController;
use App\Http\Controllers\ClienteReservaController;

// Página pública de inicio para clientes
Route::get('/', [ClienteAuthController::class, 'publicInicio'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/clients', [ClienteController::class, 'index'])->name('clients');
    Route::get('/clients/search', [ClienteController::class, 'search'])->name('clients.search');
    Route::get('/clients/create', [ClienteController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClienteController::class, 'store'])->name('clients.store');
    Route::get('/clients/{cliente}/edit', [ClienteController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{cliente}', [ClienteController::class, 'update'])->name('clients.update');

    Route::resource('reservas', ReservaController::class);
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos');
    Route::get('/caja', [CajaController::class, 'index'])->name('caja');
    Route::post('/caja/abrir', [CajaController::class, 'abrir'])->name('caja.abrir');
    Route::post('/caja/cerrar', [CajaController::class, 'cerrar'])->name('caja.cerrar');
    Route::post('/caja/movimiento', [CajaController::class, 'movimiento'])->name('caja.movimiento');
    Route::get('/paquetes', [PaqueteController::class, 'index'])->name('paquetes');
    Route::get('/paquetes/{id}/edit', [PaqueteController::class, 'edit'])->name('paquetes.edit');
    Route::get('/paquetes/{id}/json', [PaqueteController::class, 'editJson'])->name('paquetes.editJson');
    Route::put('/paquetes/{id}', [PaqueteController::class, 'update'])->name('paquetes.update');
    Route::get('/tours', [TourController::class, 'index'])->name('tours');
    Route::get('/tours/create', [TourController::class, 'create'])->name('tours.create');
    Route::post('/tours', [TourController::class, 'store'])->name('tours.store');
    Route::get('/tours/{id}/json', [TourController::class, 'editJson'])->name('tours.editJson');
    Route::get('/tours/{id}/edit', [TourController::class, 'edit'])->name('tours.edit');
    Route::put('/tours/{id}', [TourController::class, 'update'])->name('tours.update');
    Route::delete('/tours/{id}', [TourController::class, 'destroy'])->name('tours.destroy');
    Route::get('/destinos', [DestinoController::class, 'index'])->name('destinos');
    Route::get('/destinos/create', [DestinoController::class, 'create'])->name('destinos.create');
    Route::post('/destinos', [DestinoController::class, 'store'])->name('destinos.store');
    Route::get('/destinos/{id}/edit', [DestinoController::class, 'edit'])->name('destinos.edit');
    Route::post('/destinos/{id}', [DestinoController::class, 'update'])->name('destinos.update');
    Route::delete('/destinos/{id}', [DestinoController::class, 'destroy'])->name('destinos.destroy');
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
    Route::get('/usuarios-vista', [UsuarioController::class, 'vistaGestion'])->name('usuarios.vista');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/json', [UsuarioController::class, 'editJson'])->name('usuarios.editJson');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes');
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion');
    Route::post('/configuracion', [ConfiguracionController::class, 'update'])->name('configuracion.update');
    Route::get('/mi-pagina-web', [ConfiguracionController::class, 'mipagina'])->name('mipagina');
    Route::post('/mi-pagina-web', [ConfiguracionController::class, 'updateWeb'])->name('mipagina.update');
    Route::get('/admin/calendario', [CalendarioController::class, 'index'])->name('admin.calendario');
    Route::get('/admin/calendario/{id}/detalle', [CalendarioController::class, 'detalle'])->name('admin.calendario.detalle');
    Route::post('/admin/calendario/{id}/cancelar', [CalendarioController::class, 'cancelar'])->name('admin.calendario.cancelar');
});

require __DIR__.'/auth.php';

// Rutas separadas para la interfaz cliente (no interfieren con el panel admin)
Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::get('login', [ClienteAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [ClienteAuthController::class, 'login'])->name('login.post');
    Route::get('register', [ClienteAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [ClienteAuthController::class, 'register'])->name('register.post');
    Route::post('logout', [ClienteAuthController::class, 'logout'])->name('logout');

    Route::get('inicio', [ClienteAuthController::class, 'inicio'])->name('inicio');
    Route::get('perfil', [ClienteAuthController::class, 'perfil'])->name('perfil');
    Route::post('perfil', [ClienteAuthController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::post('perfil/password', [ClienteAuthController::class, 'cambiarPassword'])->name('perfil.password');
    Route::get('tours', [ClienteTourController::class, 'index'])->name('tours');
    Route::get('tours/{id}', [ClienteTourController::class, 'show'])->name('tours.show');
    Route::get('tours/{id_tour}/reserva', [ClienteReservaController::class, 'showTourReserva'])->name('tours.reserva');
    Route::post('tours/{id_tour}/reserva', [ClienteReservaController::class, 'storeTourReserva'])->name('tours.reserva.store');
    Route::get('destinos', function () {
        $destinos = \App\Models\Destino::orderBy('nombre')->get();
        return view('cliente.destinos_Clie', compact('destinos'));
    })->name('destinos');
    Route::get('paquetes', function () {
        $paquetes = \App\Models\Paquete::where('estado','A')->orderBy('precio_base')->get();
        $tipoPaquetes = \App\Models\Paquete::where('estado','A')
            ->selectRaw('id_tippaq, MIN(precio_base) as precio_min')
            ->groupBy('id_tippaq')->get();
        return view('cliente.paquetes_Clie', compact('paquetes','tipoPaquetes'));
    })->name('paquetes');
});
