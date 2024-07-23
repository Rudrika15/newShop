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


    public static function getCreateResponse($data, $message = "")
    {
        $response = [
            'message' => $message,
            'status' => 201,
            'data' => $data,
        ];
        return response($response, 201);
    }


    public static function getorderListResponse($data, $message = "result")
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
    public static function getMyorderListResponse($data, $message = "result")
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
}
