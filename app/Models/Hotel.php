<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Hotel extends Model
{
    protected $fillable = [
        "documentId",
        "nama_hotel",
        "lokasi",
        "deskripsi_hotel",
        "rating",
        "aktif",
    ];

    protected $casts = [
        "aktif" => "boolean",
        "rating" => "integer",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($hotel) {
            if (empty($hotel->documentId)) {
                $hotel->documentId = "hotel_" . Str::random(20);
            }
        });
    }

    public function paketHotelDetails()
    {
        return $this->hasMany(PaketHotelDetail::class);
    }
}
