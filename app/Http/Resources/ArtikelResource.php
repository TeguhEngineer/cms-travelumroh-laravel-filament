<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\FileUrl;

class ArtikelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "documentId" => $this->documentId,
            "slug" => $this->slug,
            "judul" => $this->judul,
            "konten" => $this->konten,
            "excerpt" => $this->excerpt,
            "thumbnail" => FileUrl::from($this->thumbnail),
            "kategori" => $this->kategori,
            "tags" => $this->tags,
            "views" => $this->views,
            "aktif" => $this->aktif,
            "publishedAt" => $this->published_at?->toISOString(),
            "createdAt" => $this->created_at?->toISOString(),
            "updatedAt" => $this->updated_at?->toISOString(),
        ];
    }
}
