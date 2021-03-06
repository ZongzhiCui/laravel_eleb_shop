@extends('layout.default')
@section('title','显示')
@section('content')
    <div class="panel panel-warning">
        <h2 class="bg-primary">订单编号:{{ $order->order_code }}</h2>
        <div class="container">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10" style="position: relative;">
                    <ul class="list-group">
                        {{--<li>店铺LOGO:<img style="position: absolute;right: 0;" src="{{$order->shop_img}}" alt=""></li>--}}
                        <li>订单总价:&emsp;{{$order->order_price}}</li>
                        <li>订单地址:&emsp;{{$order->order_address}}</li>
                        @foreach($order->goods_list as $goods)
                        <li>商品:&emsp;{{$goods->goods_name}}</li>
                        <li>图片:&emsp;<img src="{{$goods->goods_img}}" alt=""></li>
                        <li>数量:&emsp;{{$goods->amount}}</li>
                        <li>价格:&emsp;{{$goods->goods_price}}</li>
                        @endforeach
                        <div id="mytable" data-id="{{$order->id}}">
                            <button class="btn btn-lg btn-primary">接单</button>
                            <button class="btn btn-lg btn-success hidden">发货</button>
                            <button class="btn btn-lg btn-info hidden">取消订单</button>
                        </div>
                        {{--<li>是否准标:&emsp;{{$order->zhun==0?'否':'是'}}</li>--}}
                    </ul>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    </div>
@stop
@section('jquery')
    <script type="text/javascript">
    $(function () {
        /*var id = $('mytable').data('id');

        $.get("button", { "id": id },function(data){  //未验证!!
                if (data == 1){
                    $('#mytable .btn').toggleClass('hidden');
                }*/
                $('#mytable .btn-primary').on('click',function () {
                    $('#mytable .btn').toggleClass('hidden');
                    var id = $(this).closest('div').data('id');
                    $.ajax({
                        type: "GET",
                        url: "/acceptOrder/"+id,
//                        data: "id="+id,
                        success: function(msg){
                            layer.msg(msg, function(){
                                //关闭后的操作
                            });
                        }
                    });
                })
//            });
    })
    </script>
    @stop