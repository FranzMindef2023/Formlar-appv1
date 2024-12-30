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
use App\Http\Controllers\Api\UnidadesEducativaController;
use App\Http\Controllers\Api\VistaPorcentajeController;

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
Route::get('premilitar/estoy-invitado/{ci}', [PremilitarController::class, 'am_i_invited']);

Route::apiResource('aperturas', AperturaController::class);
Route::get('aperturas/{gestion}', [AperturaController::class, 'show_by_gestion']);


Route::apiResource('divisiones', DivisionController::class);
Route::apiResource('centros-reclutamiento', CentrosReclutamientoController::class);
Route::apiResource('unidades-educativas', UnidadesEducativaController::class);

Route::prefix('cupos')->group(function () {
    Route::apiResource('division', CuposDivisionController::class);
    Route::apiResource('centros-reclutamiento', CuposCentrosReclutamientoController::class);
    Route::apiResource('unidades-educativas', CuposUnidadesEducativaController::class);
});



Route::middleware('auth:api')->group(function () {
    // jerarquized
    Route::apiResource('fuerzas', FuerzasController::class);
    Route::apiResource('departamentos', DepartamentoController::class);

    Route::get('showroluser/{id}',  [UserController::class, 'showroluser']);

    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('roles', RolesController::class);





    Route::apiResource('premilitar', PremilitarController::class);
    Route::get('premilitar/habilitados-edad', [PremilitarController::class, 'index_habilitados_edad']);
    Route::get('premilitar/invitados', [PremilitarController::class, 'index_invitados']);


    // calls to view_porcentajes in the db, how many students male and female by ue
    Route::get('porcentajes/{ue_id}', [VistaPorcentajeController::class, 'show_by_ue']);
    Route::get('porcentajes/{ue_id}/{gestion}', [VistaPorcentajeController::class, 'show_by_ue_gestion']);
});
