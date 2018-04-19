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

Route::get('/','ShopUserController@home');

//商户注册与登录
Route::get('register','LoginController@register')->name('register');
Route::post('register','LoginController@save')->name('register');
Route::get('login','LoginController@create')->name('login');
Route::post('login','LoginController@store')->name('login');
Route::delete('logout','LoginController@destroy')->name('logout');

//商铺用户
Route::resource('shop_user','ShopUserController');
//商铺内容
Route::resource('shop_business','ShopBusinessController');
