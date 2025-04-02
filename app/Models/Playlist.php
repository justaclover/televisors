<?php

namespace App\Models;

use FFMpeg\FFMpeg;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


/**
 * @property int $id
 * @property string $name
 * @property string $comment
 * **/
class Playlist extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'comment'
    ];

    protected $appends = [
        'video_count',
        'devices_array'
    ];

    public function getVideoCountAttribute()
    {
        return Cache::remember('video_count' . $this->id, 3600, function () {
            return $this->getMedia('*')->count();
        });
    }

    public function getDevicesArrayAttribute()
    {
        return $this->devices();
    }

    public function updateVideoCount()
    {
        Cache::forget('video_count' . $this->id);
        Cache::put('video_count' . $this->id, $this->getMedia('*')->count());
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    //    public function registerMediaConversions(?Media $media = null): void
//    {
//        $this->addMediaConversion('compress')
//            ->width(368)
//            ->height(232)
//            ->format('webm');
//    }
}
