<?php

namespace App\Models;

use App\Models\Feed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FeedImage extends Model
{
    protected $fillable = [
        'feed_id',
        'disk',
        'path',
        'image_taken_at',
    ];

    protected function casts(): array
    {
        return [
            'image_taken_at' => 'datetime',
        ];
    }
    
    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Storage::disk($attributes['disk'])->url($attributes['path'])
        );
    }
}
