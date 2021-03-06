<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //上传图片,制作缩略图
    public function thumb($filename,$width=100,$height=100)
    {
        //$filename = public_path().storage::url($filename);
        //dd($filename);
        $file = public_path().storage::url($filename);
        $path_parts = pathinfo($file); //storage::url($filename);这个才是可用的图片路径
        //dd($path_parts);//public_path().Storage::url($filename);
        $i_mg = $path_parts['filename'].'_'.$width.'X'.$height.'.'.$path_parts['extension']; //拼接缩略图文件路径
        //dd($i_mg);
        $img = Image::make($file)->resize($width, $height);//图片资源必须绝对路径!缩略图
        //dd($img);
        $img->save($path_parts['dirname'].'/'.$i_mg);
        //dd(dirname($filename).'/'.$i_mg);
        return dirname($filename).'/'.$i_mg;
    }
    //上传到阿里OSS
    public function toAliOss($filename,$ossPath='eleb/shop/')
    {
        $client = App::make('aliyun-oss');
        //    $client->putObject(getenv('OSS_BUCKET'), "eleb/shop/1.txt", "上传文件3个参数:BUCKET名,文件名,文件内容");
//    $result = $client->getObject(getenv('OSS_BUCKET'), "eleb/shop/1.txt");
//    echo $result;
        //将D:\www\eleb\eleb_shop\storage\app\public\date0422\SuncCvPZ1aSE7FjfUB2Zz7LrI39MGgrKnhhmzMSQ.jpeg
        //上传到阿里云OSS服务器
        try{
            $client->uploadFile(getenv('OSS_BUCKET'),
                $ossPath.$filename,
                storage_path('app/'.$filename));
            return 'https://tina-laravel.oss-cn-beijing.aliyuncs.com/'.$ossPath.urlencode($filename);
        } catch(\OSS\Core\OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            echo '上传失败';
            return;
        }
    }
}
