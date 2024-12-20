<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\AuthController;


use App\Http\Controllers\Api\FuerzasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::apiResource('/usuarios', UserController::class);
// Route::apiResource('/rolsUser', RolesController::class);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::apiResource('fuerzas', FuerzasController::class);
Route::post('roldeusuario', [UserController::class, 'asignarRoles']);

Route::middleware('auth:api')->group(function () {
    Route::get('showroluser/{id}',  [UserController::class, 'showroluser']);
    Route::apiResource('roles', RolesController::class);
    Route::apiResource('usuarios', UserController::class);
});
