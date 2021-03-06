<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'hello';
});


Route::get('hello', function () {
    return 'hello';
});


//Route::post('user/addUser', 'UserController@addUser');

//Route::post('user/addUser',function (){
//    return $_POST['id'].'注册成功';
//});

Route::post('user/addUser', 'UserController@addUser');
Route::post('user/login', 'UserController@login');
//Route::get('user/checkLogin', 'UserController@checkLogin');
Route::get('user/getPublicKey', 'UserController@getPublicKey');

Route::post('sendMail/sendCheckcode', 'SendMailController@sendCheckcode');

Route::get('user/loginOut', 'UserController@loginOut');


Route::group(['middleware'=>['check']], function () {
    Route::get('user/getPersonMessage', 'UserController@getPersonMessage');
});


//Route::post('sendMail/sendCheckcode', 'SendMailController@sendCheckcode');
