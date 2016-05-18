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

    public function signin(Request $request){
        try{
            $content = $request::getContent();
            Log::debug('$content');

           
            $jsondata = json_decode($content);

            $phoneno = $jsondata->data->phone;
            $password = $jsondata->data->password;

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

     public function signup(Request $request){
        try{
            $content = $request::getContent();
            Log::debug('$content');
            Log::debug($content);
            $jsondata=json_decode($content, true);
            $fullname = $jsondata['data']['fullName'];
            $phone = $jsondata['data']['phone'];
            $email = $jsondata['data']['email'];
            $password = $jsondata['data']['password'];
            $repassword = $jsondata['data']['rePassword'];
            $curr_date = date('Y-m-d H:i:s T');
            $cu_cust_id="homemade000";

            $validator = Validator::make(
                            [
                        'cu_name' => $fullname,
                        'cu_name_reg' => $fullname,
                        'cu_phone' => $phone,
                        'cu_phone_reg'=>$phone,
                        'cu_email' => $email,
                        'cu_password' => $password,
                        'cu_repasswd'=> $repassword
                            ], [
                        'cu_name' =>"required|min:6",
                        'cu_phone' => "required|unique:customer,cu_phone",
                        'cu_password' => "required|min:6",
                        'cu_email' => "email",
                        'cu_repasswd'=>"required|min:6|same:cu_password",
                        'cu_name_reg' => array('Regex:/^[A-Za-z\ \'\\.]+$/'),
                        'cu_phone_reg' => array('Regex:/^(\+\d{1,3}[- ]?)?\d{10}$/')
                            ],
                     $messages = array(
                        'cu_name.required' => json_encode(config('validation_message.cu_name_required')),
                        'cu_phone.required' => json_encode(config('validation_message.cu_phone_required')),
                        'cu_password.required' => json_encode(config('validation_message.cu_password_required')),
                        'cu_repasswd.required' => json_encode(config('validation_message.cu_repasswd')),
                        'cu_name.min' => json_encode(config('validation_message.cu_name_min')),
                        'cu_password.min' => json_encode(config('validation_message.cu_password_min')),
                        'cu_repasswd.min' => json_encode(config('validation_message.cu_repasswd_min')),
                        'cu_name_reg.regex' => json_encode(config('validation_message.cu_name_reg')),
                        'cu_repasswd.same' => json_encode(config('validation_message.cu_repasswd_same')),
                        'cu_phone.unique' => json_encode(config('validation_message.cu_phone_unique')),
                        'cu_email.email' => json_encode(config('validation_message.cu_email')),
                        'cu_phone_reg.regex' => json_encode(config('validation_message.cu_phone_reg'))
                    ));
            if ($validator->fails()) {
               return Utility::validation_err($validator);
            }
            $cu_id = DB::table('customer')->insertGetId(
                                ['cu_name' => $fullname,
                                    'cu_phone' => $phone,
                                    'cu_password' => bcrypt($password),
                                    'cu_email' => $email,
                                    'cu_cust_id' => $cu_cust_id,
                                    'cu_last_logged_in' => NULL,
                                    'created_at' => $curr_date,
                                    'updated_at' => $curr_date,
                                    'deleted_at' => NULL
                                ],'cu_id');
            if($cu_id){
                $update_id = DB::table('customer')
                ->where("cu_id", $cu_id)
                ->update(array("cu_cust_id" => $cu_cust_id.$cu_id));
                if($update_id){
                    $retArr['status'] = "success";
                    $retArr['messages'] = "signUp Successfully";
                    $retArr['data']="Signup successfully for customer ".$cu_id;
                    Log::debug(json_encode($retArr));
                    Log::debug("--Signup--");
                    Log::debug(json_encode($retArr));
                    return json_encode($retArr);
                }
            }
        }catch (Exception $ex) {
            Log::debug("exception: " . $ex);
            return json_encode(Utility::genErrResp("internal_err"));
        }
    }





}
