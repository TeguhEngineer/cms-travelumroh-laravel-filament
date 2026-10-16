<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaketResource;
use App\Http\Resources\PaketCollection;
use App\Models\Paket;
use App\Traits\ApiQueryable;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    use ApiQueryable;
    /**
     * Get all pakets with filters, sorting, and pagination
     *
     * Query params (Laravel style):
     * - ?aktif=1 (filter by active status)
     * - ?type=umrah (filter by package type)
     * - ?sort=-created_at (sort descending)
     * - ?per_page=25&page=2 (pagination)
     * - ?with_relations=1 (eager load all detail relations)
     */
    public function index(Request $request)
    {
        $query = Paket::query();

        // Apply filters: ?aktif=1&type=umrah
        $this->applyFilters($query, $request, ["aktif", "type"]);

        // Apply sorting: ?sort=-created_at
        $this->applySorting($query, $request, "-created_at");

        // Eager load relations if requested: ?with_relations=1
        if ($request->input("with_relations")) {
            $query->with([
                "fasilitasDetails.fasilitas",
                "hotelDetails.hotel",
                "maskapaiDetails.maskapai",
                "pembimbingDetails.pembimbing",
                "perjalananDetails.perjalanan",
            ]);
        }

        // Pagination: ?per_page=25&page=2
        $params = $this->getPaginationParams($request);
        $pakets = $query->paginate($params["per_page"]);

        return new PaketCollection($pakets);
    }

    /**
     * Get single paket by slug
     */
    public function show(Request $request, string $slug)
    {
        $query = Paket::where("slug", $slug);

        // Auto-populate all detail relations for detail page
        $query->with([
            "fasilitasDetails.fasilitas",
            "hotelDetails.hotel",
            "maskapaiDetails.maskapai",
            "pembimbingDetails.pembimbing",
            "perjalananDetails.perjalanan",
        ]);

        $paket = $query->firstOrFail();

        return response()->json([
            "data" => new PaketResource($paket),
            "meta" => [],
        ]);
    }
}
