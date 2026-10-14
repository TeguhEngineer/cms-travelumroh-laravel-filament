<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'documentId' => $this->documentId,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'urlFoto' => $this->url_foto,
            'lokasi' => $this->lokasi,
            'aktif' => $this->aktif,
            'urutan' => $this->urutan,
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}
