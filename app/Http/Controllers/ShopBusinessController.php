<?php

namespace App\Http\Controllers;

use App\Models\shop_business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ShopBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\shop_business  $shop_business
     * @return \Illuminate\Http\Response
     */
    public function show(shop_business $shop_business)
    {
        return view('shop_business.show',compact('shop_business'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\shop_business  $shop_business
     * @return \Illuminate\Http\Response
     */
    public function edit(shop_business $shop_business)
    {
        return view('shop_business.edit',compact('shop_business'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\shop_business  $shop_business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, shop_business $shop_business)
    {
        $this->validate($request,[
            'shop_img'=>'required|image',
            'shop_rating'=>'numeric',
            'start_send'=>'required',
            'send_cost'=>'required',
            'estimate_time'=>'required',
        ],[

        ]);
        $thumb = 270;
        $filename = $request->file('shop_img')->store('public/date'.date('md'));
        $path_parts = pathinfo(Storage::url($filename)); //Storage::url($filename);这个才是可用的图片路径
        $i_mg = $path_parts['dirname'].'/'.$path_parts['filename'].'_'.$thumb.'X'.$thumb.'.'.$path_parts['extension']; //拼接缩略图文件路径

//        dd(Storage::url($filename));  //"/storage/date0419/v5ihKAwkpRJrss9eOkjcui9OEd1F7TmkaC9FSQK9.jpeg"
//        dd($filename);  //public/date0419/nY74PQjcTyZEsRfxZHm3gYP00vJkOOfXOMR8FgiM.jpeg
        $img = Image::make(public_path().Storage::url($filename))->resize($thumb, $thumb);//图片资源必须绝对路径!缩略图
//        dd($i_mg);die;
        $img->save(public_path().$i_mg); //图片资源必须绝对路径!缩略图
        //保存数据库的文件路径为相对路径 ,.及网站根目录
        $shop_business->update([
            'shop_img'=>url($i_mg),
            'shop_rating'=>$request->shop_rating,
            'brand'=>$request->brand??0,
            'on_time'=>$request->on_time??0,
            'fengniao'=>$request->fengniao??0,
            'bao'=>$request->bao??0,
            'piao'=>$request->piao??0,
            'zhun'=>$request->zhun??0,
            'start_send'=>$request->start_send,
            'send_cost'=>$request->send_cost,
            'estimate_time'=>$request->estimate_time,
            'notice'=>$request->notice??'',
            'discount'=>$request->discount??'',
        ]);
        return redirect()->route('shop_business.show',compact('shop_business'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\shop_business  $shop_business
     * @return \Illuminate\Http\Response
     */
    public function destroy(shop_business $shop_business)
    {
        //
    }
}
