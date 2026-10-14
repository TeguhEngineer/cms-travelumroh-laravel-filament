<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    protected $fillable = [
        'documentId',
        'slug',
        'judul',
        'konten',
        'excerpt',
        'thumbnail',
        'kategori',
        'tags',
        'views',
        'aktif',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'views' => 'integer',
        'aktif' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Auto-generate slug and documentId
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artikel) {
            if (empty($artikel->slug)) {
                $artikel->slug = Str::slug($artikel->judul);
            }
            if (empty($artikel->documentId)) {
                $artikel->documentId = 'artikel_' . Str::random(20);
            }
        });
    }
}
