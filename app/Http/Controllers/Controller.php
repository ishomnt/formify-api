<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function responseWithSuccess($data, $message = 'Success', $keyData = 'data', $status = 200)
    {
        return response()->json([
            'message' => $message,
            $keyData => $data,
        ], $status);
    }

    protected function responseWithError($message = 'Error', $status = 400, $errors = null)
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
