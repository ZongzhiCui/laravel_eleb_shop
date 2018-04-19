@extends('layout.default')
@section('title','添加')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 bg-info">
            <a class="btn btn-group" href="{{ route('shop_business.show',compact('shop_business')) }}">查看信息</a>
            <p>商铺名称::{{$shop_business->name}}</p>
            <form action="{{ route('shop_business.update',compact('shop_business')) }}" method="post" enctype="multipart/form-data">
                <br>
                <input class="form-control" type="file" name="shop_img" placeholder="店铺LOGO"><br>
                <img src="{{$shop_business->shop_img}}" alt=""><br>
                <label>是否准时:<input class="form-control" type="checkbox" name="on_time" value="1"></label>
                <label>是否蜂鸟:<input class="form-control" type="checkbox" name="fengniao" value="1"></label>
                <label>是否准时:<input class="form-control" type="checkbox" name="on_time" value="1"></label>
                <label>是否保标:<input class="form-control" type="checkbox" name="bao" value="1"></label><br>
                <label>是否票标:<input class="form-control" type="checkbox" name="piao" value="1"></label>
                <label>是否准标:<input class="form-control" type="checkbox" name="zhun" value="1"></label>
                <label>是否准标:<input class="form-control" type="checkbox" name="zhun" value="1"></label>

                <input class="form-control" type="number" name="start_send" value="{{old('start_send')}}" placeholder="起送金额"><br>
                <input class="form-control" type="number" name="send_cost" value="{{old('send_cost')}}" placeholder="配送费用"><br>
                <input class="form-control" type="number" name="estimate_time" value="{{old('estimate_time')}}" placeholder="预计时间"><br>
                <textarea class="form-control" name="notice">{{old('notice')??'小店公告'}}</textarea><br>
                <textarea class="form-control" name="discount">{{old('discount')??'优惠信息'}}</textarea><br>
                <input class="form-control" type="submit"><br>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
            </form>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endsection