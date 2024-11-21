<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerlofController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('test', function () {
    return view('update-verlof-form');
});

Route::get('/verlof', [VerlofController::class, 'index'])->name('verlof');
