<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Testimoni extends Model
{
    protected $fillable = [
        "documentId",
        "nama",
        "foto",
        "isi_testimoni",
        "rating",
        "paket_diikuti",
        "aktif",
    ];

    protected $casts = [
        "rating" => "integer",
        "aktif" => "boolean",
    ];

    // Auto-generate documentId
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($testimoni) {
            if (empty($testimoni->documentId)) {
                $testimoni->documentId = "testimoni_" . Str::random(20);
            }
        });
    }
}
