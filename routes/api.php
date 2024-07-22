<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GuestController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Modificar la ruta 'api/guests' para aceptar PUT
Route::put('guests', [GuestController::class, 'update']);

//Route::apiResource('guests', GuestController::class);
