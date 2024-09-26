<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\PrimerEmpleadoController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Bodega\BodegaController;
use App\Http\Controllers\Caja\CajaController;
use App\Http\Controllers\Inventario\InventarioController;
use App\Http\Middleware\Admin;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin/primero', [PrimerEmpleadoController::class, 'show'])->name('empleado.primer.registro');
Route::post('/admin/primero', [PrimerEmpleadoController::class, 'store'])->name('empleado.primer.registro.store');



Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class,'customLogin'])->name('login.custom');

//Rutas en las cuales se necesita autenticacion por Middleware

Route::post('/logout', [LoginController::class,'logout'])->name('logout');

Route::get('/admin/dashboard', [AdminController::class, 'show'])->name('admin.dashboard');
Route::get('/admin/agregar-empleado', [PrimerEmpleadoController::class, 'showAddEmpleado'])->name('admin.dashboard.add.empleado');
Route::get('/admin/reportes', [AdminController::class, 'verReportes'])->name('admin.dashboard.reportes');
Route::get('/admin/tarjetas', [AdminController::class, 'verTarjetas'])->name('admin.dashboard.tarjetas');

Route::get('/caja/dashboard', [CajaController::class, 'dashboard'])->name('caja.dashboard');
Route::post('/caja/agregarcarrito', [CajaController::class, 'agregarAlCarrito'])->name('caja.agregar.carrito');
Route::get('/caja/procesarcompra', [CajaController::class, 'completarCompra'])->name('caja.completar.compra');
Route::post('/caja/procesarcompra', [CajaController::class, 'procesarCompra'])->name('caja.procesar.compra');
Route::post('/caja/limpiarcarrito', [CajaController::class, 'limpiarCarrito'])->name('caja.limpiar.carrito');

Route::get('/bodega/dashboard', [BodegaController::class, 'dashboard'])->name('bodega.dashboard');
Route::get('/bodega/agregarproducto', [BodegaController::class, 'agregarProductoSucursal'])->name('bodega.agregar.producto');
Route::post('/bodega/agregarproducto', [BodegaController::class, 'storeProductosSucursal'])->name('bodega.productos.store');
Route::get('/bodega/eliminarproducto', [BodegaController::class, 'eliminarProductosSucursal'])->name('bodega.eliminar.productos');
Route::post('/bodega/eliminarproducto', [BodegaController::class, 'borrarProductoSucursal'])->name('bodega.eliminar.productos');
Route::get('/bodega/agregarproductosistema', [BodegaController::class, 'agregarProductosSistema'])->name('bodega.agregar.productos.sistema');
Route::post('/bodega/agregarproductosistema', [BodegaController::class, 'storeProductoSistema'])->name('bodega.agregar.productos.sistema');

Route::get('/inventario/dashboard', [InventarioController::class, 'dashboard'])->name('inventario.dashboard');
Route::post('/inventario/trasladar', [InventarioController::class, 'trasladarAEstanteria'])->name('inventario.trasladar');




