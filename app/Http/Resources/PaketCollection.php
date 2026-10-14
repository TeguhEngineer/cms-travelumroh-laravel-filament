<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaketCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'pagination' => [
                    'page' => $this->currentPage(),
                    'pageSize' => $this->perPage(),
                    'pageCount' => $this->lastPage(),
                    'total' => $this->total(),
                ],
            ],
        ];
    }
}
