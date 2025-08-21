<?php

namespace App\Http\Utilitis;

use Illuminate\Http\JsonResponse;

class RespuestasApi
{
    public static function success(mixed $data, string $message = 'Operation successful', bool $status = true, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public static function error($message = 'Operation failed', $status = false, $code = 400): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => null
        ], $code);
    }
    public static function notFound($message = 'Resource not found', $status = false, $code = 404): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => null
        ], $code);
    }

    public static function withTokenResponse(mixed $data, string $message = 'Operation successful', bool $status = true, int $code = 200, ?string $token = null): JsonResponse

    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'token' => $token
        ], $code);
    }

}