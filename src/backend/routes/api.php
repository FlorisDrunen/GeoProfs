<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Api\VerlofController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Test route
Route::get('/', function (){
    return 'API connected';
});

Route::apiresource('verlof', VerlofController::class);
