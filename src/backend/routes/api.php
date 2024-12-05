<?php

use app\Http\Controllers\Api\VerlofController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

Route::apiresource('verlof', VerlofController::class);
