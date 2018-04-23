@extends('layout.default')
@section('title','修改菜品分类')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <form class="form-block" action="{{route('food.update',compact('food'))}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <p>添加菜品</p>
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">菜品名称</label>
                    <input type="text" name="name" value="{{$food->name}}" class="form-control" id="exampleInputName1" placeholder="菜品名称">
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">菜品图片</label>
                    <input type="file" name="logo" value="{{$food->logo}}" class="form-control" id="exampleInputName2" placeholder="菜品图片">
                </div>
                {{--<div class="form-group">--}}
                {{--<label for="exampleInputName3">菜品评分</label>--}}
                {{--<input type="number" name="rating" value="{{$food->rating}}" class="form-control" id="exampleInputName3" placeholder="菜品评分">--}}
                {{--</div>--}}
                <div class="form-group">
                    <label for="exampleInputName4">菜品价格</label>
                    <input type="number" name="price" value="{{$food->price}}" class="form-control" id="exampleInputName4" placeholder="菜品价格">
                </div>
                <div class="form-group">
                    <label for="exampleInputName5">菜品月销</label>
                    <input type="number" name="month_sales" value="{{$food->month_sales}}" class="form-control" id="exampleInputName5" placeholder="菜品月销">
                </div>
                <div class="form-group">
                    <label for="exampleInputName6">月评论数</label>
                    <input type="number" name="rating_count" value="{{$food->rating_count}}" class="form-control" id="exampleInputName6" placeholder="月评论数">
                </div>
                <div class="form-group">
                    <label for="exampleInputName7">菜品广告</label>
                    <input type="text" name="tips" value="{{$food->tips}}" class="form-control" id="exampleInputName7" placeholder="菜品广告">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail8">菜品简述</label>
                    <input type="text" name="desc" value="{{$food->desc}}" class="form-control" id="exampleInputEmail8" placeholder="菜品简述">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail9">菜品评论</label>
                    <input type="text" name="comment" value="{{$food->comment}}" class="form-control" id="exampleInputEmail9" placeholder="菜品评论">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail10">菜品规格</label>
                    <input type="number" name="norm" value="{{$food->norm}}" class="form-control" id="exampleInputEmail10" placeholder="菜品规格">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail10">所属菜类</label>
                    <select name="food_cates_id" class="form-control">
                        @foreach($foodcates as $row)
                            <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success form-control">提交!</button>
                {{csrf_field()}}
                {{ method_field('PUT') }}
            </form>
        </div>
        <div class="col-sm-3"><img src="{{$food->logo}}" alt=""></div>
    </div>
@stop