<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Paket extends Model
{
    protected $fillable = [
        'documentId',
        'slug',
        'name',
        'type',
        'description',
        'price',
        'discount_price',
        'tanggal_berangkat',
        'tanggal_pulang',
        'durasi_hari',
        'quota_seat',
        'sisa_seat',
        'kota_keberangkatan',
        'hotel_rating',
        'thumbnail',
        'is_featured',
        'is_promo',
        'aktif',
        'urutan',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'tanggal_berangkat' => 'date',
        'tanggal_pulang' => 'date',
        'is_featured' => 'boolean',
        'is_promo' => 'boolean',
        'aktif' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function penerbangan(): HasMany
    {
        return $this->hasMany(PaketPenerbangan::class);
    }

    public function fasilitas(): HasMany
    {
        return $this->hasMany(PaketFasilitas::class);
    }

    // Auto-generate slug and documentId
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paket) {
            if (empty($paket->slug)) {
                $paket->slug = Str::slug($paket->name);
            }
            if (empty($paket->documentId)) {
                $paket->documentId = 'paket_' . Str::random(20);
            }
        });
    }
}
