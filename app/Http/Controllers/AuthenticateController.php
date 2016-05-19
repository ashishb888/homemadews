<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use App\Models\Customer;
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
                    ['phone' => $phoneno,
                     'password' => $password],
                    ['phone' => 'required',
                     'password' => 'required']
                    );
                    if ($validator->fails()) {
                        return Utility::validation_err($validator);
                    }
            if(Auth::attempt(['phone' => $phoneno, 'password' => $password])) {
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
            DB::beginTransaction();
            $content = $request::getContent();
            Log::debug('$content');
            Log::debug($content);
            $jsondata=json_decode($content, true);
            $fullname = $jsondata['data']['fullName'];
            $phone = $jsondata['data']['phone'];
            $email = $jsondata['data']['email'];
            $password = $jsondata['data']['password'];
            $repassword = $jsondata['data']['rePassword'];
            //$curr_date = date('Y-m-d H:i:s T');
            $cust_id="homefood000";
            $validator = Validator::make(
                            [
                        'name' => $fullname,
                        'phone' => $phone,
                        'email' => $email,
                        'password' => $password,
                        'repasswd'=> $repassword
                            ], [
                        'name' => array('required','min:3','Regex:/^[A-Za-z\ \'\\.]+$/'),
                        'phone' => array('required', 'unique:customer,phone', 'Regex:/^(\+\d{1,3}[- ]?)?\d{10}$/'),
                        'password' => "required|min:6",
                        'email' => "email",
                        'repasswd'=>"required|min:6|same:password"
                            ]
                    );
            if ($validator->fails()) {
               return Utility::validation_err($validator);
            }
            $customer= new Customer;
            $customer->name=$fullname;
            $customer->phone=$phone;
            $customer->password=bcrypt($password);
            $customer->email=$email;
            $customer->cust_id=$cust_id;
            $customer->last_logged_in=NULL;
            $customer->save();

            if($customer){
                $insertedId = $customer->id;
                $customer_up = Customer::find($insertedId);
                $customer_up->cust_id = $cust_id.$insertedId;
                $customer_up->save();

                if($customer_up){
                    DB::commit();
                    $retArr['status'] = "success";
                    $retArr['messages'] = "signUp Successfully";
                    $retArr['data']="Signup successfully for customer ".$insertedId;
                    Log::debug(json_encode($retArr));
                    Log::debug("--Signup--");
                    Log::debug(json_encode($retArr));
                    return json_encode($retArr);
                }
            }
        }catch (Exception $ex) {
            DB::rollback();
            Log::debug("exception: " . $ex);
            return json_encode(Utility::genErrResp("internal_err"));
        }
    }

}
