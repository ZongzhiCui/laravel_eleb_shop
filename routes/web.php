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
//0424添加content方法 显示活动详情
Route::get('shop_user/content/{activity}','ShopUserController@content')->name('shop_user.content');

//商户注册与登录
Route::get('register1','LoginController@register')->name('register1');
Route::post('register1','LoginController@save')->name('register1');
Route::get('login1','LoginController@create')->name('login1');
Route::post('login1','LoginController@store')->name('login1');
Route::delete('logout1','LoginController@destroy')->name('logout1');

//验证登录中间件
Route::group(['middleware'=>['platform']],function (){

//商铺用户
    Route::resource('shop_user','ShopUserController');
//商铺内容
    Route::resource('shop_business','ShopBusinessController');

//菜品分类
    Route::resource('foodcate','FoodCateController');
//菜品
    Route::resource('food','FoodController');

});

//阿里云OSS转存储文件
Route::get('/oss', function()
{
    $client = App::make('aliyun-oss');
//    $client->putObject(getenv('OSS_BUCKET'), "eleb/shop/1.txt", "上传文件3个参数:BUCKET名,文件名,文件内容");
//    $result = $client->getObject(getenv('OSS_BUCKET'), "eleb/shop/1.txt");
//    echo $result;
    //将D:\www\eleb\eleb_shop\storage\app\public\date0422\SuncCvPZ1aSE7FjfUB2Zz7LrI39MGgrKnhhmzMSQ.jpeg
    //上传到阿里云OSS服务器
    try{
        $client->uploadFile(getenv('OSS_BUCKET'),
            'eleb/shop/public\date0422\SuncCvPZ1aSE7FjfUB2Zz7LrI39MGgrKnhhmzMSQ.jpeg',
            storage_path('app\public\date0422\SuncCvPZ1aSE7FjfUB2Zz7LrI39MGgrKnhhmzMSQ.jpeg'));
        echo '上传成功';
        //访问文件的地址
        //https://tina-laravel.oss-cn-beijing.aliyuncs.com/eleb/shop/
        //urlencode('public\date0422\SuncCvPZ1aSE7FjfUB2Zz7LrI39MGgrKnhhmzMSQ.jpeg');
    } catch(\OSS\Core\OssException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        echo '上传失败';
        return;
    }
});

//webuploader 文件上传!
Route::post('/upload','Tools\UploadController@upload');

//laravel自带的登录注册
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//0428商家查看商铺的订单列表
Route::get('/order','ShopBusinessController@index')->name('order');
//订单详情
Route::get('/order/{order}','ShopBusinessController@orderShow')->name('order.show');
//前端AJAX显示按钮
Route::get('button/{button}','ShopBusinessController@button')->name('button');
//商家接受订单
Route::get('/acceptOrder/{order}','ShopBusinessController@acceptOrder')->name('acceptOrder');
//订单统计
Route::get('/orderCount','ShopBusinessController@orderCount')->name('order.count');
//订单查询
Route::post('/orderTime','ShopBusinessController@orderTime')->name('order.time');

//菜品统计
Route::get('/foodCount','ShopBusinessController@foodCount')->name('food.count');
//菜品查询
Route::post('/foodTime','ShopBusinessController@foodTime')->name('food.time');

//活动查看
Route::get('/event','EventController@index')->name('event.index');
//查看活动详情
Route::get('/event/{event}','EventController@show')->name('event.show');
//添加参加活动人员
Route::post('/createEventMember','EventController@createEventMember')->name('event.createEventMember');

