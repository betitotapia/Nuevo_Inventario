<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ExistenciaController;
use App\Http\Controllers\AjusteInventarioController;
use App\Http\Controllers\TraspasoController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/usuarios', [UserController::class, 'index'])
        ->middleware('permission:ver_usuarios')
        ->name('usuarios.index');

    Route::get('/usuarios/create', [UserController::class, 'create'])
        ->middleware('permission:crear_usuarios')
        ->name('usuarios.create');

    Route::post('/usuarios', [UserController::class, 'store'])
        ->middleware('permission:crear_usuarios')
        ->name('usuarios.store');

    Route::get('/usuarios/{user}', [UserController::class, 'show'])
        ->middleware('permission:ver_usuarios')
        ->name('usuarios.show');

    Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])
        ->middleware('permission:editar_usuarios')
        ->name('usuarios.edit');

    Route::put('/usuarios/{user}', [UserController::class, 'update'])
        ->middleware('permission:editar_usuarios')
        ->name('usuarios.update');

    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:editar_usuarios')
        ->name('usuarios.destroy');

    Route::patch('/usuarios/{user}/toggle-active', [UserController::class, 'toggleActive'])
        ->middleware('permission:editar_usuarios')
        ->name('usuarios.toggle-active');

    Route::view('/privado/remisiones', 'privado.remisiones.index')
        ->middleware('permission:ver_remisiones_privado')
        ->name('privado.remisiones.index');

    Route::view('/integral/servicios', 'integral.servicios.index')
        ->middleware('permission:ver_servicios_integrales')
        ->name('integral.servicios.index');

        Route::get('/almacenes', [AlmacenController::class, 'index'])
    ->middleware('permission:ver_almacenes')
    ->name('almacenes.index');

        Route::get('/almacenes/create', [AlmacenController::class, 'create'])
            ->middleware('permission:crear_almacenes')
            ->name('almacenes.create');

        Route::post('/almacenes', [AlmacenController::class, 'store'])
            ->middleware('permission:crear_almacenes')
            ->name('almacenes.store');

        Route::get('/almacenes/{almacene}', [AlmacenController::class, 'show'])
            ->middleware('permission:ver_almacenes')
            ->name('almacenes.show');

        Route::get('/almacenes/{almacene}/edit', [AlmacenController::class, 'edit'])
            ->middleware('permission:editar_almacenes')
            ->name('almacenes.edit');

        Route::put('/almacenes/{almacene}', [AlmacenController::class, 'update'])
            ->middleware('permission:editar_almacenes')
            ->name('almacenes.update');

        Route::delete('/almacenes/{almacene}', [AlmacenController::class, 'destroy'])
            ->middleware('permission:editar_almacenes')
            ->name('almacenes.destroy');

        Route::patch('/almacenes/{almacene}/toggle-active', [AlmacenController::class, 'toggleActive'])
            ->middleware('permission:editar_almacenes')
            ->name('almacenes.toggle-active');
        Route::get('/usuarios/{user}/almacenes', [UserController::class, 'almacenes'])
            ->middleware('permission:editar_usuarios')
            ->name('usuarios.almacenes');

        Route::put('/usuarios/{user}/almacenes', [UserController::class, 'updateAlmacenes'])
            ->middleware('permission:editar_usuarios')
            ->name('usuarios.almacenes.update');

        Route::get('/clientes', [ClienteController::class, 'index'])
            ->middleware('permission:ver_clientes')
            ->name('clientes.index');

        Route::get('/clientes/create', [ClienteController::class, 'create'])
            ->middleware('permission:crear_clientes')
            ->name('clientes.create');

        Route::post('/clientes', [ClienteController::class, 'store'])
            ->middleware('permission:crear_clientes')
            ->name('clientes.store');

        Route::get('/clientes/{cliente}', [ClienteController::class, 'show'])
            ->middleware('permission:ver_clientes')
            ->name('clientes.show');

        Route::get('/clientes/{cliente}/edit', [ClienteController::class, 'edit'])
            ->middleware('permission:editar_clientes')
            ->name('clientes.edit');

        Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])
            ->middleware('permission:editar_clientes')
            ->name('clientes.update');

        Route::patch('/clientes/{cliente}/toggle-active', [ClienteController::class, 'toggleActive'])
            ->middleware('permission:editar_clientes')
            ->name('clientes.toggle-active');
        Route::get('/usuarios/{user}/almacenes', [UserController::class, 'almacenes'])
            ->middleware('permission:editar_usuarios')
            ->name('usuarios.almacenes');

        Route::put('/usuarios/{user}/almacenes', [UserController::class, 'updateAlmacenes'])
            ->middleware('permission:editar_usuarios')
            ->name('usuarios.almacenes.update');
        Route::get('/productos', [ProductoController::class, 'index'])
            ->middleware('permission:ver_productos')
            ->name('productos.index');

        Route::get('/productos/create', [ProductoController::class, 'create'])
            ->middleware('permission:crear_productos')
            ->name('productos.create');

        Route::post('/productos', [ProductoController::class, 'store'])
            ->middleware('permission:crear_productos')
            ->name('productos.store');

        Route::get('/productos/{producto}', [ProductoController::class, 'show'])
            ->middleware('permission:ver_productos')
            ->name('productos.show');

        Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])
            ->middleware('permission:editar_productos')
            ->name('productos.edit');

        Route::put('/productos/{producto}', [ProductoController::class, 'update'])
            ->middleware('permission:editar_productos')
            ->name('productos.update');

        Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])
            ->middleware('permission:editar_productos')
            ->name('productos.destroy');

        Route::patch('/productos/{producto}/toggle-active', [ProductoController::class, 'toggleActive'])
            ->middleware('permission:editar_productos')
            ->name('productos.toggle-active');
        
        Route::get('/inventario/existencias', [ExistenciaController::class, 'index'])
            ->middleware('permission:ver_existencias')
            ->name('inventario.existencias');

        Route::get('/inventario/ajustes', [AjusteInventarioController::class, 'index'])
            ->middleware('permission:crear_ajustes')
            ->name('inventario.ajustes.index');

        Route::get('/inventario/ajustes/create', [AjusteInventarioController::class, 'create'])
            ->middleware('permission:crear_ajustes')
            ->name('inventario.ajustes.create');

        Route::post('/inventario/ajustes', [AjusteInventarioController::class, 'store'])
            ->middleware('permission:crear_ajustes')
            ->name('inventario.ajustes.store');
        Route::get('/inventario/traspasos', [TraspasoController::class, 'index'])
            ->middleware('permission:crear_traspasos')
            ->name('inventario.traspasos.index');

        Route::get('/inventario/traspasos/create', [TraspasoController::class, 'create'])
            ->middleware('permission:crear_traspasos')
            ->name('inventario.traspasos.create');

        Route::post('/inventario/traspasos', [TraspasoController::class, 'store'])
            ->middleware('permission:crear_traspasos')
            ->name('inventario.traspasos.store');

        Route::get('/inventario/traspasos/{traspaso}', [TraspasoController::class, 'show'])
            ->middleware('permission:crear_traspasos')
            ->name('inventario.traspasos.show');
});

require __DIR__.'/auth.php';