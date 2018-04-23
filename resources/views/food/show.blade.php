@extends('layout.default')
@section('title','显示')
@section('content')
    <div class="panel panel-warning">
        <a class="btn btn-group" href="{{ route('food.edit',compact('food')) }}">修改菜品信息</a>
        <h2 class="bg-primary">菜品名称:{{ $food->name }}</h2>
        <div class="container">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10" style="position: relative;">
                    <ul class="list-group">
                        <li>菜品名称:&emsp;{{$food->name}}</li>
                        <li>菜品图片:&emsp;<img height="300px" src="{{$food->logo}}" alt=""></li>
                        <li>菜品评分:&emsp;{{$food->rating}}</li>
                        <li>菜品价格:&emsp;{{$food->price}}</li>
                        <li>菜品月销:&emsp;{{$food->month_sales}}</li>
                        <li>评论次数:&emsp;{{$food->rating_count}}</li>
                        <li>提示信息:&emsp;{{$food->tips}}</li>
                        <li>菜品描述:&emsp;{{$food->desc}}</li>
                        <li>菜品评论:&emsp;{{$food->comment}}</li>
                        <li>菜品规格:&emsp;{{$food->norm}}</li>
                        <li>菜品分类:&emsp;{{$food->foodcate->name}}</li>
                        <li>店铺名称:&emsp;{{$food->shop_business->shop_name}}</li>
                    </ul>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    </div>
@stop