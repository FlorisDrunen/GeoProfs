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

Route::get('/verlof-overzicht', [VerlofApiController::class, 'index'])->name('verlofOverzicht');

Route::get('/verlof-aanvraag', [VerlofApiController::class, 'create'])->name('verlofAanvraag');
Route::post('/verlof-nieuw', [VerlofApiController::class, 'store'])->name('verlofNieuw');

Route::get('/verlof/{id}', [VerlofApiController::class, 'show'])->name('enkelVerlof');

Route::patch('/verlof/{id}/approve', [VerlofApiController::class, 'approve'])->name('verlofApprove');
Route::patch('/verlof/{id}/deny', [VerlofApiController::class, 'deny'])->name('verlofDeny');


Route::put('/verlof-update/{id}', [VerlofApiController::class, 'update']);
Route::delete('/verlof-delete/{id}', [VerlofApiController::class, 'destroy'])->name('verlofVerwijderen');