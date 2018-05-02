<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\shop_business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ShopBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //订单列表
            //1.先根据登录的用户查询对应的 商铺ID 去查询订单里有商铺的订单
            $shop_user = Auth::user()->business_id;
        $orders = Order::where('shop_id',$shop_user)->paginate(5);
        foreach ($orders as $order){
            $user = DB::table('users')->find($order->users_id);
            $order->user_tel = $user->username.':'.$user->tel;
        }
        return view('shop_business.index',compact('orders'));
    }

    //订单详情!!!
    public function orderShow(Order $order)
    {
        $order = Order::find($order->id);
        //拼如.创建时间,商品数组,地址拼接
        //需要查询出商品数组 根据$order->id 从order_foods表里查
        $goods_list = DB::table('order_foods')->where('order_id',$order->id)->get();
//            dd($goods_list);
        foreach ($goods_list as $good){
            $good->goods_id = $good->foods_id;
            $good->goods_name = $good->foods_name;
            $good->goods_img = $good->foods_logo;
            $good->amount = $good->foods_amount;
            $good->goods_price = $good->foods_price;
        }
        $order->order_birth_time = substr($order->created_at,0,16);
        $order->order_status = $order->order_status==0?'代付款':'已付款';
        $order->goods_list = $goods_list;
        $order->order_address = $order->receipt_provence.$order->receipt_city.$order->receipt_area.$order->receipt_detail_address.$order->receipt_name.$order->receipt_tel;
        return view('shop_business.orderShow',compact('order'));
    }

    //订单统计
    public function orderCount()
    {
        $total = DB::select("select count('id') as total from `orders`")[0]->total;
//        $month = DB::select("select count('id') as m from `orders` where created_at between ? and ?",[date('Y-m-1 00:00:00'),date('Y-m-1 00:00:00',strtotime('next month'))])[0]->m;
//        $day = DB::select("select count('id') as d from `orders` where created_at>? and created_at<?",[date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00',strtotime('+1 day'))])[0]->d;
        $month = DB::select("select count('id') as m from `orders` where created_at like ?",[date('Y-m').'%'])[0]->m;
        $day = DB::select("select count('id') as m from `orders` where created_at like ?",[date('Y-m-d').'%'])[0]->m;
        return view('shop_business.orderCount',compact('total','month','day'));
    }
    //按时间查看订单统计
    public function orderTime(Request $request)
    {
        if ($request->date==null and $request->month==null and ($request->datetime1==null or $request->datetime2==null)){
            return back()->withInput()->with('danger','请输入要搜索的日期!');
        }
        if ($request->date!=null){
            $date = $request->date;
            $count = DB::select("select count('id') as m from `orders` where created_at LIKE ?",[$date.'%'])[0]->m;
        }elseif ($request->month!=null){
            $date = $request->month;
            $count = DB::select("select count('id') as m from `orders` where created_at LIKE ?",[$date.'%'])[0]->m;
        }elseif($request->datetime1!=null and $request->datetime2!=null){
            $date = $request->datetime1;
            $date1 = $request->datetime2;
//            dd($date,$date1);
            $count = DB::select("select count('id') as m from `orders` where created_at between ? and ?",[$date,$date1])[0]->m;
        }
        return view('shop_business.orderTime',compact('count'));
    }

    /**- 菜品销量统计[按日统计,按月统计,累计]（每日、每月、总计） **/
    //菜品统计
    public function foodCount()
    {
        $total = DB::select("select foods_id,sum(foods_amount) as total from `order_foods` GROUP by `foods_id` order BY total desc");
//        $month = DB::select("select count('id') as m from `orders` where created_at between ? and ?",[date('Y-m-1 00:00:00'),date('Y-m-1 00:00:00',strtotime('next month'))])[0]->m;
//        $day = DB::select("select count('id') as d from `orders` where created_at>? and created_at<?",[date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00',strtotime('+1 day'))])[0]->d;
        $month = DB::select("select foods_id,sum(foods_amount) as m from `order_foods` WHERE created_at like ? GROUP by `foods_id` order BY m desc",[date('Y-m').'%']);
        $day = DB::select("select foods_id,sum(foods_amount) as d from `order_foods` where created_at like ? GROUP by `foods_id` order BY d desc",[date('Y-m-d').'%']);
        return view('shop_business.foodCount',compact('total','month','day'));
    }
    //按时间查看订单统计
    public function foodTime(Request $request)
    {
        if ($request->date==null and $request->month==null and ($request->datetime1==null or $request->datetime2==null)){
            return back()->withInput()->with('danger','请输入要搜索的日期!');
        }
        if ($request->date!=null){
            $date = $request->date;
            $count = DB::select("select foods_id,sum(foods_amount) as d from `order_foods` where created_at like ? GROUP by `foods_id` ORDER by d desc",[$date.'%']);
        }elseif ($request->month!=null){
            $date = $request->month;
            $count = DB::select("select foods_id,sum(foods_amount) as d from `order_foods` WHERE created_at like ? GROUP by `foods_id` order BY d desc",[$date.'%']);
        }elseif($request->datetime1!=null and $request->datetime2!=null){
            $date = $request->datetime1;
            $date1 = $request->datetime2;
            $count = DB::select("select foods_id,sum(foods_amount) as d from `order_foods` where created_at between ? and ? GROUP by `foods_id` order BY d desc",[$date,$date1]);
        }
        return view('shop_business.foodTime',compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\shop_business  $shop_business
     * @return \Illuminate\Http\Response
     */
    public function show(shop_business $shop_business)
    {
        return view('shop_business.show',compact('shop_business'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\shop_business  $shop_business
     * @return \Illuminate\Http\Response
     */
    public function edit(shop_business $shop_business)
    {
        return view('shop_business.edit',compact('shop_business'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\shop_business  $shop_business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, shop_business $shop_business)
    {
        $this->validate($request,[
//            'shop_img'=>'required|image',
            'shop_rating'=>'numeric',
            'start_send'=>'required',
            'send_cost'=>'required',
            'estimate_time'=>'required',
        ],[

        ]);
/**        $thumb = 270;
        $filename = $request->file('shop_img')->store('public/date'.date('md'));
        $path_parts = pathinfo(Storage::url($filename)); //Storage::url($filename);这个才是可用的图片路径
        $i_mg = $path_parts['dirname'].'/'.$path_parts['filename'].'_'.$thumb.'X'.$thumb.'.'.$path_parts['extension']; //拼接缩略图文件路径

//        dd(Storage::url($filename));  //"/storage/date0419/v5ihKAwkpRJrss9eOkjcui9OEd1F7TmkaC9FSQK9.jpeg"
//        dd($filename);  //public/date0419/nY74PQjcTyZEsRfxZHm3gYP00vJkOOfXOMR8FgiM.jpeg
        $img = Image::make(public_path().Storage::url($filename))->resize($thumb, $thumb);//图片资源必须绝对路径!缩略图
//        dd($i_mg);die;
        $img->save(public_path().$i_mg); //图片资源必须绝对路径!缩略图*/
        //保存数据库的文件路径为相对路径 ,.及网站根目录
        $shop_business->update([
            'shop_img'=>$request->logo,
            'shop_rating'=>$request->shop_rating,
            'brand'=>$request->brand??0,
            'on_time'=>$request->on_time??0,
            'fengniao'=>$request->fengniao??0,
            'bao'=>$request->bao??0,
            'piao'=>$request->piao??0,
            'zhun'=>$request->zhun??0,
            'start_send'=>$request->start_send,
            'send_cost'=>$request->send_cost,
            'estimate_time'=>$request->estimate_time,
            'notice'=>$request->notice??'',
            'discount'=>$request->discount??'',
        ]);
        return redirect()->route('shop_business.show',compact('shop_business'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\shop_business  $shop_business
     * @return \Illuminate\Http\Response
     */
    public function destroy(shop_business $shop_business)
    {
        //
    }
}
