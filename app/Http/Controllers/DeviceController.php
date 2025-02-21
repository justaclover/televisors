<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Playlist;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function Pest\Laravel\json;


class DeviceController extends Controller
{
    public function store()
    {
        $tv = Device::query()->create();
        return response()->json(['device_id' => $tv->id]);
    }

    // public function getPlaylist(Device $device)
    // {
    //     if ($device->playlist()->exists()){
    //         if (count($device->playlist()->first()->getMedia('*')) !== 0) {
    //             return Inertia::render('ShowVideos', [
    //                 'videos' => $device->playlist()->first()->getMedia('*')
    //             ]);
    //         }
    //     }
    //     return Inertia::render('Index', [
    //         'readyForVideos' => true
    //     ]);
    // }

    public function index()
    {
        return Inertia::render('Device/DeviceIndex', [
            'items' => Device::all()
        ]);
    }

    public function show(Device $device)
    {
        if ($device->playlist()->exists()) {
            $videos = $device->playlist()->first()->getMedia('*');
        } else {
            $videos = null;
        }
        return Inertia::render('Device/DeviceShow', [
            'device' => $device,
            'playlists' => Playlist::all(),
            'videos' => $videos,
            'currentPlaylist' => $device->playlist()->first()
        ]);
    }

    public function update(Request $request, Device $device)
    {
        $device->update([
            'name' => $request->name,
            'comment' => $request->comment,
            'location' => $request->location
        ]);

        response()->json([
            'device' => [
                'name' => $device->name,
                'password' => $device->password,
                'location' => $device->location
            ]
        ]);
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return back();
    }

}
