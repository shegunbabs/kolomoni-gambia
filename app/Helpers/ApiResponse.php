<?php


namespace App\Helpers;


use Illuminate\Http\JsonResponse;

class ApiResponse
{

    public static function success($message = '', $data = [], $renameDataTo = 'data', $showEmptyData = false): JsonResponse {
        $response_array = ['status' => 'success'];
        $message ? $response_array['message'] = $message : '';

        if ( !empty($data) || ( empty($data) && $showEmptyData === true ) ) {
            $response_array[$renameDataTo] = $data;
        }

        return response()->json($response_array);
    }


    public static function failed($message = '', $data = [], $renameDataTo = 'data', $statusCode = 200): JsonResponse {
        $response_array = ['status' => 'failed',];
        $message ? $response_array['message'] = $message : '';
        $data ? $response_array[$renameDataTo] = $data : '';

        return response()->json($response_array, $statusCode);
    }


    public static function pending($message = ''): JsonResponse
    {
        return response()->json([
            'status' => 'pending',
            'message' => $message
        ]);
    }
}
