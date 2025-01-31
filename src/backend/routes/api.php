<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerlofApiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/register', [AuthController::class, 'showRegister']);

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');


// Route::apiresource('verlof', VerlofApiController::class);


Route::get('/verlof-overzicht', [VerlofApiController::class, 'verlofOverzicht'])->name('verlofOverzicht');


Route::get('/verlof-aanvraag', [VerlofApiController::class, 'create'])->name('verlofAanvraag');
Route::post('/verlof-nieuw', [VerlofApiController::class, 'store'])->name('verlofNieuw');

Route::get('/verlof/{id}', [VerlofApiController::class, 'show'])->name('enkelVerlof');

Route::patch('/verlof/{id}/approve', [VerlofApiController::class, 'approve'])->name('verlofApprove');
Route::patch('/verlof/{id}/deny', [VerlofApiController::class, 'deny'])->name('verlofDeny');


Route::get('/verlof-update/{id}', [VerlofApiController::class, 'updateview'])->name('verlofUpdaten');
Route::put('/verlof-update-func/{id}', [VerlofApiController::class, 'update'])->name('verlofUpdatenFunc');

Route::delete('/verlof-delete/{id}', [VerlofApiController::class, 'destroy'])->name('verlofVerwijderen');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

