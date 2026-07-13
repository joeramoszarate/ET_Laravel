<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PaqueteController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ConfiguracionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteAuthController;

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
    Route::get('/paquetes', [PaqueteController::class, 'index'])->name('paquetes');
    Route::get('/paquetes/{id}/edit', [PaqueteController::class, 'edit'])->name('paquetes.edit');
    Route::put('/paquetes/{id}', [PaqueteController::class, 'update'])->name('paquetes.update');
    Route::get('/tours', [TourController::class, 'index'])->name('tours');
    Route::get('/destinos', [DestinoController::class, 'index'])->name('destinos');
    Route::get('/destinos/create', [DestinoController::class, 'create'])->name('destinos.create');
    Route::post('/destinos', [DestinoController::class, 'store'])->name('destinos.store');
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes');
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion');
    Route::post('/configuracion', [ConfiguracionController::class, 'update'])->name('configuracion.update');
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
    Route::get('tours', function () { return view('cliente.tours_Clie'); })->name('tours');
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
