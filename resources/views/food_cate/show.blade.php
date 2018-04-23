@extends('layout.default')
@section('title','显示')
@section('content')
    <div class="panel panel-warning">
        <a class="btn btn-group" href="{{ route('foodcate.edit',compact('foodcate')) }}">修改分类信息</a>
        <h2 class="bg-primary">分类名称:{{ $foodcate->name }}</h2>
        <div class="container">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10" style="position: relative;">
                    <ul class="list-group">
                        <li>分类名称:&emsp;{{$foodcate->name}}</li>
                        <li>分类简述:&emsp;{{$foodcate->description}}</li>
                        <li>是否选中:&emsp;{{$foodcate->is_selected==0?'否':'是'}}</li>
                        <li>店铺名称:&emsp;{{$foodcate->shop_business->shop_name}}</li>
                    </ul>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    </div>
@stop