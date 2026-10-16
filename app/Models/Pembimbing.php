<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pembimbing extends Model
{
    protected $fillable = [
        "documentId",
        "nama_pembimbing",
        "kategori",
        "aktif",
    ];

    protected $casts = [
        "aktif" => "boolean",
        "kategori" => "string",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pembimbing) {
            if (empty($pembimbing->documentId)) {
                $pembimbing->documentId = "pembimbing_" . Str::random(20);
            }
        });
    }

    public function paketDetails()
    {
        return $this->hasMany(PaketDetail::class);
    }
}
