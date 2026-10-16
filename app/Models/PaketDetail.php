<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketDetail extends Model
{
    protected $fillable = [
        "paket_id",
        "fasilitas_id",
        "hotel_id",
        "maskapai_id",
        "pembimbing_id",
        "perjalanan_id",
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function maskapai()
    {
        return $this->belongsTo(Maskapai::class);
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class);
    }

    public function perjalanan()
    {
        return $this->belongsTo(Perjalanan::class);
    }
}
