<?php

namespace App\Traits;

trait CustomResponse {

    public function jsonResponse($success, $status, $code, $payload = [], $message = null){
        return response()->json([
            'success' => $success,
            'status' => $status,
            'message' => $message,
            'payload' => $payload,
        ], $code);
    }
}
