<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\VideoController;
use App\Models\Device;
use App\Models\Group;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

/**
 * Сторона устройства
**/
Route::get('/', function () {
    $deviceId = Cookie::get('device_id');
    $device = Device::firstOrCreate([
        'id' => $deviceId
    ]);

    //return response()->json('test');
    //$device = (!(Cookie::get('device_id') === null) and (Device::query()->where('id', Cookie::get('device_id'))->first())) ?: Device::query()->create();
    //dd(Device::query()->first(Cookie::get('device_id')));
//    $deviceId = Cookie::get('device_id');
//    // throw new Exception(json_encode(Cookie::get()));
//

    return Inertia::render('Index', [
        'device_id' => $device->id,
        'videos' => $device->playlist ? $device->playlist->getMedia('*') : []
    ]);
});

Route::get('/add-device', [DeviceController::class, 'store']);
//Route::get('/devices/{device}/playlist', [DeviceController::class, 'getPlaylist'])->name('device.playlist');


/** Авторизация */

Route::get('/login', function () {
    return Inertia::render('Authorize', [
        //'botId' => 7767854254,
        'botId' => 8085189188,
        'failedAuth' => false,
    ]);
})->name('login');

Route::get('login/telegram', [AuthController::class, 'telegram'])->name('login.telegram');
Route::get('login/keycloak', [AuthController::class, 'keycloak'])->name('login.keycloak');
//Route::get('login/telegram/redirect', [AuthController::class, 'telegramRedirect']);

Route::get('/logout', function () {
    if (Auth::check()) {
        Auth::logout();
        return redirect('login');
    }
    else return redirect()->back();
})->name('logout');



/**
 * Сторона администратора
**/
Route::get('/admin',
    function () {
        return Inertia::render('AdminIndex', [
            'playlists' => Playlist::query()->latest()->take(5)->get(),
            'devices' => Device::query()->latest()->take(5)->get()
        ]);
}
)->name('admin')->middleware('auth');

Route::prefix('/admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('playlist', PlaylistController::class);
    Route::resource('device', DeviceController::class);
    Route::resource('group', GroupController::class);
    Route::post('/playlist/{playlist}/file', [UploadFileController::class, 'upload']);
    Route::get('/device/{device}/playlist/attach/{playlist}', [PlaylistController::class, 'attach']);
    Route::get('/device/{device}/playlist/detach', [PlaylistController::class, 'detach']);
    Route::get('/drag', function () {
        return Inertia::render('Drag', [
            'playlists' => Playlist::all(),
            'devices' => Device::query()->where('playlist_id', '=', 'null')->get(),
        ]);
    });
});

Route::resource('file', FileController::class);

// Route::post('/admin/playlists/{playlist}/video', [AdminController::class, 'storeVideo']);


// Route::post('/admin/playlists', [AdminController::class, 'storePlaylist']);
