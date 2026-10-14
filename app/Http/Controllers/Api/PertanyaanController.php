<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PertanyaanResource;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pertanyaan::query();

        if ($request->has('filters')) {
            $this->applyFilters($query, $request->input('filters'));
        }

        if ($request->has('sort')) {
            $this->applySorting($query, $request->input('sort'));
        } else {
            $query->orderBy('urutan', 'asc');
        }

        $pageSize = min($request->input('pagination.pageSize', 25), 100);
        $pertanyaans = $query->paginate($pageSize);

        return response()->json([
            'data' => PertanyaanResource::collection($pertanyaans->items()),
            'meta' => [
                'pagination' => [
                    'page' => $pertanyaans->currentPage(),
                    'pageSize' => $pertanyaans->perPage(),
                    'pageCount' => $pertanyaans->lastPage(),
                    'total' => $pertanyaans->total(),
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
