<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DaftarExtensionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ---- ROUTE API UNTUK DAFTAR EXTENSION (DILINDUNGI API KEY) ----
Route::middleware('apikey')->group(function () {
    Route::get('/extensions', [DaftarExtensionController::class, 'index']);
    Route::get('/extensions/{id}', [DaftarExtensionController::class, 'show']); // kalau method show ada
});
