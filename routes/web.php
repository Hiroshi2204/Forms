<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\ReportePDFController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/



Route::get('/login', [LoginController::class, 'mostrar_login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

Route::get('/formulario/{id}', [LoginController::class, 'mostrar_formulario'])->name('mostrar_formulario');
Route::post('/formulario/{id}', [LoginController::class, 'store']);

Route::group(['middleware' => ['cors']], function () {

    Route::get('/buscar', [LoginController::class, 'buscar'])->name('resolucion.buscar');
});
Route::middleware(['web'])->group(function () {
    // Rutas aquí

});
Route::group(['middleware' => ['jwt.verify', 'cors']], function () {});
