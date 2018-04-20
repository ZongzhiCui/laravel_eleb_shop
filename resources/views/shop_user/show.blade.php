@extends('layout.default')
@section('title','显示')
@section('content')
    <div class="panel panel-warning">
        <a class="btn btn-group" href="{{ route('package.index') }}">返回列表</a>
        <h4 class="bg-primary">套餐名字:{{ $shop_user->name }}</h4>
        <h3>套餐价格:{{ $shop_user->price }}</h3>
    </div>
@stop