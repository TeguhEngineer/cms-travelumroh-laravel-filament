<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketPerjalananDetail extends Model
{
    protected $fillable = ["paket_id", "perjalanan_id", "tanggal"];

    protected $casts = [
        "tanggal" => "date",
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function perjalanan()
    {
        return $this->belongsTo(Perjalanan::class);
    }
}
