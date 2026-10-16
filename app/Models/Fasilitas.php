<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Fasilitas extends Model
{
    protected $fillable = ["documentId", "nama_fasilitas", "aktif"];

    protected $casts = [
        "aktif" => "boolean",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fasilitas) {
            if (empty($fasilitas->documentId)) {
                $fasilitas->documentId = "fasilitas_" . Str::random(20);
            }
        });
    }

    public function paketDetails()
    {
        return $this->hasMany(PaketDetail::class);
    }
}
