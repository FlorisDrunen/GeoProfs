<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerlofController;

//Reminder, de URL gaat er zo uitzien: http://localhost:8000/api/admin/verlof/create
Route::get('/verlof/create', [VerlofController::class, 'create'])->name('verlof.create');
Route::post('/verlof/store', [VerlofController::class, 'store']);
Route::apiresource('verlof', VerlofController::class);