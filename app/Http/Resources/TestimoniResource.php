<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimoniResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'documentId' => $this->documentId,
            'nama' => $this->nama,
            'foto' => $this->foto,
            'isiTestimoni' => $this->isi_testimoni,
            'rating' => $this->rating,
            'paketDiikuti' => $this->paket_diikuti,
            'aktif' => $this->aktif,
            'urutan' => $this->urutan,
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}
