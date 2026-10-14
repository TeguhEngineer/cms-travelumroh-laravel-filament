<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaketPenerbangan extends Model
{
    protected $table = 'paket_penerbangan';

    protected $fillable = [
        'paket_id',
        'nomor_penerbangan',
        'nama_maskapai',
        'bandara_keberangkatan',
        'bandara_tujuan',
        'tanggal_keberangkatan',
        'tanggal_tiba',
    ];

    protected $casts = [
        'tanggal_keberangkatan' => 'datetime',
        'tanggal_tiba' => 'datetime',
    ];

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class);
    }
}
