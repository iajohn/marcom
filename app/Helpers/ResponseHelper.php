<?php

namespace App\Helpers;

class ResponseHelper
{
    public function successResponse($success, $message, $data, $code)
    {
        return response()->json([
            'data' => [
                'success' => $success,
                'message' => $message,
                'data'    => $data,
            ]
        ], $code);
    }

    public function errorResponse($success, $message, $code)
    {
        return response()->json([
            'data' => [
                'error' => [
                    'success' => $success,
                    'message' => $message
                ]
            ]
        ], $code);
    }
}
