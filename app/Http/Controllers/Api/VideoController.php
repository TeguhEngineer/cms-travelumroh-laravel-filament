<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\VideoYoutube;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = VideoYoutube::query();

        if ($request->has('filters')) {
            $this->applyFilters($query, $request->input('filters'));
        }

        if ($request->has('sort')) {
            $this->applySorting($query, $request->input('sort'));
        } else {
            $query->orderBy('urutan', 'asc');
        }

        $pageSize = min($request->input('pagination.pageSize', 10), 100);
        $videos = $query->paginate($pageSize);

        return response()->json([
            'data' => VideoResource::collection($videos->items()),
            'meta' => [
                'pagination' => [
                    'page' => $videos->currentPage(),
                    'pageSize' => $videos->perPage(),
                    'pageCount' => $videos->lastPage(),
                    'total' => $videos->total(),
                ],
            ],
        ]);
    }

    private function applyFilters($query, array $filters)
    {
        foreach ($filters as $field => $conditions) {
            if (!is_array($conditions)) continue;

            foreach ($conditions as $operator => $value) {
                match ($operator) {
                    '$eq' => $query->where($field, $value),
                    '$ne' => $query->where($field, '!=', $value),
                    default => null
                };
            }
        }
    }

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
