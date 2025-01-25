<?php

namespace App\Jobs;

use FFMpeg\Coordinate\Dimension;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\WebM;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ConvertVideoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public String $path, public String $name)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ffmpeg = FFMpeg::create(['']);
        $video = $ffmpeg->open($this->path);
        $video->filters()
            ->resize(new Dimension(320, 240))
            ->synchronize();
        $video->save(new WebM(), $this->name . '.webm');
    }
}
