@extends('layout.default')
@section('title',$activity->name)
@section('content')
    <div class="row">
        <div class="col-sm-10">
            <a href="/" class="btn btn-info">活动列表</a>
            <h2>活动编号::{{$activity->id}}<sup style="color: red">{{$activity->end_time<date('Y-m-d')?'该活动已过期!':''}}</sup></h2>
            <h5>活动标题::{{$activity->title}}</h5>
            <p>活动内容::</p>
                <div>
            <textarea name="contents" id="container" cols="60" rows="8">
                {!! $activity->content !!}
            </textarea>
{{--                <!-- 配置文件 -->
                <script type="text/javascript" src="/utf8-php/ueditor.config.js"></script>
                <!-- 编辑器源码文件 -->
                <script type="text/javascript" src="/utf8-php/ueditor.all.js"></script>
                <!-- 实例化编辑器 -->
                <script type="text/javascript">
                    var ue = UE.getEditor('container');
                </script>--}}
            </div>

            <h5>开始时间::{{$activity->start_time}}</h5>
            <h5>结束时间::{{$activity->end_time}}</h5>
        </div>
    </div>
@stop