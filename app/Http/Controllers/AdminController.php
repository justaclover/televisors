<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function storeVideo(Request $request, Playlist $playlist) {
        $playlist->addMediaFromRequest('video')->toMediaCollection('videos');
        return "Видео добавлено";
    }

    public function storePlaylist(Request $request) {
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
}
