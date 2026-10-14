<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'company_description',
        'company_logo',
        'nomor_sk_umroh',
        'nomor_sk_haji',
        'telepon_1',
        'telepon_2',
        'telepon_3',
        'telepon_4',
        'telepon_5',
        'email',
        'alamat',
        'detail_alamat',
        'whatsapp',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'cover_image',
        'cover_title',
        'cover_subtitle',
        'deskripsi_perusahaan',
        'visi',
        'misi',
    ];
}
