<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketMaskapaiDetail extends Model
{
    protected $fillable = [
        "paket_id",
        "maskapai_id",
        "nomor_penerbangan",
        "bandara_keberangkatan",
        "bandara_tujuan",
        "waktu_berangkat",
        "waktu_tiba",
        "tipe_penerbangan",
    ];

    protected $casts = [
        "waktu_berangkat" => "datetime",
        "waktu_tiba" => "datetime",
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function maskapai()
    {
        return $this->belongsTo(Maskapai::class);
    }
}
