<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "documentId" => $this->documentId,
            "slug" => $this->slug,
            "name" => $this->name,
            "type" => $this->type,
            "description" => $this->description,
            "price" => (float) $this->price,
            "discountPrice" => $this->discount_price
                ? (float) $this->discount_price
                : null,
            "tanggalBerangkat" => $this->tanggal_berangkat?->format("Y-m-d"),
            "tanggalPulang" => $this->tanggal_pulang?->format("Y-m-d"),
            "durasiHari" => $this->durasi_hari,
            "quotaSeat" => $this->quota_seat,
            "sisaSeat" => $this->sisa_seat,
            "kotaKeberangkatan" => $this->kota_keberangkatan,
            "hotelRating" => $this->hotel_rating,
            "thumbnail" => $this->thumbnail,
            "isFeatured" => $this->is_featured,
            "isPromo" => $this->is_promo,
            "aktif" => $this->aktif,
            "penerbangan" => PenerbanganResource::collection(
                $this->whenLoaded("penerbangan"),
            ),
            "fasilitas" => FasilitasResource::collection(
                $this->whenLoaded("fasilitas"),
            ),
            "createdAt" => $this->created_at?->toISOString(),
            "updatedAt" => $this->updated_at?->toISOString(),
            "publishedAt" => $this->published_at?->toISOString(),
        ];
    }
}
