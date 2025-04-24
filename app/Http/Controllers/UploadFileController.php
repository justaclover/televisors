<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Inertia\Inertia;
use League\Flysystem\CorruptedPathDetected;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileController extends Controller
{
    protected function saveFile(UploadedFile $file, Playlist $playlist)
    {
        $playlist->addMedia($file)->toMediaCollection();
        $playlist->updateVideoCount();
        return redirect(route('admin.playlist.show', ['playlist' => $playlist]));
    }

    public function upload(Request $request, Playlist $playlist) {
        if (preg_match('/[\p{Cyrillic}]/u', $request->resumableFilename)){
            return response()->json([
                'new_filename' => $this->generateSafeFilename($request->resumableType), // Отправляем новое имя на фронтенд
            ], 422);
        }

        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

            // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

            // receive the file ТУТ ОШИБКА С ИМЕНЕМ ФАЙЛА ВОЗНИКАЕТ
        try{
            $save = $receiver->receive();

            if ($save->isFinished()) {
                // save the file and return any response you need, current example uses `move` function. If you are
                // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
                return $this->saveFile($save->getFile(), $playlist);
//                return response()->json([
//                    'file' => $save->getFile(),
//                ]);
            }
        }
        catch (FileException $e) {
            //return $this->retryUploadWithNewName($request, $playlist);
            return response()->json([
                'new_filename' => $this->generateSafeFilename($request->resumableType), // Отправляем новое имя на фронтенд
            ], 422);
        }
        catch (CorruptedPathDetected $e) {
            return response()->json([
                'new_filename' => $this->generateSafeFilename($request->resumableType), // Отправляем новое имя на фронтенд
            ], 422);
        }

    }

    protected function generateSafeFilename($resumableType)
    {
        $mimetype = explode('/', $resumableType)[1];
        // Генерируем имя файла на основе текущей даты и случайной строки
        return Carbon::now()->format('Y-m-d_H-i-s') . '_' . Str::random(8) . '.' . $mimetype;
        //return strval(rand(12, 132445));
    }
}
