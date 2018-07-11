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

Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
Route::get('password/reset', 'AuthController@showResetForm')->name('password.request');


Route::get('glogin',array('as'=>'glogin','uses'=>'AuthController@googleLogin')) ;
Route::get('google-user',array('as'=>'user.glist','uses'=>'AuthController@listGoogleUser')) ;