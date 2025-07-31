<?php

namespace App\Http\Utilitis;
class RespuestasApi
{
    public static function success($data, $message = 'Operation successful', $status = true, $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public static function error($message = 'Operation failed', $status = false, $code = 400)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => null
        ], $code);
    }
    public static function notFound($message = 'Resource not found', $status = false, $code = 404)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => null
        ], $code);
    }

}