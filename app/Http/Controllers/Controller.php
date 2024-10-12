<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success($data = null, $statusCode = 200): JsonResponse
    {
        return \response()->json(['data' => $data], $statusCode);
    }

    public function error(string $error = "Something went wrong!", string $code = 'data.invalid', int $statusCode = 500): JsonResponse
    {
        $error = [
            'code' => $code,
            'message' => $error
        ];
        return \response()->json(['error' => $error], $statusCode);
    }
}