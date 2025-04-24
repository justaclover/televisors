<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends Controller
{
    public function show($uuid)
    {
        $media = Media::where('uuid', $uuid)->firstOrFail();
        return response()->download(storage_path("app/public/" . $media->getPathRelativeToRoot()));
    }

    public function getThumb($uuid)
    {
        $media = Media::where('uuid', $uuid)->firstOrFail();
        return response()->download(storage_path("app/public/" . $media->getPathRelativeToRoot('thumb')));
    }

    public function destroy($uuid)
    {
        $media = Media::where('uuid', $uuid)->firstOrFail();
        $playlist = Playlist::where('id', $media->model_id)->first();

        $media->deleteOrFail();
        $playlist->updateVideoCount();
        return back();
    }
}
