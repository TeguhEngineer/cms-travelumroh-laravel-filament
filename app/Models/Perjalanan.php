<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Perjalanan extends Model
{
    protected $fillable = [
        "documentId",
        "lokasi_perjalanan",
        "deskripsi",
        "aktif",
    ];

    protected $casts = [
        "aktif" => "boolean",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($perjalanan) {
            if (empty($perjalanan->documentId)) {
                $perjalanan->documentId = "perjalanan_" . Str::random(20);
            }
        });
    }

    public function paketPerjalananDetails()
    {
        return $this->hasMany(PaketPerjalananDetail::class);
    }
}
