<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Conversions\ConversionCollection;
use Spatie\MediaLibrary\Conversions\Jobs\PerformConversionsJob;

class AdminController extends Controller
{
    public function storeVideo(Request $request, Playlist $playlist)
    {
        $playlist->addMediaFromRequest('video')->toMediaCollection('videos');
        //dispatch(new PerformConversionsJob(new ConversionCollection($playlist->mediaConversions), $playlist->getMedia('videos')->last()));

        return $playlist->mediaConversions;
    }

    public function storePlaylist(Request $request)
    {

    }
}
