<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{

    public static function success(mixed $data = null, string $message = 'Success', int $code = 200, mixed $meta = null) : JsonResponse
    {

        $response = [
            'status' => true,
            'message' => $message,
        ];
        if (!is_null($data)) {
            $response['data'] = $data;
        }

        if (!is_null($meta)) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $code);
    }



    public static function error(string $message = 'Faild', int $code = 500, mixed $errors = null)
    {

        $response = [
            'status' => false,
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }


}
