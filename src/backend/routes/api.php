<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerlofController;
use App\Http\Controllers\StatusController;

//Reminder, de URL gaat er zo uitzien: http://localhost:8000/api/admin/verlof/create
// Route::get('/verlof/create', [VerlofController::class, 'create'])->name('verlof.create');
Route::post('/verlof/store', [VerlofController::class, 'store']);
Route::get('/verlof', [VerlofController::class, 'index']);
Route::apiresource('verlof', VerlofController::class);

Route::get('/status', [StatusController::class, 'index']);
Route::apiresource('status', StatusController::class);