<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'documentId' => $this->documentId,
            'judul' => $this->judul,
            'urlYoutube' => $this->url_youtube,
            'thumbnail' => $this->thumbnail,
            'deskripsi' => $this->deskripsi,
            'aktif' => $this->aktif,
            'urutan' => $this->urutan,
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}
