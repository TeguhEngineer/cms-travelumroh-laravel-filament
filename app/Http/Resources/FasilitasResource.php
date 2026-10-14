<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FasilitasResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'namaFasilitas' => $this->nama_fasilitas,
            'deskripsi' => $this->deskripsi,
            'icon' => $this->icon,
        ];
    }
}
