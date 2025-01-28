<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use function Pest\Laravel\json;


class TVController extends Controller
{
    public function store()
    {
        $tv = Device::query()->create();
        return response()->json(['device_id' => $tv->id]);
    }

    public function getPlaylist(Device $televisor)
    {
        return response()->json(['ready' => false]);
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
            'device' => $device
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
