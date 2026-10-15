<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArtikelResource;
use App\Models\Artikel;
use App\Traits\ApiQueryable;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    use ApiQueryable;
    /**
     * Get all artikels with filters, sorting, and pagination
     *
     * Query params (Laravel style):
     * - ?active=1 (filter by active status)
     * - ?sort=-published_at (sort by published date, descending)
     * - ?per_page=10&page=2 (pagination)
     */
    public function index(Request $request)
    {
        $query = Artikel::query();

        // Apply filters: ?aktif=1
        $this->applyFilters($query, $request, ["aktif"]);

        // Apply sorting: ?sort=-published_at
        $this->applySorting($query, $request, "-published_at");

        // Pagination: ?per_page=10&page=2
        $params = $this->getPaginationParams($request);
        $artikels = $query->paginate($params["per_page"]);

        return response()->json([
            "data" => ArtikelResource::collection($artikels->items()),
            "meta" => [
                "pagination" => [
                    "page" => $artikels->currentPage(),
                    "pageSize" => $artikels->perPage(),
                    "pageCount" => $artikels->lastPage(),
                    "total" => $artikels->total(),
                ],
            ],
        ]);
    }

    /**
     * Get single artikel by slug (auto-increment views)
     */
    public function show(Request $request, string $slug)
    {
        $artikel = Artikel::where("slug", $slug)->firstOrFail();

        // Increment views
        $artikel->increment("views");

        return response()->json([
            "data" => new ArtikelResource($artikel),
            "meta" => [],
        ]);
    }
}
