<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntecedentesPersonalesController;
use App\Http\Controllers\ClinicaLocalController;
use App\Http\Controllers\Empresa\EmpresaPaqueteController;
use App\Http\Controllers\FormularioController;
use App\Models\Rol;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => ['cors']], function () {
    Route::post('login', 'AuthController@authenticate');
});

Route::group(['middleware' => ['jwt.verify', 'cors']], function () {
    Route::post('documentos', [FormularioController::class, 'store']);
    Route::get('documentos/buscar', [FormularioController::class, 'buscar']);
    Route::get('documentos/buscar/nombre', [FormularioController::class, 'buscar_nombre']);
    Route::get('documentos/buscar/asunto', [FormularioController::class, 'buscar_asunto']);
    Route::get('documentos/buscar/numero', [FormularioController::class, 'buscar_numero']);
    Route::get('documentos/buscar/resumen', [FormularioController::class, 'buscar_resumen']);
    Route::get('documentos/buscar/fecha', [FormularioController::class, 'buscar_fecha']);
    Route::get('documentos/buscar/parametro', [FormularioController::class, 'buscar_parametro']);

    Route::get('documentos/get', [FormularioController::class, 'get']);
    Route::get('documentos/get_oficinas', [FormularioController::class, 'get_oficinas']);
    Route::get('documentos/get_id', [FormularioController::class, 'get_id']);

    Route::post('documentos/eliminar', [FormularioController::class, 'eliminar']);

    Route::post('/documentos/descargar', [FormularioController::class, 'descargarPdf']);

    Route::get('documentos/get/anio', [FormularioController::class, 'filtro']);

    // Actualizar contraseña
    Route::put('password/update', 'AuthController@updatePassword');

});
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/