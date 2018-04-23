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