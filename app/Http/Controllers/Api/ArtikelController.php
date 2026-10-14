<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArtikelResource;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Get all artikels with filters, sorting, and pagination
     */
    public function index(Request $request)
    {
        $query = Artikel::query();

        // Apply filters
        if ($request->has('filters')) {
            $this->applyFilters($query, $request->input('filters'));
        }

        // Apply sorting (default: latest first)
        if ($request->has('sort')) {
            $this->applySorting($query, $request->input('sort'));
        } else {
            $query->orderBy('published_at', 'desc');
        }

        // Pagination
        $pageSize = min($request->input('pagination.pageSize', 10), 100);
        $artikels = $query->paginate($pageSize);

        return response()->json([
            'data' => ArtikelResource::collection($artikels->items()),
            'meta' => [
                'pagination' => [
                    'page' => $artikels->currentPage(),
                    'pageSize' => $artikels->perPage(),
                    'pageCount' => $artikels->lastPage(),
                    'total' => $artikels->total(),
                ],
            ],
        ]);
    }

    /**
     * Get single artikel by slug (auto-increment views)
     */
    public function show(Request $request, string $slug)
    {
        $artikel = Artikel::where('slug', $slug)->firstOrFail();

        // Increment views
        $artikel->increment('views');

        return response()->json([
            'data' => new ArtikelResource($artikel),
            'meta' => []
        ]);
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, array $filters)
    {
        foreach ($filters as $field => $conditions) {
            if (!is_array($conditions)) continue;

            foreach ($conditions as $operator => $value) {
                match ($operator) {
                    '$eq' => $query->where($field, $value),
                    '$ne' => $query->where($field, '!=', $value),
                    '$contains' => $query->where($field, 'like', "%{$value}%"),
                    '$gt' => $query->where($field, '>', $value),
                    '$gte' => $query->where($field, '>=', $value),
                    '$lt' => $query->where($field, '<', $value),
                    '$lte' => $query->where($field, '<=', $value),
                    default => null
                };
            }
        }
    }

    /**
     * Apply sorting to query
     */
    private function applySorting($query, $sort)
    {
        $sorts = is_array($sort) ? $sort : [$sort];

        foreach ($sorts as $sortItem) {
            if (is_string($sortItem) && str_contains($sortItem, ':')) {
                [$field, $direction] = explode(':', $sortItem);
                $query->orderBy($field, $direction);
            }
        }
    }
}
