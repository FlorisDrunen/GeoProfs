<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerlofApiController;
use Illuminate\Support\Facades\Route;

// Test route
Route::get('/', function (){
    return 'API connected';
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::apiresource('verlof', VerlofApiController::class);

Route::get('/verlof-overzicht', [VerlofApiController::class, 'index']);
Route::post('/verlof-nieuw', [VerlofApiController::class, 'store']);
Route::get('/verlof/{id}', [VerlofApiController::class, 'show']);
Route::put('/verlof-update/{id}', [VerlofApiController::class, 'update']);
Route::delete('/verlof-delete/{id}', [VerlofApiController::class, 'destroy']);