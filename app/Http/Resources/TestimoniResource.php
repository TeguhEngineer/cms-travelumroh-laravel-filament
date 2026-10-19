<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\FileUrl;

class TestimoniResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "documentId" => $this->documentId,
            "nama" => $this->nama,
            "foto" => FileUrl::from($this->foto),
            "isiTestimoni" => $this->isi_testimoni,
            "rating" => $this->rating,
            "paketDiikuti" => $this->paket_diikuti,
            "aktif" => $this->aktif,
            "createdAt" => $this->created_at?->toISOString(),
            "updatedAt" => $this->updated_at?->toISOString(),
        ];
    }
}
