<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaketFasilitas extends Model
{
    protected $table = 'paket_fasilitas';

    protected $fillable = [
        'paket_id',
        'nama_fasilitas',
        'deskripsi',
        'icon',
    ];

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class);
    }
}
