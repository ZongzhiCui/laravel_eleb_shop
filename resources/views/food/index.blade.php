@extends('layout.default')
@section('title','菜品分类列表')
@section('content')
    <table class="table table-bordered" id="mytable">
        <tr>
            <td>ID</td>
            <td>菜品名称</td>
            <td>菜品图片</td>
            <td>菜品评分</td>
            <td>菜品价格</td>
            <td>菜品月销</td>
            <td>月评论数</td>
            <td>提示信息</td>
            <td>菜品描述</td>
            <td>菜品评论</td>
            <td>菜品规格</td>
            <td>所属商铺</td>
            <td>所属菜类</td>
            <td>操作
                <a href="{{ route('food.create') }}">添加菜品</a>
            </td>
        </tr>
        @forelse($foods as $row)
            <tr data-id="{{ $row->id }}">
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td><img src="{{ $row->logo }}" alt=""></td>
                <td>{{ $row->rating }}</td>
                <td>{{ $row->price }}</td>
                <td>{{ $row->month_sales }}</td>
                <td>{{ $row->rating_count }}</td>
                <td>{{ $row->tips }}</td>
                <td>{{ $row->desc }}</td>
                <td>{{ $row->comment }}</td>
                <td>{{ $row->norm }}</td>
                <td>{{ $row->business_is }}</td>
                <td>{{ $row->food_cates_id }}</td>
                <td>
                    <a href="{{ route('food.show',compact('row')) }}" class="btn btn-xs btn-success">查看</a>
                    <a href="{{ route('food.edit',compact('row')) }}" class="btn btn-xs btn-primary">编辑</a>
                    <button class="btn btn-xs btn-danger">删除</button>
                </td>
            </tr>
            @empty
            !空数据!
        @endforelse
    </table>
    {{ $foods->links() }}
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
                        'url':'food/'+id,
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