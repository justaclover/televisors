<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileController extends Controller
{
    protected function saveFile(UploadedFile $file, Playlist $playlist)
    {
        $playlist->addMedia($file)->toMediaCollection();
//        Cache::forget('video_count' . $playlist->id);
//        Cache::put('video_count' . $playlist->id, $playlist->getMedia('*')->count());
        $playlist->updateVideoCount();
        return Inertia::render('Playlist/PlaylistShow', [
            'playlist' => $playlist,
            'videos' => $playlist->getMedia('*'),
        ]);
    }

    public function upload(Request $request, Playlist $playlist) {
//        $request->validate([
//            'file' => 'required|file|mimes:mp4,webm,mov'
//        ]);
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile(), $playlist);
        }

        // we are in chunk mode, lets send the current progress
//        /** @var AbstractHandler $handler */
//        $handler = $save->handler();

//        return Inertia::render('Playlist/PlaylistShow', [
//            'playlist' => $playlist,
//            'videos' => $playlist->getMedia('*'),
//            "done" => $handler->getPercentageDone()
//        ]);
    }
}
