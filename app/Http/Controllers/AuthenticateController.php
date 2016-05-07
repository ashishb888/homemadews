<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Validator;
use Hash;
use Request;
use View;
use Redirect;
use Log;
use Auth;
use Input;
use DateTime;
use Config;
use Exception;
use App\Helpers\Utility;
use Session;
//use Input;

class AuthenticateController extends Controller {   
    
    public function login(Request $request){
        try{
            $content = $request::getContent();
            Log::debug('$content');
            Log::debug($content);
            
            //print_r($content);
            
            $jsondata = json_decode($content);

            $phoneno = $jsondata->PhoneNo;
            $password = $jsondata->Password;
            
            $validator = Validator::make(
                    ['cu_phone' => $phoneno,
                     'password' => $password],
                    ['cu_phone' => 'required',
                     'password' => 'required'], 
                    $messages = array(
                        'cu_phone.required' => json_encode(config('validation_message.required')),
                        'password.required' => json_encode(config('validation_message.required'))
                    ));
                    if ($validator->fails()) {    
                        return Utility::validation_err($validator);
                    }
            if(Auth::attempt(['cu_phone' => $phoneno, 'password' => $password])) {      
                $retArr['status'] = "SUCCESS";
                $retArr['messages'] = 'Authentication Success';
                $retArr['data']="phone=".$phoneno."|password=".$password;
                Log::debug(json_encode($retArr));     
               return json_encode($retArr);
            } else {        
               $retArr['status'] = "ERROR";
               $retArr['messages'] = 'Authentication Failed';
               $retArr['data']="phone=".$phoneno."|password=".$password;
               Log::debug(json_encode($retArr));     
               return json_encode($retArr);
            }
        }catch (Exception $ex) {
            Log::debug("exception: " . $ex);
            return json_encode(Utility::genErrResp("internal_err"));
        }
    }
    public function logout(){  
        try{
            Session::flush();
            $retArr['status'] = "SUCCESS";
            $retArr['messages'] = "Logout Successfully";
            $retArr['data']="Session ended";
            Log::debug(json_encode($retArr));     
            Log::debug("--Logout--");
            Log::debug(json_encode($retArr));
            return json_encode($retArr);
        }catch (Exception $ex) {
            Log::debug("exception: " . $ex);
            return json_encode(Utility::genErrResp("internal_err"));
        }        
    }
    
  

    
}
