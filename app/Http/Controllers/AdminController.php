<?php

namespace App\Http\Controllers;

use App\Jobs\ConvertVideoJob;
use App\Models\Device;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\MediaLibrary\Conversions\ConversionCollection;
use Spatie\MediaLibrary\Conversions\Jobs\PerformConversionsJob;

class AdminController extends Controller
{
    public function storeVideo(Request $request, Playlist $playlist)
    {
        $playlist->addMediaFromRequest('video')->toMediaCollection('videos');
        //dd($playlist->getMedia('videos')->last()->getPath());
        dispatch(new ConvertVideoJob($playlist->getMedia('videos')->last()->getPath(), $playlist->getMedia('videos')->last()->name));

        return "Видед добавлено";
    }

    public function storePlaylist(Request $request)
    {

    }

    public function index()
    {
        return Inertia::render('AdminIndex', [
            'playlists' => Playlist::query()->latest()->take(5)->get(),
            'devices' => Device::query()->latest()->take(5)->get()
        ]);
    }
}
