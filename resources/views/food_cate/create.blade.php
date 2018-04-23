@extends('layout.default')
@section('title','添加菜品分类')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <form class="form-block" action="{{route('foodcate.store')}}" method="post">
                <div class="form-group">
                    <p>添加菜品分类</p>
                </div>
                <div class="form-group">
                    <label for="exampleInputName5">分类名称</label>
                    <input type="text" name="name" value="{{old('name')}}" class="form-control" id="exampleInputName5" placeholder="分类名称">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2">分类简述</label>
                    <input type="text" name="description" class="form-control" id="exampleInputEmail2" placeholder="分类简述">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">是否默认选中的分类</label>
                    <input type="checkbox" name="is_selected" value="1" class="form-control" id="exampleInputEmail3">
                </div>
                <button type="submit" class="btn btn-success form-control">提交!</button>
                {{csrf_field()}}
            </form>
        </div>
        <div class="col-sm-3"></div>
    </div>
@stop