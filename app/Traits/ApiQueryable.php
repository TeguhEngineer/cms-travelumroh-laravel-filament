<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait ApiQueryable
{
    /**
     * Apply filters from query params
     *
     * Usage: ?active=1&category=umroh
     */
    protected function applyFilters(Builder $query, Request $request, array $allowedFilters = []): void
    {
        if (empty($allowedFilters)) {
            return;
        }

        foreach ($allowedFilters as $filter) {
            if ($request->has($filter)) {
                $value = $request->input($filter);

                // Handle boolean values
                if ($value === 'true' || $value === '1') {
                    $value = true;
                } elseif ($value === 'false' || $value === '0') {
                    $value = false;
                }

                $query->where($filter, $value);
            }
        }
    }

    /**
     * Apply sorting from query params
     *
     * Usage: ?sort=-created_at (descending) or ?sort=created_at (ascending)
     */
    protected function applySorting(Builder $query, Request $request, string $defaultSort = 'created_at'): void
    {
        $sort = $request->input('sort', $defaultSort);

        if (str_starts_with($sort, '-')) {
            $field = substr($sort, 1);
            $direction = 'desc';
        } else {
            $field = $sort;
            $direction = 'asc';
        }

        $query->orderBy($field, $direction);
    }

    /**
     * Get pagination settings from request
     */
    protected function getPaginationParams(Request $request): array
    {
        return [
            'per_page' => min((int) $request->input('per_page', 25), 100),
            'page' => (int) $request->input('page', 1),
        ];
    }
}
