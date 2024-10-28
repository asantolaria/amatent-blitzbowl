<?php

use App\Http\Controllers\JornadaLigaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubastaController;
use App\Http\Controllers\MessageController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

# endpoint para comprobar la finalización de las subastas
Route::get('/check-subastas', [SubastaController::class, 'apiCheckFinishSubasta']);
Route::get('/check-jornadas', [JornadaLigaController::class, 'apiCheckFinishJornada']); // No se usa actualmente
Route::post('/send-pusher', [MessageController::class, 'sendPusher']);
