<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FeedVideo extends Model
{
    protected $fillable = [
        'feed_id',
        'disk',
        'path',
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function videoUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Storage::disk($attributes['disk'])->url($attributes['path'])
        );
    }
}
