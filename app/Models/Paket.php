<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Paket extends Model
{
    protected $fillable = [
        "documentId",
        "slug",
        "name",
        "type",
        "description",
        "price",
        "discount_price",
        "tanggal_berangkat",
        "tanggal_pulang",
        "durasi_hari",
        "quota_seat",
        "sisa_seat",
        "kota_keberangkatan",
        "hotel_rating",
        "thumbnail",
        "is_featured",
        "is_promo",
        "aktif",
        "published_at",
    ];

    protected $casts = [
        "price" => "decimal:2",
        "discount_price" => "decimal:2",
        "tanggal_berangkat" => "date",
        "tanggal_pulang" => "date",
        "is_featured" => "boolean",
        "is_promo" => "boolean",
        "aktif" => "boolean",
        "published_at" => "datetime",
    ];

    // Relationships
    public function paketDetails()
    {
        return $this->hasMany(PaketDetail::class);
    }

    // Helper methods to get related master data through paketDetails
    public function fasilitas()
    {
        return $this->hasManyThrough(
            Fasilitas::class,
            PaketDetail::class,
            "paket_id",
            "id",
            "id",
            "fasilitas_id",
        );
    }

    public function hotels()
    {
        return $this->hasManyThrough(
            Hotel::class,
            PaketDetail::class,
            "paket_id",
            "id",
            "id",
            "hotel_id",
        );
    }

    public function maskapais()
    {
        return $this->hasManyThrough(
            Maskapai::class,
            PaketDetail::class,
            "paket_id",
            "id",
            "id",
            "maskapai_id",
        );
    }

    public function pembimbings()
    {
        return $this->hasManyThrough(
            Pembimbing::class,
            PaketDetail::class,
            "paket_id",
            "id",
            "id",
            "pembimbing_id",
        );
    }

    public function perjalanans()
    {
        return $this->hasManyThrough(
            Perjalanan::class,
            PaketDetail::class,
            "paket_id",
            "id",
            "id",
            "perjalanan_id",
        );
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
                $paket->documentId = "paket_" . Str::random(20);
            }
        });
    }
}
