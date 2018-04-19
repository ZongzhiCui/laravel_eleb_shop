<?php

namespace App\Http\Controllers;

use App\Models\shop_user;
use Illuminate\Http\Request;

class ShopUserController extends Controller
{
    //商铺首页.注册登录
    public function home()
    {
        return view('shop_user.home');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shop_user.index');
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
        //
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
        //
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
