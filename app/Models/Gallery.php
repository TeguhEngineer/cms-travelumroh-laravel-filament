<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    protected $fillable = [
        "documentId",
        "judul",
        "deskripsi",
        "url_foto",
        "lokasi",
        "aktif",
    ];

    protected $casts = [
        "aktif" => "boolean",
    ];

    // Auto-generate documentId
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            if (empty($gallery->documentId)) {
                $gallery->documentId = "gallery_" . Str::random(20);
            }
        });
    }
}
