<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\JugadorController;
use App\Http\Controllers\Api\LigaController;

// Lectura libre (cualquiera puede consultar)
Route::get('clubs', [ClubController::class, 'index']);
Route::get('clubs/{club}', [ClubController::class, 'show']);

Route::get('jugadors', [JugadorController::class, 'index']);
Route::get('jugadors/{jugador}', [JugadorController::class, 'show']);

Route::get('ligas', [LigaController::class, 'index']);
Route::get('ligas/{liga}', [LigaController::class, 'show']);

// Modificación solo administradores
Route::middleware('admin')->group(function () {
    Route::post('clubs', [ClubController::class, 'store']);
    Route::put('clubs/{club}', [ClubController::class, 'update']);
    Route::delete('clubs/{club}', [ClubController::class, 'destroy']);

    Route::post('jugadors', [JugadorController::class, 'store']);
    Route::put('jugadors/{jugador}', [JugadorController::class, 'update']);
    Route::delete('jugadors/{jugador}', [JugadorController::class, 'destroy']);

    Route::post('ligas', [LigaController::class, 'store']);
    Route::put('ligas/{liga}', [LigaController::class, 'update']);
    Route::delete('ligas/{liga}', [LigaController::class, 'destroy']);
});
