<?php

namespace App\Http\Controllers;

use App\Models\shop_business;
use App\Models\shop_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function register()
    {

        return view('login.register');
    }

    public function save(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email|unique:shop_users',
            'password'=>'required|confirmed|min:6',
            'name'=>'required|min:2',
            'captcha' => 'required|captcha'
        ],[
            'email.email'=>'邮箱地址不合法',
            'password.confirmed'=>'两次密码不一致!',
            'name.min'=>'商铺名称至少2位',
            'captcha.captcha' => '验证码不正确',
        ]);
        DB::transaction(function ()use($request){
            $shop_business = shop_business::create([
                'shop_name'=>$request->name,
            ]);
            shop_user::create([
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'business_id'=>$shop_business->id,
            ]);
        });
        return redirect('login');

    }

    public function create()
    {
        return view('login.create');
    }

    //商户登录验证
    public function store(Request $request)
    {
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required',
            'captcha' => 'required|captcha'
        ],[
            'password.required'=>'填写密码!',
            'captcha.captcha' => '验证码不正确',
        ]);
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password],$request->has('remember'))){
            $shop_user = Auth::user();
//            dd(Auth::user()->status);
            if ($shop_user->status==0){
                return redirect()->route('shop_business.show',compact('shop_user'))->with('danger','该账户还没有通过审核!!请尽快完善信息');
            }
            session()->flash('success','登录成功!');
            return redirect()->route('shop_business.show',compact('shop_user'));//->intended('shop_business.show',compact('shop_user'));
        }else{
            return back()->withInput()->with('danger','用户名或者密码错误!');
        }
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('login')->with('success', '您已成功退出！');
    }
}
