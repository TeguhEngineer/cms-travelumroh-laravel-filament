<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PertanyaanResource;
use App\Models\Pertanyaan;
use App\Traits\ApiQueryable;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    use ApiQueryable;
    /**
     * Get FAQs - query params: ?active=1&sort=urutan&per_page=25
     */
    public function index(Request $request)
    {
        $query = Pertanyaan::query();

        $this->applyFilters($query, $request, ["aktif"]);
        $this->applySorting($query, $request, "urutan");

        $params = $this->getPaginationParams($request);
        $pertanyaans = $query->paginate($params["per_page"]);

        return response()->json([
            "data" => PertanyaanResource::collection($pertanyaans->items()),
            "meta" => [
                "pagination" => [
                    "page" => $pertanyaans->currentPage(),
                    "pageSize" => $pertanyaans->perPage(),
                    "pageCount" => $pertanyaans->lastPage(),
                    "total" => $pertanyaans->total(),
                ],
            ],
        ]);
    }
}
