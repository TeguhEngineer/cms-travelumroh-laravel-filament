<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenerbanganResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nomorPenerbangan' => $this->nomor_penerbangan,
            'namaMaskapai' => $this->nama_maskapai,
            'bandaraKeberangkatan' => $this->bandara_keberangkatan,
            'bandaraTujuan' => $this->bandara_tujuan,
            'tanggalKeberangkatan' => $this->tanggal_keberangkatan?->toISOString(),
            'tanggalTiba' => $this->tanggal_tiba?->toISOString(),
        ];
    }
}
