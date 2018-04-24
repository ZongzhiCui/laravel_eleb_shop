<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\shop_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ShopUserController extends Controller
{
    //活动首页!!!
    public function home()
    {
        $activitys = Activity::orderBy('id','desc')->paginate(3);
        return view('shop_user.home',compact('activitys'));
    }
    //活动详情
    public function content(Activity $activity)
    {
//        dd($activity);
        return view('shop_user.content',compact('activity'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return '赞不支持此功能!敬请期待!';
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
     * @param  \App\Models\shop_user  $shop_user
     * @return \Illuminate\Http\Response
     */
    public function show(shop_user $shop_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\shop_user  $shop_user
     * @return \Illuminate\Http\Response
     */
    public function edit(shop_user $shop_user)
    {
        return view('shop_user.edit',compact('shop_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\shop_user  $shop_user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, shop_user $shop_user)
    {
        $this->validate($request,[
            'oldpassword'=>'required',
            'password'=>'required|confirmed',
        ],[
            'oldpassword.required'=>'旧密码必须填写',
            'password.required'=>'新密码必须填写',
            'password.confirmed'=>'确认密码与新密码不一致',
        ]);
//        dd(Auth::user()->password,$shop_user->password);
        if(!Hash::check($request->oldpassword, $shop_user->password)){
            echo '旧密码错误!';
        }
        $shop_user->update([
            'password'=>bcrypt($request->password),
        ]);
        Auth::logout();
        return redirect('login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\shop_user  $shop_user
     * @return \Illuminate\Http\Response
     */
    public function destroy(shop_user $shop_user)
    {
        //
    }
}
