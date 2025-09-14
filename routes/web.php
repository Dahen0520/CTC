<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\MotivoController;
use App\Http\Controllers\TipoVisitaController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\AfiliadoController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

    // --- Rutas para el controlador de búsqueda ---
    // Muestra el formulario de búsqueda
    Route::get('/buscar-afiliado', [BusquedaController::class, 'index'])->name('busqueda.index');

    // Procesa la solicitud de búsqueda
    Route::post('/buscar-afiliado', [BusquedaController::class, 'buscar'])->name('busqueda.buscar');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::resource('motivos', MotivoController::class);
        Route::resource('tipo-visitas', TipoVisitaController::class);

        // --- Rutas de visitas personalizadas (colocadas antes del recurso) ---
        Route::get('visitas/registrar', [VisitaController::class, 'registrar'])->name('visitas.registrar');
        Route::post('afiliados/verificar-dni', [AfiliadoController::class, 'verificarDni'])->name('afiliados.verificar');

        // --- Ruta de recurso para visitas ---
        Route::resource('visitas', VisitaController::class);
});

// --- GRUPO DE RUTAS DE ADMINISTRACIÓN ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class); 
});

require __DIR__.'/auth.php';