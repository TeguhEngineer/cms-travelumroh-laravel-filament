<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TrustBar extends Model
{
    protected $fillable = [
        "documentId",
        "judul",
        "deskripsi",
        "ikon",
        "aktif",
        "urutan",
    ];

    protected $casts = [
        "aktif" => "boolean",
        "urutan" => "integer",
    ];

    // Auto-generate documentId
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trustBar) {
            if (empty($trustBar->documentId)) {
                $trustBar->documentId = "trustbar_" . Str::random(20);
            }
        });
    }
}
