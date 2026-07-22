<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{


    public static function success(mixed $data = null, string $message = '', int $code = 200, mixed $meta = null) : JsonResponse
    {

        $response = [
            'success' => true,
            'message' => $message ?: __('messages.success'),
        ];
        if (!is_null($data)) {
            $response['data'] = $data;
        }

        if (!is_null($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $code);
    }



    public static function error(string $message = '', int $code = 500, mixed $errors = null) : JsonResponse
    {

        $response = [
            'success' => false,
            'message' => $message ?: __('messages.operation_failed'),
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }


}
