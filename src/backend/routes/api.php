<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerlofController;

Route::get('/verlof/create', [VerlofController::class, 'create'])->name('verlof.create');
Route::apiresource('verlof', VerlofController::class);