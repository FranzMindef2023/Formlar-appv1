<?php

use App\Http\Controllers\Api\AperturaController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CentrosReclutamientoController;
use App\Http\Controllers\Api\CuposDivisionController;
use App\Http\Controllers\Api\DepartamentoController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\FuerzasController;

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



Route::apiResource('centros-reclutamiento', CentrosReclutamientoController::class);
Route::apiResource('cupos-division', CuposDivisionController::class);
Route::apiResource('aperturas', AperturaController::class);
Route::post('assign-role', [UserController::class, 'asignarRoles']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('fuerzas', FuerzasController::class);
    Route::apiResource('departamentos', DepartamentoController::class);
    Route::apiResource('divisiones', DivisionController::class);

    Route::get('showroluser/{id}',  [UserController::class, 'showroluser']);

    Route::apiResource('usuarios', UserController::class);
    Route::apiResource('roles', RolesController::class);
});
