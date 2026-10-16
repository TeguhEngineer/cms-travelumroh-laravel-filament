<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketPembimbingDetail extends Model
{
    protected $fillable = ["paket_id", "pembimbing_id"];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class);
    }
}
