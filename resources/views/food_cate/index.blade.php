@extends('layout.default')
@section('title','菜品分类列表')
@section('content')
    <table class="table table-bordered" id="mytable">
        <tr>
            <td>ID</td>
            <td>菜品分类名称</td>
            <td>菜品分类描述</td>
            <td>是否默认选中</td>
            <td>所属商铺</td>
            <td>操作
                <a href="{{ route('foodcate.create') }}">添加菜品分类</a>
            </td>
        </tr>
        @forelse($foodcates as $row)
            <tr data-id="{{ $row->id }}">
                <td>{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->is_selected }}</td>
                <td>{{ $row->business_id }}</td>
                <td>
                    <a href="{{ route('foodcate.show',compact('row')) }}" class="btn btn-xs btn-success">查看</a>
                    <a href="{{ route('foodcate.edit',compact('row')) }}" class="btn btn-xs btn-primary">编辑</a>
                    <button class="btn btn-xs btn-danger">删除</button>
                </td>
            </tr>
            @empty
            !空数据!
        @endforelse
    </table>
    {{ $foodcates->links() }}
@endsection

@section('jquery')
    <script type="text/javascript">
        $(function () {
            $('#mytable .btn-danger').on('click',function () {
                if (confirm('你确定要删除吗?删除后不可回复!')){
                    var tr = $(this).closest('tr');
                    var id = tr.data('id');
//                    alert(id);
                    $.ajax({
                        'type':'DELETE',
                        'url':'foodcate/'+id,
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