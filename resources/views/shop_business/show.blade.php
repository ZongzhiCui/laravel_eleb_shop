@extends('layout.default')
@section('title','显示')
@section('content')
    <div class="panel panel-warning">
        <a class="btn btn-group" href="{{ route('shop_business.edit',compact('shop_business')) }}">完善商品信息</a>
        <h2 class="bg-primary">商铺名称:{{ $shop_business->shop_name }}</h2>
        <div class="container">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10" style="position: relative;">
                    <ul class="list-group">
                        <li>店铺LOGO:<img style="position: absolute;right: 0;" src="{{$shop_business->shop_img}}" alt=""></li>
                        <li>店铺评分:&emsp;{{$shop_business->shop_rating}}</li>
                        <li>是否品牌:&emsp;{{$shop_business->brand==0?'否':'是'}}</li>
                        <li>是否准时:&emsp;{{$shop_business->on_time==0?'否':'是'}}</li>
                        <li>是否蜂鸟:&emsp;{{$shop_business->fengniao==0?'否':'是'}}</li>
                        <li>是否保标:&emsp;{{$shop_business->bao==0?'否':'是'}}</li>
                        <li>是否票标:&emsp;{{$shop_business->piao==0?'否':'是'}}</li>
                        <li>是否准标:&emsp;{{$shop_business->zhun==0?'否':'是'}}</li>

                        <li>起送金额:&emsp;{{$shop_business->start_send}}</li>
                        <li>配送费用:&emsp;{{$shop_business->send_cost}}</li>
                        <li>预计时间:&emsp;{{$shop_business->estimate_time}}</li>
                        <li>小店公告:&emsp;{{$shop_business->notice}}</li>
                        <li>优惠信息:&emsp;{{$shop_business->discount}}</li>
                    </ul>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    </div>
@stop