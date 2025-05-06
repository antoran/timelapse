<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = [
        'name',
        'rtsp_url',
    ];

    public function images()
    {
        return $this->hasMany(FeedImage::class);
    }
}
