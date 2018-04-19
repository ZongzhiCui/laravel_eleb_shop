<?php

namespace App\Http\Controllers;

use App\Models\shop_business;
use Illuminate\Http\Request;

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
        //
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
