<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('signin', array("uses" => "AuthenticateController@signin"));
Route::post('signup', array("uses" => "AuthenticateController@signup"));

Route::post('address', array("uses" => "CustomerController@addAddress"));
Route::get('address/{cust_id}', array("uses" => "CustomerController@checkAddress"));
Route::post('locations', array("uses" => "CustomerController@locations"));
//Route::post('lunchmenu', array("uses" => "OrderController@lunchMenu"));
Route::post('menu', array("uses" => "OrderController@menu"));
