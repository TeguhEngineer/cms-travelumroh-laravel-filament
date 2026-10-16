<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Maskapai extends Model
{
    protected $fillable = [
        "documentId",
        "nama_maskapai",
        "keterangan",
        "aktif",
    ];

    protected $casts = [
        "aktif" => "boolean",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($maskapai) {
            if (empty($maskapai->documentId)) {
                $maskapai->documentId = "maskapai_" . Str::random(20);
            }
        });
    }

    public function paketDetails()
    {
        return $this->hasMany(PaketDetail::class);
    }
}
