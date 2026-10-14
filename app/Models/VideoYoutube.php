<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VideoYoutube extends Model
{
    protected $fillable = [
        'documentId',
        'judul',
        'url_youtube',
        'thumbnail',
        'deskripsi',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    // Auto-generate documentId
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($video) {
            if (empty($video->documentId)) {
                $video->documentId = 'video_' . Str::random(20);
            }
        });
    }
}
