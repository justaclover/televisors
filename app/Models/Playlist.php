<?php

namespace App\Models;

use FFMpeg\FFMpeg;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Playlist extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'comment'
    ];

    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }

//    public function registerMediaConversions(?Media $media = null): void
//    {
//        $this->addMediaConversion('compress')
//            ->width(368)
//            ->height(232)
//            ->format('webm');
//    }
}
