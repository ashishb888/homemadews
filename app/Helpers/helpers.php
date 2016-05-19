<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Log;
use DB;
use Config;
use Input;
use Request;
use App\Http\Controllers\Constants;
//use Illuminate\Support\Facades\Validator;
use Hash;
use Exception;

class Utility {
    
    public static function validation_err($validator)
    { 
        $messages = $validator->messages()->all();
        $validErr['status'] = 'ERROR';
        foreach ($messages as $msg) {
                $validErr['messages'][] = $msg;
            }
            $json = json_encode($validErr);
            $remove = array("\\r\\n", "\\n", "\\r", "\\");
            $jsonstr = str_replace($remove, "", trim($json));
            Log::debug("--------------------Validation Messages----------------------");
            Log::debug(json_encode($validErr));
            return $jsonstr;  
    }
    public static function genErrResp($code = "internal_err", $msg = null) {
        try {
            if($msg === null){
                $intErr = "Internal Error";
                $msg = config((strpos($code, ".") === false) ? "validation_message." . $code : $code);
                $msg = isset($msg[Constants::ERR_MSG]) ? $msg[Constants::ERR_MSG] : $intErr;
            }
            
            $respData[Constants::STATUS] = Constants::ERR;
            $respData[Constants::ERRORS][Constants::CODE] = $code;
            $respData[Constants::ERRORS][Constants::ERR_MSG] = $msg;
        } catch (Exception $ex) {
            Log::debug("exception: " . $ex);
        }

        return $respData;
    }
    
}
