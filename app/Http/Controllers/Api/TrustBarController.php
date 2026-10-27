<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TrustBarResource;
use App\Models\TrustBar;
use App\Traits\ApiQueryable;
use Illuminate\Http\Request;

class TrustBarController extends Controller
{
    use ApiQueryable;

    /**
     * Get trust bar items - query params: ?aktif=1&sort=urutan&per_page=10
     */
    public function index(Request $request)
    {
        $query = TrustBar::query();

        $this->applyFilters($query, $request, ["aktif"]);
        $this->applySorting($query, $request, "urutan");

        // Stable order when several items share the same "urutan"
        $query->orderBy("id");

        $params = $this->getPaginationParams($request);
        $trustBars = $query->paginate($params["per_page"]);

        return response()->json([
            "data" => TrustBarResource::collection($trustBars->items()),
            "meta" => [
                "pagination" => [
                    "page" => $trustBars->currentPage(),
                    "pageSize" => $trustBars->perPage(),
                    "pageCount" => $trustBars->lastPage(),
                    "total" => $trustBars->total(),
                ],
            ],
        ]);
    }
}
