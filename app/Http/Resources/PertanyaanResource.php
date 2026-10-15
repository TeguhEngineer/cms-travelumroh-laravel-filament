<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PertanyaanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "documentId" => $this->documentId,
            "pertanyaan" => $this->pertanyaan,
            "jawaban" => $this->jawaban,
            "kategori" => $this->kategori,
            "aktif" => $this->aktif,
            "createdAt" => $this->created_at?->toISOString(),
            "updatedAt" => $this->updated_at?->toISOString(),
        ];
    }
}
