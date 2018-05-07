<?php

namespace App\Http\Controllers;

use App\Models\EnevtPrizes;
use App\Models\Event;
use App\Models\EventMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    //查看活动列表
    public function index()
    {
        $events = Event::paginate(8);
        return view('event.index',compact('events'));
    }
    //查看活动详情
    public function show(Event $event)
    {
        //获取奖品列表
        $eventPrizes = DB::table('enevt_prizes')->get();
        //获奖名单
        $winnersLists = EnevtPrizes::where([   //查奖品表
            ['events_id','=',$event->id],         //条件1 活动ID
            ['member_id','<>',0]                  //条件2 奖品有获奖者
        ])->paginate(10);
        return view('event.show',compact('event','eventPrizes','winnersLists'));
    }
    //添加参加活动的人
    public function createEventMember(Request $request)
    {
        //同一活动一人只能参加一次
        $already = EventMembers::where([
            ['events_id',$request->id],
            ['member_id',Auth::user()->id]
        ]);
        if ($already != null){
            return ['danger'=>'同一活动一人只能参加一次'];
        }
//        dd($request->id);
//        Auth::user()->email;
        EventMembers::create([
            'events_id'=>$request->id,
            'member_id'=>Auth::user()->id,
        ]);
        $event = Event::find($request->id)->signup_num;//活动表的限制人数
        $count = DB::table('event_members')->where('events_id',$request->id)->count();//参加活动的人数
        $data = [
            'success'=>true,
            'danger'=>'参加活动成功!'
        ];
        if ($event <= $count){
            $data['success'] = false;
        }
        return $data;
    }
}
