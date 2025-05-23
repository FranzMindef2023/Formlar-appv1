<?php

use App\Http\Controllers\Api\AperturaController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PersonasController;
use App\Http\Controllers\Api\UbicacionGeograficaController;
use App\Http\Controllers\Api\UnidadesEspecialesController;

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
Route::get('departamentos', [UbicacionGeograficaController::class, 'getDepartamentos']);
Route::get('zonasgeograficas', [UbicacionGeograficaController::class, 'getZonasGeograficas']);
Route::get('zonasgeograficasdepartamentos/{idzona}', [UbicacionGeograficaController::class, 'getDepartamentosZona']);
Route::get('municipios/{idDepartamento}', [UbicacionGeograficaController::class, 'getMunicipios']);
Route::middleware(['throttle:5,1'])->post('preinscripcion', [PersonasController::class, 'store']);
Route::get('provinciasum/{id}', [UnidadesEspecialesController::class, 'show']);
Route::get('personas/consultar', [PersonasController::class, 'consultarDatosPersona']);
