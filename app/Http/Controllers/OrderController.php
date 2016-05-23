<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use App\Models\Dish_types;
use App\Models\Dishes;
use Illuminate\Support\Facades\Validator;
use Request;
use View;
use Redirect;
use Log;
use Input;
use DateTime;
use Config;
use Exception;
use App\Helpers\Utility;
use Session;

class OrderController extends Controller
{
     
    public function menu(Request $request){
        try{
            $dish_types = new Dish_types;
            $dish_types = Dish_types::all();
           foreach ($dish_types as $dt) {
            $data[$dt->name] = DB::table('dishes')->select('name')->where('dish_type_id', '=', $dt->id)->get();
           }
            $new_data=array();
            foreach($data as $key=>$val){
                foreach($val as $val1){
                    $new_data[$key][]=$val1->name;
                }
            }
           if($new_data){
                $retArr['status'] = "SUCCESS";
                $retArr['messages'] = "Dinner Menu";
                $retArr['data']=$new_data;
                Log::debug(json_encode($retArr));
                Log::debug("--Dinner Menu--");
                Log::debug(json_encode($retArr));
                return json_encode($retArr);
            }
            
        } catch (Exception $ex) {
             Log::debug("exception: " . $ex);
            return json_encode(Utility::genErrResp("internal_err"));

        }
    }
}
