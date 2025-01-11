<?php

use App\Http\Controllers\TVController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Index');
Route::get('/add-device', [TVController::class, 'store']);
