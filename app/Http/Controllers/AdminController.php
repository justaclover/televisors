<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function storeVideo(Request $request) {

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
