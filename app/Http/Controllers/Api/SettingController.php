<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\FileUrl;

class SettingController extends Controller
{
    /**
     * Get settings (single record formatted for Strapi v5 compatibility)
     */
    public function index()
    {
        $settings = Setting::first();

        if (!$settings) {
            return response()->json(
                [
                    "error" => [
                        "status" => 404,
                        "name" => "NotFoundError",
                        "message" => "Settings not configured",
                    ],
                ],
                404,
            );
        }

        return response()->json([
            "data" => [
                "id" => $settings->id,
                "documentId" => "settings_main",
                "company" => [
                    "name" => $settings->company_name,
                    "description" => $settings->company_description,
                    "logoUrl" => FileUrl::from($settings->company_logo),
                    "nomorSkUmroh" => $settings->nomor_sk_umroh,
                    "nomorSkHaji" => $settings->nomor_sk_haji,
                ],
                "contact" => [
                    "telepon1" => $settings->telepon_1,
                    "telepon2" => $settings->telepon_2,
                    "telepon3" => $settings->telepon_3,
                    "telepon4" => $settings->telepon_4,
                    "telepon5" => $settings->telepon_5,
                    "email" => $settings->email,
                    "alamat" => $settings->alamat,
                    "detailAlamat" => $settings->detail_alamat,
                ],
                "socialMedia" => [
                    "whatsapp" => $settings->whatsapp,
                    "facebook" => $settings->facebook,
                    "instagram" => $settings->instagram,
                    "youtube" => $settings->youtube,
                    "tiktok" => $settings->tiktok,
                ],
                "seo" => [
                    "title" => $settings->seo_title,
                    "description" => $settings->seo_description,
                    "keywords" => $settings->seo_keywords,
                ],
                "cover" => [
                    "imageUrl" => FileUrl::from($settings->cover_image),
                    "title" => $settings->cover_title,
                    "subtitle" => $settings->cover_subtitle,
                ],
                "tentangKami" => [
                    "deskripsiPerusahaan" => $settings->deskripsi_perusahaan,
                    "visi" => $settings->visi,
                    "misi" => $settings->misi,
                ],
            ],
            "meta" => [],
        ]);
    }
}
