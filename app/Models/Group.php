<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $fillable = [
        'name',
        'comment',
        'playlist_id'
    ];

    public function playlist(): HasMany
    {
        return $this->hasMany(Playlist::class, 'id', 'playlist_id');
    }
}
