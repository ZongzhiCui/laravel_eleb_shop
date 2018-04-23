<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $filename = $request->file('file')->store('public/date'.date('md'));
        //上传到阿里OSS
        $ToAliOss = $this->ToAliOss($filename,'eleb/shop/');
//        return ['url'=>url(Storage::url($filename))];
        return ['url'=>$ToAliOss];
    }
}
