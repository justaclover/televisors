<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Playlist;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use function Pest\Laravel\json;


class DeviceController extends Controller
{
    public function store()
    {
        $tv = Device::query()->create();
        return response()->json(['device_id' => $tv->id]);
    }

    public function getPlaylist(Device $device)
    {
        //return $device->playlist()->exists();
        if ($device->playlist()->exists()) {
            return Inertia::render('ShowVideos', [
                'videos' => $device->playlist()->first()->getMedia('*')
            ]);

//            return response()->json(['videos' => $device->playlist()->first()->getMedia('*')]);
        }
        else {
            return Inertia::render('Index', [
                'readyForVideos' => true
            ]);
        }
    }

    public function index()
    {
        return Inertia::render('Device/DeviceIndex', [
            'items' => Device::all()
        ]);
    }

    public function show(Device $device)
    {
        return Inertia::render('Device/DeviceShow', [
            'device' => $device,
            'playlists' => Playlist::all(),
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

}
