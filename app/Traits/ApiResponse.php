<?php

namespace App\Traits;

trait ApiResponse
{
    protected function success($message = '', $data = null, $code = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
        ], $code);
    }

    protected function error($message = '', $data = null, $code = 400)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
        ], $code);
    }
}
