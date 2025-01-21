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
}
