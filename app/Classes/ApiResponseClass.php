<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{

    public static function rollback($e, $message = "Something went wrong! Process not completed"): void
    {
        DB::rollBack();
        self::throw($e, $message);
//        return false;
    }

    public static function throw($e, $message = "Something went wrong! Process not completed"): HttpResponseException
    {
        Log::info($e);
        // HttpResponseException from http.php
//        throw new \HttpResponseException(response()->json(["message" => $message], 500));
        throw new HttpResponseException(response()->json(["message" => $message], 500));
    }

    public static function sendResponse($result, $message, $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }

    public static function sendFail(string $message, int $code = 400): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message
        ];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }
}
