<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlaylistResource;
use App\Models\Device;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return Inertia::render('Playlist/PlaylistIndex', [
            'items' => Playlist::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $playlist = Playlist::query()->create([
            'name' => $request->name,
            'comment' => $request->comment
        ]);

        return response()->json([
            'playlist' => [
                'id' => $playlist->id,
                'name' => $playlist->name,
                'comment' => $playlist->comment,
            ]
        ]);
    }

    public function upload(Request $request, Playlist $playlist)
    {
        $request->validate([
            'file' => 'required|file|mimes:mp4,webm,mov'
        ]);
        $playlist->addMediaFromRequest('file')->toMediaCollection();
//        Cache::forget('video_count' . $playlist->id);
//        Cache::put('video_count' . $playlist->id, $playlist->getMedia('*')->count());
        $playlist->updateVideoCount();
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        return Inertia::render('Playlist/PlaylistShow', [
            'playlist' => $playlist,
            'videos' => $playlist->getMedia('*')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Playlist $playlist)
    {
        $playlist->update([
            'name' => $request->name,
            'comment' => $request->comment,
        ]);

        response()->json([
            'device' => [
                'name' => $playlist->name,
                'password' => $playlist->password,
            ]
        ]);
    }

    public function destroy(Playlist $playlist)
    {
        $playlist->getMedia()->each(function (Media $media) {
            $media->delete();
        });

        Cache::forget('video_count' . $playlist->id);
        $playlist->delete();
        return back();
    }

    public function attach(Device $device, Playlist $playlist)
    {
        $device->update([
            'playlist_id' => $playlist->id
        ]);

        return response()->json([
            "playlist" => $device->playlist()->first(),
        ]);
    }

    public function detach(Device $device)
    {
        $device->update([
            'playlist_id' => null
        ]);

        return response()->json([
            $device->playlist_id
        ]);
    }
}
