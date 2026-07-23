<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PresentacioneController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedoreController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MonitorController;

Route::get('/', [HomeController::class,'index'])->name('panel');
Route::get('/dashboard/monitor', [MonitorController::class, 'index'])->name('monitor.index');
Route::get('/dashboard/monitor/data', [MonitorController::class, 'data'])->name('monitor.data');
Route::post('/dashboard/monitor/backup', [MonitorController::class, 'backup'])->name('monitor.backup');

Route::resources([
    'categorias' => CategoriaController::class,
    'presentaciones' => PresentacioneController::class,
    'marcas' => MarcaController::class,
    'productos' => ProductoController::class,
    'clientes' => ClienteController::class,
    'proveedores' => ProveedoreController::class,
    'compras' => CompraController::class,
    'ventas' => VentaController::class,
    'users' => UserController::class,
    'roles' => RoleController::class,
    'profile' => ProfileController::class,
]);

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'login']);
Route::post('/logout',[LogoutController::class,'logout'])->name('logout');

Route::get('/401', fn() => view('pages.401'));
Route::get('/404', fn() => view('pages.404'));
Route::get('/500', fn() => view('pages.500'));
