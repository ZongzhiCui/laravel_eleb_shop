@extends('layout.default')
@section('title','显示')
@section('content')
    <div class="panel panel-warning">
        <a class="btn btn-group" href="{{ route('shop_business.edit',compact('shop_business')) }}">完善商品信息</a>
        <h2 class="bg-primary">商铺名称:{{ $shop_business->shop_name }}</h2>
        <div class="container">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <ul class="list-group">
                        <li>店铺LOGO:<img src="{{$shop_business->shop_img}}" alt=""></li>
                        <li>是否品牌:{{$shop_business->shop_rating}}</li>
                        <li>是否准时:{{$shop_business->on_time}}</li>
                        <li>是否蜂鸟:{{$shop_business->fengniao}}</li>
                        <li>是否保标:{{$shop_business->bao}}</li>
                        <li>是否票标:{{$shop_business->piao}}</li>
                        <li>是否准标:{{$shop_business->zhun}}</li>
                        <li>起送金额:{{$shop_business->start_send}}</li>
                        <li>配送费用:{{$shop_business->send_cost}}</li>
                        <li>预计时间:{{$shop_business->estimate_time}}</li>
                        <li>小店公告:{{$shop_business->notice}}</li>
                        <li>优惠信息:{{$shop_business->discount}}</li>
                    </ul>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    </div>
@stop