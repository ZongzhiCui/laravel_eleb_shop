<?php

namespace App\Http\Controllers;

use App\Models\FoodCate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodCateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'name'=>'required',
        ],[
            'name.required'=>'分类名称必须填写',
        ]);
//        dd($request);
        $business_id = Auth::user()->business_id;
        $foodcate = FoodCate::create([
            'name'=>$request->name,
            'description'=>$request->description??'',
            'is_selected'=>$request->is_selected??0,
            'business_id'=>$business_id,
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
            'name'=>'required',
        ],[
            'name.required'=>'分类名称必须填写',
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
