<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{

    protected function successResponse($data = null, string $message = 'Successfully retrieved', int $statusCode = 200)
    {
        return response()->json([
                                'success' => true,
                                'message' => $message,
                                'data' => $data,
                            ], $statusCode);
    }
    
    protected function errorResponse(array $errors = [], string $message = 'Something went wrong!', int $statusCode = 400)
    {
        return response()->json([
                                'success' => false,
                                'message' => $message,
                                'errors' => $errors,
                            ], $statusCode);
    }
}
