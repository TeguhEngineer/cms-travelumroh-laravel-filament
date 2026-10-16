<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    // Detail relations (optional, bisa kosong)
    public function fasilitasDetails()
    {
        return $this->hasMany(PaketFasilitasDetail::class);
    }

    public function hotelDetails()
    {
        return $this->hasMany(PaketHotelDetail::class);
    }

    public function maskapaiDetails()
    {
        return $this->hasMany(PaketMaskapaiDetail::class);
    }

    public function pembimbingDetails()
    {
        return $this->hasMany(PaketPembimbingDetail::class);
    }

    public function perjalananDetails()
    {
        return $this->hasMany(PaketPerjalananDetail::class);
    }

    // Shortcut ke master via detail
    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            "paket_fasilitas_details",
        );
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, "paket_hotel_details");
    }

    public function maskapais()
    {
        return $this->belongsToMany(Maskapai::class, "paket_maskapai_details");
    }

    public function pembimbings()
    {
        return $this->belongsToMany(
            Pembimbing::class,
            "paket_pembimbing_details",
        );
    }

    public function perjalanans()
    {
        return $this->belongsToMany(
            Perjalanan::class,
            "paket_perjalanan_details",
        );
    }

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
