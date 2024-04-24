<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
    protected function successResponse(mixed $data, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse(string $message = null, int $code = 500): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], $code < 300 ? 500 : $code);
    }

    protected function emptyResponse(): JsonResponse
    {
        return response()->json([
        ], 204);
    }

    public function paginate($resourceClass, LengthAwarePaginator $paginator): array
    {
        return [
            'items' => $resourceClass::collection($paginator->items()),
            'pagination' => [
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'current' => $paginator->currentPage(),
                'last' => $paginator->lastPage(),
                'total' => $paginator->total(),
                'limit' => $paginator->perPage(),
            ],
        ];
    }

    protected function successWithoutWrap(mixed $data, int $code = 200): JsonResponse
    {
        return response()->json($data, $code);
    }

}
