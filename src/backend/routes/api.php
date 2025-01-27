<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerlofApiController;
use Illuminate\Support\Facades\Route;

// Test route
Route::get('/', function (){
    return 'API connected';
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/register', [AuthController::class, 'showRegister']);

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

Route::apiresource('verlof', VerlofApiController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});