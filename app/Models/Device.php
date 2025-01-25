<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $fillable = [
        'name',
        'comment',
        'location',
        'playlist_id'
    ];
}
