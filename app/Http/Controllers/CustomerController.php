<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use App\Models\Customer_addresses;
use App\Models\Cities;
use App\Models\Areas;
use App\Models\Area_Locations;
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

class CustomerController extends Controller
{
    public function addAddress(Request $request){
        try{
            $content = $request::getContent();
            Log::debug('$content');      
            $jsondata = json_decode($content);
            
            $city = $jsondata->data->city;
            $area = $jsondata->data->area;
            $residence = $jsondata->data->residence;
            $sector = $jsondata->data->sector;
            $residenceAddr = $jsondata->data->residenceAddr;
            $cust_id=$jsondata->data->cust_id;
            $validator = Validator::make(
                    ['city' => $city,
                     'area' => $area,
                     'residence' => $residence,
                     'sector' => $sector,
                     'residenceAddr' => $residenceAddr,
                     'cust_id' => $cust_id  ],
                    ['city' => 'required',
                     'area' => 'required',
                     'residence' => 'required',
                     'sector' => 'required',
                     'residenceAddr' => 'required|min:3',
                     'cust_id' => 'required|unique:customer_addresses,cust_id']
                    );
                    if ($validator->fails()) {
                        return Utility::validation_err($validator);
                    }
            $address = new Customer_addresses;
            $address->cust_id=$cust_id;
            $address->address=$city."-".$area."-".$residence."-".$sector."-".$residenceAddr;
            $address->save();
            if($address){
                $retArr['status'] = "SUCCESS";
                $retArr['messages'] = "address added Successfully";
                $retArr['data']="address added successfully for customer ".$cust_id;
                Log::debug(json_encode($retArr));
                Log::debug("--addAddress--");
                Log::debug(json_encode($retArr));
                return json_encode($retArr);
            }
            
        } catch (Exception $ex) {
             Log::debug("exception: " . $ex);
            return json_encode(Utility::genErrResp("internal_err"));

        }
    }
    public function checkAddress($cust_id){
        try{
            $validator = Validator::make(
                    ['cust_id' => $cust_id ],
                    ['cust_id' => 'required']
                    );
                    if ($validator->fails()) {
                        return Utility::validation_err($validator);
                    }
            $address_find = DB::table('customer_addresses')
                     ->select(DB::raw('count(*) as total_count'))
                     ->where('cust_id', '=', $cust_id)
                     ->get();    
            $count = $address_find[0]->total_count;
            if($count>0){
                $retArr['status'] = "SUCCESS";
                $retArr['messages'] = "Address already present";
                $retArr['data']['isAddressPresent']=true;
                Log::debug(json_encode($retArr));
                Log::debug("--addAddress--");
                Log::debug(json_encode($retArr));
                return json_encode($retArr);
            }else{
                $retArr['status'] = "SUCCESS";
                $retArr['messages'] = "Address not present";
                $retArr['data']['isAddressPresent']=false;
                Log::debug(json_encode($retArr));
                Log::debug("--addAddress--");
                Log::debug(json_encode($retArr));
                return json_encode($retArr);
            }
            
        } catch (Exception $ex) {
             Log::debug("exception: " . $ex);
            return json_encode(Utility::genErrResp("internal_err"));

        }
    }
     public function locations(Request $request){
        try{
            $cities = new Cities;
            $cities = Cities::all();
            foreach ($cities as $city) {
            $data[$city->name] = DB::table('area')->select('id','name')->where('city_id', '=', $city->id)->get();
            } 
            $new_data=array();
            foreach($data as $key=>$val){
                foreach($val as $val1){
                $location= DB::table('area_location')->select('name')->where('location_id', '=', $val1->id)->get();
                 $new_data[$key][$val1->name][]=$location[0]->name;
                }
            }
            if($cities){
                $retArr['status'] = "SUCCESS";
                $retArr['messages'] = "City List";
                $retArr['data']=$new_data;
                Log::debug(json_encode($retArr));
                Log::debug("--addAddress--");
                Log::debug(json_encode($retArr));
                return json_encode($retArr);
            }
            
        } catch (Exception $ex) {
             Log::debug("exception: " . $ex);
            return json_encode(Utility::genErrResp("internal_err"));

        }
    }
}
