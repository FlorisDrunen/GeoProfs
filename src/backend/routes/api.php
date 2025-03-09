<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VerlofApiController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;


    /**
     * Routes where sessions are made.
     */
Route::middleware([StartSession::class])->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin']);

     /**
     * Routes where a user must be logged in in order to access them
     */
Route::middleware(['auth'])->group(function () {

     /**
     * Register routes.
     */
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::get('/register', [AuthController::class, 'showRegister']);

     /**
     * Logout route.
     */
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

        // Route::apiresource('verlof', VerlofApiController::class);

     /**
     * Leave requests overwiew routes.
     */
        Route::get('/verlof-overzicht', [VerlofApiController::class, 'verlofOverzicht'])->name('verlofOverzicht');
        Route::get('/verlof/{id}', [VerlofApiController::class, 'show'])->name('enkelVerlof');

     /**
     * New request routes.
     */
        Route::get('/verlof-aanvraag', [VerlofApiController::class, 'create'])->name('verlofAanvraag');
        Route::post('/verlof-nieuw', [VerlofApiController::class, 'store'])->name('verlofNieuw');

    /**
     * Routes to accept or deny a single request.
     */
        Route::patch('/verlof/{id}/approve', [VerlofApiController::class, 'approve'])->name('verlofApprove');
        Route::patch('/verlof/{id}/deny', [VerlofApiController::class, 'deny'])->name('verlofDeny');


    /**
     * Routes to update a single request.
     */
        Route::get('/verlof-update/{id}', [VerlofApiController::class, 'updateview'])->name('verlofUpdaten');
        Route::put('/verlof-update-func/{id}', [VerlofApiController::class, 'update'])->name('verlofUpdatenFunc');


     /**
     * Route to delete a single leave request.
     */
        Route::delete('/verlof-delete/{id}', [VerlofApiController::class, 'destroy'])->name('verlofVerwijderen');

    /**
     * Dashboard route.
     */
        Route::get('/dashboard', function () {
            return view('auth.dashboard');
        })->middleware('auth')->name('dashboard');
    });
});
    /**
     * Default laravel view.
     */
Route::get('/', function () {
    return view('welcome');
});