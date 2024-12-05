<?php

<<<<<<< HEAD
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Test route
Route::get('/', function (){
    return 'API connected';
});
=======
use app\Http\Controllers\Api\VerlofController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::apiresource('verlof', VerlofController::class);
>>>>>>> origin/verlofaanvragen
