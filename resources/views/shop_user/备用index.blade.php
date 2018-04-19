@extends('layout.default')
@section('title','套餐列表')
@section('content')
    <table class="table table-bordered" id="mytable">
        <tr>
            <td>ID</td>
            <td>套餐名称</td>
            <td>套餐价格</td>
            <td>操作
                <a href="{{ route('package.create') }}">添加套餐</a>
            </td>
        </tr>
        @forelse($packages as $package)
            <tr data-id="{{ $package->id }}">
                <td>{{ $package->id }}</td>
                <td>{{ $package->name }}</td>
                <td>{{ $package->price }}</td>
                <td>
                    <a href="{{ route('package.show',compact('package')) }}" class="btn btn-xs btn-success">查看</a>
                    <a href="{{ route('package.edit',compact('package')) }}" class="btn btn-xs btn-primary">编辑</a>
                    <button class="btn btn-xs btn-danger">删除</button>
                </td>
            </tr>
            @empty
            !空数据!
        @endforelse
    </table>
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
                        'url':'package/'+id,
                        'data':'_token={{ csrf_token() }}',
                        'success':function (msg) {
                            tr.fadeOut(1000);
                        }
                    });
                }
            })
        })
    </script>
@stop