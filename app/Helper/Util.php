<?php

namespace App\Helper;

class Util
{

    public static function getSuccessResponse($data,$token,$message = "")
    {
        $response = [
            'message' => $message,
            'status' => 200,
            'data' => $data,
            'token' => $token,
        ];
        return response($response, 200);
    }

    public static function getSuccessResponseForPinChange($data, $token, $message = "Pin Changed Succesfully..")
    {
        $response = [
            'message' => $message,
            'status' => 200,
            'data' => $data,
            'token' => $token,
        ];
        return response($response, 200);
    }


    public static function getCreateResponse($data, $message = "")
    {
        $response = [
            'message' => $message,
            'status' => 201,
            'data' => $data,
        ];
        return response($response, 201);
    }


    public static function getOrderListResponse($data, $message = "Get Order List")
    {
        $response = [
            'message' => $message,
            'status' => 200,
            'data' => $data,
        ];
        return response($response, 200);
    }
    public static function getPincodeResponse($data, $message = "Pincode List")
    {
        $response = [
            'message' => $message,
            'status' => 200,
            'data' => $data,
        ];
        return response($response, 200);
    }
    public static function getMyOrderListResponse($data, $message = "My Order List")
    {
        $response = [
            'message' => $message,
            'status' => 200,
            'data' => $data,
        ];
        return response($response, 200);
    }
    public static function getCategoryListResponse($data, $message = "Category List")
    {
        $response = [
            'message' => $message,
            'status' => 200,
            'data' => $data,
        ];
        return response($response, 200);
    }

    public static function getErrorResponse($errors = [], $message = 'Operation failed', $statusCode = 422)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

}
