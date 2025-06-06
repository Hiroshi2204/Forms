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

    Route::get('documentos/get', [FormularioController::class, 'get']);
    Route::get('documentos/get_id', [FormularioController::class, 'get_id']);

    // Actualizar contraseña
    Route::put('password/update', 'AuthController@updatePassword');

});
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
