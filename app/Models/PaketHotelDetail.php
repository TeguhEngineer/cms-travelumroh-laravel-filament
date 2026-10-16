<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketHotelDetail extends Model
{
    protected $fillable = ["paket_id", "hotel_id", "checkin", "checkout"];

    protected $casts = [
        "checkin" => "date",
        "checkout" => "date",
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
