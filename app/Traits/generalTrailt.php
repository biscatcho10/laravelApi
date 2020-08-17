<?php

namespace App\Traits;

trait generalTrailt {

    public function sendResponse($result , $message){
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    public function sendError($error , $Errormessages = [], $code =  404){
        $response = [
            'success' => false,
            'message' => $error
        ];

        if(!empty($Errormessage)) {
           $response['data'] = $Errormessage;
        }

        return response()->json($response, $code);
    }
}
