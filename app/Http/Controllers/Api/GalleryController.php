<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use App\Traits\ApiQueryable;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    use ApiQueryable;
    /**
     * Get all galleries with filters, sorting, and pagination
     *
     * Query params: ?active=1&sort=urutan&per_page=20
     */
    public function index(Request $request)
    {
        $query = Gallery::query();

        $this->applyFilters($query, $request, ["aktif"]);
        $this->applySorting($query, $request, "urutan");

        $params = $this->getPaginationParams($request);
        $galleries = $query->paginate($params["per_page"]);

        return response()->json([
            "data" => GalleryResource::collection($galleries->items()),
            "meta" => [
                "pagination" => [
                    "page" => $galleries->currentPage(),
                    "pageSize" => $galleries->perPage(),
                    "pageCount" => $galleries->lastPage(),
                    "total" => $galleries->total(),
                ],
            ],
        ]);
    }
}
