<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\VideoController;
use App\Models\Device;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Сторона устройства

Route::get('/', function (Request $request) {
    $device = Device::first(Cookie::get('device_id')) ?: Device::create();
//    $deviceId = Cookie::get('device_id');
//    // throw new Exception(json_encode(Cookie::get()));
//    $device = Device::firstOrCreate([
//        'id' => $deviceId
//    ]);

    return Inertia::render('Index', [
        'device_id' => $device->id,
        'videos' => $device->playlist ? $device->playlist->getMedia('*') : []
    ]);
});
Route::get('/add-device', [DeviceController::class, 'store']);
//Route::get('/devices/{device}/playlist', [DeviceController::class, 'getPlaylist'])->name('device.playlist');



//Сторона админки
Route::get('/admin', [AdminController::class, 'index']);

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::resource('playlist', PlaylistController::class);
    Route::resource('device', DeviceController::class);
    Route::resource('group', GroupController::class);
    Route::post('/playlist/{playlist}/file', [PlaylistController::class, 'upload']);
    Route::get('/device/{device}/playlist/attach/{playlist}', [PlaylistController::class, 'attach']);
    Route::get('/device/{device}/playlist/detach', [PlaylistController::class, 'detach']);
});

Route::resource('file', FileController::class);

// Route::post('/admin/playlists/{playlist}/video', [AdminController::class, 'storeVideo']);


// Route::post('/admin/playlists', [AdminController::class, 'storePlaylist']);
