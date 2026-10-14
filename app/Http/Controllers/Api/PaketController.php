<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaketResource;
use App\Http\Resources\PaketCollection;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    /**
     * Get all pakets with filters, sorting, and pagination
     */
    public function index(Request $request)
    {
        $query = Paket::query();

        // Apply filters
        if ($request->has('filters')) {
            $this->applyFilters($query, $request->input('filters'));
        }

        // Apply sorting
        if ($request->has('sort')) {
            $this->applySorting($query, $request->input('sort'));
        } else {
            $query->orderBy('urutan', 'asc');
        }

        // Populate relations if requested
        if ($request->input('populate') === '*') {
            $query->with(['penerbangan', 'fasilitas']);
        }

        // Pagination
        $pageSize = min($request->input('pagination.pageSize', 25), 100);
        $pakets = $query->paginate($pageSize);

        return new PaketCollection($pakets);
    }

    /**
     * Get single paket by slug
     */
    public function show(Request $request, string $slug)
    {
        $query = Paket::where('slug', $slug);

        // Auto-populate relations for detail page
        $query->with(['penerbangan', 'fasilitas']);

        $paket = $query->firstOrFail();

        return response()->json([
            'data' => new PaketResource($paket),
            'meta' => []
        ]);
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, array $filters)
    {
        foreach ($filters as $field => $conditions) {
            if (!is_array($conditions)) {
                continue;
            }

            foreach ($conditions as $operator => $value) {
                switch ($operator) {
                    case '$eq':
                        $query->where($field, $value);
                        break;
                    case '$ne':
                        $query->where($field, '!=', $value);
                        break;
                    case '$contains':
                        $query->where($field, 'like', "%{$value}%");
                        break;
                    case '$gt':
                        $query->where($field, '>', $value);
                        break;
                    case '$gte':
                        $query->where($field, '>=', $value);
                        break;
                    case '$lt':
                        $query->where($field, '<', $value);
                        break;
                    case '$lte':
                        $query->where($field, '<=', $value);
                        break;
                }
            }
        }
    }

    /**
     * Apply sorting to query
     */
    private function applySorting($query, $sort)
    {
        if (is_string($sort)) {
            // Single sort: "field:asc" or "field:desc"
            if (str_contains($sort, ':')) {
                [$field, $direction] = explode(':', $sort);
                $query->orderBy($field, $direction);
            }
        } elseif (is_array($sort)) {
            // Multiple sorts
            foreach ($sort as $sortItem) {
                if (is_string($sortItem) && str_contains($sortItem, ':')) {
                    [$field, $direction] = explode(':', $sortItem);
                    $query->orderBy($field, $direction);
                }
            }
        }
    }
}
