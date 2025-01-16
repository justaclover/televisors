<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TVController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Index');
Route::get('/add-device', [TVController::class, 'store']);
Route::get('/devices/{device}/playlist', [TVController::class, 'getPlaylist']);


Route::inertia('/admin', 'AdminIndex');

Route::post('/admin/videos', [AdminController::class, 'storeVideo']);

Route::post('/admin/playlists', [AdminController::class, 'storePlaylist']);
