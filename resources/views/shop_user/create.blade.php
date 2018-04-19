@extends('layout.default')
@section('title','添加')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 bg-info">
            <a class="btn btn-group" href="{{ route('package.index') }}">返回列表</a>
            <form action="{{ route('package.store') }}" method="post">
                <br>
                <input class="form-control" type="text" name="name" value="{{old('name')}}" placeholder="套餐名"><br>
                <input class="form-control" type="number" name="price" value="{{old('price')}}" placeholder="价格"><br>
                <input class="form-control" type="submit"><br>
                {{ csrf_field() }}
            </form>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endsection