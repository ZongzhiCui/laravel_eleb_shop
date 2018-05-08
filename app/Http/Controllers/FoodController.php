<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodCate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = Food::where('business_is',Auth::user()->business_id)->paginate(3);
        return view('food.index',compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $foodcates = FoodCate::where('business_id',Auth::user()->business_id)->get();
        return view('food.create',compact('foodcates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->input(),$request->file('logo'));
        $this->validate($request,[
            'name'=>[
                'required',
                //菜品名称 在当前店铺和当前分类不能相同
                Rule::unique('foods')->where(function ($query) use($request){ //where条件
                    $query->where([
                       ['business_is',Auth::user()->business_id],
                        ['food_cates_id',$request->food_cates_id]
                    ]);
                })
            ],
            'norm'=>'min:2',
            'logo'=>'required',
        ],[
            'name.unique'=>'菜品名称 在当前店铺和当前分类不能相同',
        ]);
//        $filename = $request->file('logo')->store('public/date'.date('md'));

/**        $thumb = 100;
        $path_parts = pathinfo(Storage::url($filename)); //Storage::url($filename);这个才是可用的图片路径
        $i_mg = $path_parts['dirname'].'/'.$path_parts['filename'].'_'.$thumb.'X'.$thumb.'.'.$path_parts['extension']; //拼接缩略图文件路径
        $img = Image::make(public_path().Storage::url($filename))->resize($thumb, $thumb);//图片资源必须绝对路径!缩略图
        $img->save(public_path().$i_mg);*/

//        dd($filename,$i_mg);
        //上传到阿里OSS
//        $ToAliOss = $this->ToAliOss($filename,'eleb/shop/');
//        dd($ToAliOss);

        $food = Food::create([
            'name'=>$request->name,
//            'logo'=>url($i_mg),
            'logo'=>$request->logo,
            'rating'=>$request->rating??0,
            'price'=>$request->price??0,
            'month_sales'=>$request->month_sales??0,
            'rating_count'=>$request->rating_count??0,
            'tips'=>$request->tips??'',
            'desc'=>$request->desc??'',
            'comment'=>$request->comment??'',
            'norm'=>$request->norm??0,
            'business_is'=>Auth::user()->business_id,
            'food_cates_id'=>$request->food_cates_id,
        ]);
        return redirect()->route('food.show',compact('food'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        return view('food.show',compact('food'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        $foodcates = FoodCate::where('business_id',Auth::user()->business_id)->get();
        return view('food.edit',compact('food','foodcates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
//        dd($request->input());
        $this->validate($request,[
            'name'=>[
                'required',
                //菜品名称 在当前店铺和当前分类不能相同
                Rule::unique('foods')->ignore($food->id)->where(function ($query) use($request){ //where条件
                    $query->where([
                        ['business_is',Auth::user()->business_id],
                        ['food_cates_id',$request->food_cates_id]
                    ]);
                })
            ],
            'norm'=>'min:2',
//            'logo'=>'image',
        ],[

        ]);
        $arr = [];
        foreach ($request->except(['_token','_method']) as $k=>$v){
            if ($v != null){
                $arr[$k] = $v;
            }
        }
        /*if ($request->logo != null){
            $thumb = 100;
            $filename = $request->file('logo')->store('public/date'.date('md'));
            $path_parts = pathinfo(Storage::url($filename)); //Storage::url($filename);这个才是可用的图片路径
            $i_mg = $path_parts['dirname'].'/'.$path_parts['filename'].'_'.$thumb.'X'.$thumb.'.'.$path_parts['extension']; //拼接缩略图文件路径
            $img = Image::make(public_path().Storage::url($filename))->resize($thumb, $thumb);//图片资源必须绝对路径!缩略图
            $img->save(public_path().$i_mg);
            $arr['logo'] = url($i_mg);
//            dd($arr['logo']);
        }*/
        $food->update($arr);
        return redirect()->route('food.show',compact('food'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        $food->delete();
        echo '删除成功!!!!';
    }
}
