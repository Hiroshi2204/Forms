<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntecedentesPersonalesController;
use App\Http\Controllers\ClinicaLocalController;
use App\Http\Controllers\Empresa\EmpresaPaqueteController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\OficioController;
use App\Http\Controllers\ReportePDFController;
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
    Route::post('documentos/creacion_oficios_documentos', [OficioController::class, 'store']);
    Route::post('oficios/actualizar_oficios', [OficioController::class, 'update']);
    Route::get('documentos/buscar', [FormularioController::class, 'buscar']);
    Route::get('documentos/buscar/nombre', [FormularioController::class, 'buscar_nombre']);
    Route::get('documentos/buscar/asunto', [FormularioController::class, 'buscar_asunto']);
    Route::get('documentos/buscar/numero', [FormularioController::class, 'buscar_numero']);
    Route::get('documentos/buscar/resumen', [FormularioController::class, 'buscar_resumen']);
    Route::get('documentos/buscar/fecha', [FormularioController::class, 'buscar_fecha']);
    Route::get('documentos/buscar/busqueda_documentos_parametros', [FormularioController::class, 'buscar_parametro']);
    Route::get('documentos/get', [FormularioController::class, 'get']);
    Route::get('documentos/get_oficinas', [FormularioController::class, 'get_oficinas']);
    Route::get('documentos/get_id', [FormularioController::class, 'get_id']);
    Route::post('documentos/eliminar', [FormularioController::class, 'eliminar']);
    Route::post('/documentos/descargar', [FormularioController::class, 'descargarPdf']);
    Route::get('documentos/get/documentos', [FormularioController::class, 'filtro']);
    Route::get('documentos/get/oficio', [OficioController::class, 'filtro_oficio']);

    Route::get('oficios/get_documentos', [OficioController::class, 'get_oficios_documentos']);
    Route::get('oficios/get', [OficioController::class, 'get_oficios']);
    Route::get('oficios/get_id', [OficioController::class, 'get_oficios_id']);
    Route::post('oficios/publicar', [AdminController::class, 'publicar']);
    Route::post('oficios/despublicar', [AdminController::class, 'despublicar']);
    Route::get('oficios/get/pendientes', [OficioController::class, 'get_oficios_pendientes']);
    Route::get('oficios/get/publicados', [OficioController::class, 'get_oficios_publicados']);

    // Actualizar contraseña
    Route::put('password/update', 'AuthController@updatePassword');

    //Reportes en PDF
    Route::get('reporte/oficios/ejemplo/pdf', [ReportePDFController::class, 'descargarReporteEjemplo'])->name('reporte.oficios');
    Route::get('reporte/oficios/facultades/pdf', [ReportePDFController::class, 'descargarReporte_facultades'])->name('reporte.oficios.facultades');


});
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/