<?php

namespace App\Traits;

trait ApiResponse {
    protected function success ($data, $msg = null, $code = 200) {
        return response()->json([
            'status' => true,
            'message' => $msg,
            'data' => $data
        ], $code);
    }

    protected function error ($data, $msg = null, $code) {
        return response()->json([
            'status' => false,
            'message' => $msg,
            'data' => $data
        ], $code);
    }
}
