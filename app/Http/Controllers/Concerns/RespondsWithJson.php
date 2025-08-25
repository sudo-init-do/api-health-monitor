<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

trait RespondsWithJson
{
    protected function ok(mixed $data = null): JsonResponse
    {
        return response()->json([
            'status'    => 'success',
            'timestamp' => now()->toIso8601String(),
            'data'      => $data,
        ]);
    }

    protected function created(mixed $data = null): JsonResponse
    {
        return response()->json([
            'status'    => 'success',
            'timestamp' => now()->toIso8601String(),
            'data'      => $data,
        ], 201);
    }

    protected function paginated(LengthAwarePaginator $paginator): JsonResponse
    {
        return response()->json([
            'status'    => 'success',
            'timestamp' => now()->toIso8601String(),
            'data'      => $paginator->items(),
            'meta'      => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
            ],
        ]);
    }
}
