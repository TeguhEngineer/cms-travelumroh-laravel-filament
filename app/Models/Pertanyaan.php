<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pertanyaan extends Model
{
    protected $fillable = [
        'documentId',
        'pertanyaan',
        'jawaban',
        'kategori',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    // Auto-generate documentId
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pertanyaan) {
            if (empty($pertanyaan->documentId)) {
                $pertanyaan->documentId = 'faq_' . Str::random(20);
            }
        });
    }
}
