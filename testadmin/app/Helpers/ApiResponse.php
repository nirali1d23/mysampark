<?php
 namespace App\Helpers;

class ApiResponse
{
    public static function success($data, $message = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'statusCode' => 200
        ]);
    }
    
    public static function error($message, $statusCode = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }

    public static function validationError($errors)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $errors
        ], 422);
    }
}
?>