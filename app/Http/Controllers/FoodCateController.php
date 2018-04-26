<?php

namespace App\Http\Controllers;

use App\Models\FoodCate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FoodCateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //数据库最后一个ID
//        dd(FoodCate::orderBy('id','desc')->take(1)->get()[0]->id);
        $foodcates = FoodCate::where('business_id',Auth::user()->business_id)->paginate(3);
        return view('food_cate.index',compact('foodcates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('food_cate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>[
                'required',
                Rule::unique('food_cates')->where('business_id',Auth::user()->business_id)
                ]
        ],[
            'name.required'=>'分类名称必须填写',
            'name.unique'=>'当前店铺的分类名已经存在',
        ]);
//        dd($request);
        $business_id = Auth::user()->business_id;
        $t = 'c'.(FoodCate::orderBy('id','desc')->take(1)->get()[0]->id+1);
        $foodcate = FoodCate::create([
            'name'=>$request->name,
            'description'=>$request->description??'',
            'is_selected'=>$request->is_selected??0,
            'business_id'=>$business_id,
            'type_accumulation'=>$t,
        ]);
        $id = $foodcate->id;
        if ($request->is_selected==1){
            DB::table('food_cates')
                ->where('business_id',$business_id)
                ->where('id','!=',$id)
                ->update(['is_selected'=>0]);
        }
        return redirect()->route('foodcate.show',compact('foodcate'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodCate  $foodCate
     * @return \Illuminate\Http\Response
     */
    public function show(FoodCate $foodcate)
    {
        return view('food_cate.show',compact('foodcate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FoodCate  $foodCate
     * @return \Illuminate\Http\Response
     */
    public function edit(FoodCate $foodcate)
    {
        return view('food_cate.edit',compact('foodcate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodCate  $foodCate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodCate $foodcate)
    {
        $this->validate($request,[
            'name'=>[
                'required',
                Rule::unique('food_cates')->ignore($foodcate->id)->where('business_id',Auth::user()->business_id)
            ]
        ],[
            'name.required'=>'分类名称必须填写',
            'name.unique'=>'修改的菜品分类已经存在请更换',
        ]);
        $foodcate->update([
            'name'=>$request->name,
            'description'=>$request->description??'',
            'is_selected'=>$request->is_selected??0,
        ]);
        $id = $foodcate->id;
        if ($request->is_selected==1){
            DB::table('food_cates')
                ->where('business_id',$foodcate->business_id)
                ->where('id','!=',$id)
                ->update(['is_selected'=>0]);
        }
        return redirect()->route('foodcate.show',compact('foodcate'));
    }

    public function destroy(FoodCate $foodcate)
    {
        $foodcate->delete();
        echo '删除成功';
    }
}
