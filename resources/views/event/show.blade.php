@extends('layout.default')
@section('title',$event->name)
@section('content')
    <div class="row">
        <div class="col-sm-10">
            <a href="{{ route('event.index') }}" class="btn btn-info">活动列表</a>
            <h2>活动ID::{{$event->id}}</h2>
            <h5>活动标题::{{$event->title}}</h5>
            <p>活动内容::
                {!! $event->content !!}
            </p>
            <h5>开始时间::{{ date('Y-m-d H:i:s',$event->signup_start) }}</h5>
            <h5>结束时间::{{ date('Y-m-d H:i:s',$event->signup_end) }}</h5>
            <h5>开奖时间::{{ $event->prize_date }}</h5>
            <h5>活动限制人数::{{ $event->signup_num }}</h5>
            <button id="myButton" class="btn btn-sm btn-primary" data-id="{{ $event->id }}">我要参加</button>
        </div>
    </div>
@stop

@section('jquery')
    <script type="text/javascript">
        $(function () {
            $('#myButton').on('click',function () {
                var id = $(this).data('id');
                $.ajax({
                    type: "POST",
                    url: "/createEventMember",
                    data: "id="+id+"&_token={{csrf_token()}}",
                    success: function(msg){
                        layer.msg(msg.danger, function(){
                            //关闭后的操作
                        });
                        if (msg.success === false){
                            $('#myButton').prop('disabled',true);
                        }
                    }
                });
            })
        })
    </script>
@stop