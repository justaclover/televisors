<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

//Сторона устройства

Route::inertia('/', 'Index');
Route::get('/add-device', [DeviceController::class, 'store']);
Route::get('/devices/{device}/playlist', [DeviceController::class, 'getPlaylist']);



//Сторона админки
Route::get('/admin', [AdminController::class, 'index']);

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::resource('playlist', PlaylistController::class);
    Route::resource('device', DeviceController::class);
    Route::post('/playlist/{playlist}/file', [PlaylistController::class, 'upload']);
    Route::get('/device/{device}/playlist/attach/{playlist}', [PlaylistController::class, 'attach']);
    Route::get('/device/{device}/playlist/detach', [PlaylistController::class, 'detach']);
});

Route::resource('file', FileController::class);

// Route::post('/admin/playlists/{playlist}/video', [AdminController::class, 'storeVideo']);


// Route::post('/admin/playlists', [AdminController::class, 'storePlaylist']);
