<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimoniResource;
use App\Models\Testimoni;
use App\Traits\ApiQueryable;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    use ApiQueryable;
    /**
     * Get all testimonials - query params: ?active=1&sort=urutan&per_page=10
     */
    public function index(Request $request)
    {
        $query = Testimoni::query();

        $this->applyFilters($query, $request, ["aktif"]);
        $this->applySorting($query, $request, "-created_at");

        $params = $this->getPaginationParams($request);
        $testimonis = $query->paginate($params["per_page"]);

        return response()->json([
            "data" => TestimoniResource::collection($testimonis->items()),
            "meta" => [
                "pagination" => [
                    "page" => $testimonis->currentPage(),
                    "pageSize" => $testimonis->perPage(),
                    "pageCount" => $testimonis->lastPage(),
                    "total" => $testimonis->total(),
                ],
            ],
        ]);
    }
}
