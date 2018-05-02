@extends('layout.default')
@section('title','订单列表')
@section('content')
    <table class="table table-bordered" id="mytable">
        <tr>
            <td>ID</td>
            {{--<td>order_code</td>--}}
            <td>order_status</td>
            <td>users_id</td>
            <td>shop_id</td>
            <td>shop_name</td>
            <td>shop_img</td>
            <td>order_price</td>
            <td>receipt_name</td>
            <td>receipt_tel</td>
            <td>receipt_detail_address</td>
            <td>操作
                <a href="">备用</a>
            </td>
        </tr>
        @forelse($orders as $row)
            <tr data-id="{{ $row->id }}">
                <td>{{ $row->id }}</td>
                {{--<td>{{ $row->order_code }}</td>--}}
                <td>{{ $row->order_status==0?'代支付':'已支付' }}</td>
                <td>{{ $row->user_tel }}</td>
                <td>{{ $row->shop_id }}</td>
                <td>{{ $row->shop_name }}</td>
                <td><img src="{{ $row->shop_img }}" width="120px" alt=""></td>
                <td>{{ $row->order_price }}</td>
                <td>{{ $row->receipt_name }}</td>
                <td>{{ $row->receipt_tel }}</td>
                <td>{{ $row->receipt_provence.$row->receipt_city.$row->receipt_area.$row->receipt_detail_address }}</td>
                <td>
                    <a href="{{ route('order.show',compact('row')) }}" class="btn btn-sm btn-primary">查看</a>
                    {{--<a href="{{ route('food.edit',compact('row')) }}" class="btn btn-xs btn-primary">编辑</a>--}}
                    {{--<button class="btn btn-xs btn-primary">接单</button>--}}
                </td>
            </tr>
            @empty
            !空数据!
        @endforelse
    </table>
    {{ $orders->links() }}
@endsection

@section('jquery')
    <script type="text/javascript">
        $(function () {
            $('#mytable .btn-danger').on('click',function () {
                if (confirm('你确定要删除吗?删除后不可回复!')){
                    var tr = $(this).closest('tr');
                    var id = tr.data('id');
                    $.ajax({
                        'type':'DELETE',
                        'url':'order/'+id,
                        'data':'_token={{ csrf_token() }}',
                        'success':function (msg) {
                            tr.fadeOut(1000);
                            layer.msg(msg, function(){
                                //关闭后的操作
                            });
                        }
                    });
                }
            })

        })
    </script>
@stop