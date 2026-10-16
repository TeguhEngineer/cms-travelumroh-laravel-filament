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
     * - ?active=1 (filter by active status)
     * - ?kategori=umroh (filter by category)
     * - ?sort=-created_at (sort descending)
     * - ?sort=urutan (sort ascending, default)
     * - ?per_page=25&page=2 (pagination)
     * - ?with_relations=1 (eager load penerbangan & fasilitas)
     */
    public function index(Request $request)
    {
        $query = Paket::query();

        // Apply filters: ?aktif=1&kategori=umroh
        $this->applyFilters($query, $request, ["aktif", "kategori"]);

        // Apply sorting: ?sort=-created_at or ?sort=urutan
        $this->applySorting($query, $request, "urutan");

        // Eager load relations if requested: ?with_relations=1
        if ($request->input("with_relations")) {
            $query->with(["paketDetails"]);
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

        // Auto-populate relations for detail page
        $query->with(["paketDetails"]);

        $paket = $query->firstOrFail();

        return response()->json([
            "data" => new PaketResource($paket),
            "meta" => [],
        ]);
    }
}
