<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GuestController;

// Modificar la ruta 'api/guests' para aceptar PUT
Route::put('guests', [GuestController::class, 'update']);

Route::apiResource('guests', GuestController::class);

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
