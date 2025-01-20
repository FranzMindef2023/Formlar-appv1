<?php

use App\Http\Controllers\Api\AperturaController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CentrosReclutamientoController;
use App\Http\Controllers\Api\CuposCentrosReclutamientoController;
use App\Http\Controllers\Api\CuposDivisionController;
use App\Http\Controllers\Api\DepartamentoController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\FuerzasController;
use App\Http\Controllers\Api\CuposUnidadesEducativaController;
use App\Http\Controllers\Api\PremilitarController;
use App\Http\Controllers\Api\ReportesController;
use App\Http\Controllers\Api\UnidadesEducativaController;
use App\Http\Controllers\Api\VistaPorcentajeController;
use App\Models\Division;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::post('assign-role', [UserController::class, 'asignarRoles']);
// premilitar
Route::get('premilitar/estoy-invitado/{ci}', [PremilitarController::class, 'am_i_invited']);

//reportes
Route::get('reportes/premilitares/{id}', [ReportesController::class, 'ei']);



// protected
Route::middleware('auth:api')->group(function () {
    Route::apiResource('fuerzas', FuerzasController::class);
    Route::apiResource('departamentos', DepartamentoController::class);
    Route::apiResource('divisiones', DivisionController::class);
    Route::apiResource('centros-reclutamiento', CentrosReclutamientoController::class);
    Route::apiResource('unidades-educativas', UnidadesEducativaController::class);


    Route::prefix('gestion')->group(function () {
        Route::get('aperturas/{year}', [AperturaController::class, 'show_by_gestion']);
        Route::get('division/{year}', [DivisionController::class, 'show_by_gestion']);
        Route::get('centros-reclutamiento/{year}', [CentrosReclutamientoController::class, 'show_by_gestion']);
        Route::get('unidades-educativas/{year}', [UnidadesEducativaController::class, 'show_by_gestion']);
    });

    Route::prefix('cupos')->group(function () {
        Route::apiResource('aperturas', AperturaController::class);
        Route::apiResource('division', CuposDivisionController::class);
        Route::apiResource('centros-reclutamiento', CuposCentrosReclutamientoController::class);
        Route::apiResource('unidades-educativas', CuposUnidadesEducativaController::class);
    });
    Route::get('porcentajes/oficio', [VistaPorcentajeController::class, 'oficio']);
    Route::get('porcentajes/{ue_id}/{gestion}', [VistaPorcentajeController::class, 'show_by_ue_gestion']);
    Route::get('porcentajes/{ue_id}', [VistaPorcentajeController::class, 'show_by_ue']);

    Route::get('showroluser/{id}',  [UserController::class, 'showroluser']);

    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('roles', RolesController::class);

    Route::apiResource('premilitar', PremilitarController::class);
    Route::get('premilitar/habilitados-edad', [PremilitarController::class, 'index_habilitados_edad']);
    Route::get('premilitar/invitados', [PremilitarController::class, 'index_invitados']);
});
