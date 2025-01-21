<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileController extends Controller
{
    public function show($uuid)
    {
        $media = Media::where('uuid', $uuid)->firstOrFail();
        return response()->download(storage_path("app/public/" . $media->getPathRelativeToRoot()));
    }

    public function destroy($uuid)
    {
        $media = Media::where('uuid', $uuid)->firstOrFail();
        $media->deleteOrFail();
        return back();
    }
}
