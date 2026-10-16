<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketFasilitasDetail extends Model
{
    protected $fillable = ["paket_id", "fasilitas_id"];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }
}
