<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Fasilitas extends Model
{
    protected $fillable = ["documentId", "nama_fasilitas", "kategori", "aktif"];

    protected $casts = [
        "aktif" => "boolean",
        "kategori" => "string",
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

    public function paketFasilitasDetails()
    {
        return $this->hasMany(PaketFasilitasDetail::class);
    }
}
