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
    public static function getPincodesResponse($data, $message = "Pincode List")
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

    public static function getPincodeResponse($pincodes)
    {
        // Check if the input is a collection
        if ($pincodes instanceof \Illuminate\Database\Eloquent\Collection) {
            return $pincodes->map(function ($pincode) {
                return [
                    'state' => $pincode->state,
                    'district' => $pincode->district,
                    'city' => $pincode->city,
                    'pincode' => $pincode->pincode,
                    'isDeliverbale' => $pincode->isDeliverable,
                    'deliveryCharges'=> $pincode->deliveryCharges
                ];
            });
        }

        // If it's a single record
        return [
            'state' => $pincodes->state,
            'district' => $pincodes->district,
            'city' => $pincodes->city,
            'pincode' => $pincodes->pincode,
            'isDeliverbale' => $pincodes->isDeliverable,
            'deliveryCharges' => $pincodes->deliveryCharges
        ];
    }

    public static function getPincodesListResponse($pincodes)
    {
        return $pincodes->map(function ($pincode) {
            return [
                'state' => $pincode->state,
                'district' => $pincode->district,
                'city' => $pincode->city,
                'pincode' => $pincode->pincode,
            ];
        });
    }

}
