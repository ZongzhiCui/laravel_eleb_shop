@extends('layout.default')
@section('title',$event->name)
@section('content')
    <div class="row">
        <div class="col-sm-5">
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

        </div>
        <div class="col-sm-4">
            <br><br><h5>活动奖品:</h5>
            @foreach($eventPrizes as $row)
                {{ $row->name }}<br>
            @endforeach
            <button id="myButton" class="btn btn-sm btn-primary" data-id="{{ $event->id }}">我要参加</button>
            {{--{{ $eventPrizes->links() }}--}}
        </div>
        <div class="col-sm-3" id="jiang" data-is_prize="{{ $event->is_prize }}">
            <br><br><h5>获奖人员名单:</h5>
            <h6 class="" style="color: red">等待开奖!!!.....</h6>
            <table class="table table-bordered hidden">
                <tr>
                    <th>获奖人</th>
                    <th>奖品</th>
                </tr>
                @foreach($winnersLists as $val)
                <tr>
                    <td>{{ $val->user->email }}</td>
                    <td>{{ $val->name }}</td>
                </tr>
                @endforeach
                {{ $winnersLists->links() }}
            </table>
        </div>
    </div>
@stop

@section('jquery')
    <script type="text/javascript">
        $(function () {
            //参加活动按钮
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
            //获奖名单显示!!需求:开奖之后再显示
            if ($('#jiang').data('is_prize') == '1'){
                $('#jiang h6').toggleClass('hidden');
                $('#jiang table').toggleClass('hidden');
            }
        })
    </script>
@stop