<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\VideoYoutube;
use App\Traits\ApiQueryable;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use ApiQueryable;
    /**
     * Get YouTube videos - query params: ?active=1&sort=urutan&per_page=10
     */
    public function index(Request $request)
    {
        $query = VideoYoutube::query();

        $this->applyFilters($query, $request, ["aktif"]);
        $this->applySorting($query, $request, "-created_at");

        $params = $this->getPaginationParams($request);
        $videos = $query->paginate($params["per_page"]);

        return response()->json([
            "data" => VideoResource::collection($videos->items()),
            "meta" => [
                "pagination" => [
                    "page" => $videos->currentPage(),
                    "pageSize" => $videos->perPage(),
                    "pageCount" => $videos->lastPage(),
                    "total" => $videos->total(),
                ],
            ],
        ]);
    }
}
