<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\shop_business;
use App\SignatureHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
    //前端AJAX显示按钮
    public function button(Order $button)
    {
        //未验证!!
        $status = Order::find($button->id)->order_status;
        return $status;
    }
    //查看里面有个商家接单按钮
    public function acceptOrder(Order $order)
    {
        $order->update(['order_status'=>1]);
        $this->sendSms($order->receipt_tel);
        return '已接单';
    }

    /**
     * 发送短信
     */
    function sendSms($tel) {
        $params = array ();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "LTAIzKh1EmME4I6Q";
        $accessKeySecret = "MB2AePM9RVQ3Kd11z69w6XCwiPncvS";

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $tel;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "天天披萨";

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "SMS_134120495";

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => mt_rand(100000,999999),
//            "product" => "阿里通信"
        );
//        Redis::setex('code'.$request->tel,600,$params['TemplateParam']['code']);
//        dd(Redis::get('code'));

        // fixme 可选: 设置发送短信流水号
//        $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
//        $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        // fixme 选填: 启用https
        // ,true
        );
//        dd($content);
        //同一手机一分钟只能发送一条短信.一小时5条.一天最多10条
        /*{#209
            +"Message": "OK"
        +"RequestId": "66F6A9A9-6A3B-403F-8C9C-CDF212E378EF"
        +"BizId": "946819824712443743^0"
        +"Code": "OK"
        }*/
        if ($content->Message == 'OK'){
            //短信发送成功!
            return ["status"=> "true",
                "message"=> "获取短信验证码成功"];
        }else{
            //发送失败
            return ["status"=> "false",
                "message"=> "获取短信验证码失败!稍后再试"];
        }
//        return $content;
    }


    //订单统计
    public function orderCount()
    {
        $shop_id = Auth::user()->business_id;
        $total = DB::select("select count('id') as total from `orders` where shop_id={$shop_id}")[0]->total;
//        $month = DB::select("select count('id') as m from `orders` where created_at between ? and ?",[date('Y-m-1 00:00:00'),date('Y-m-1 00:00:00',strtotime('next month'))])[0]->m;
//        $day = DB::select("select count('id') as d from `orders` where created_at>? and created_at<?",[date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00',strtotime('+1 day'))])[0]->d;
        $month = DB::select("select count('id') as m from `orders` where shop_id={$shop_id} and created_at like ?",[date('Y-m').'%'])[0]->m;
        $day = DB::select("select count('id') as m from `orders` where shop_id={$shop_id} and created_at like ?",[date('Y-m-d').'%'])[0]->m;
        return view('shop_business.orderCount',compact('total','month','day'));
    }
    //按时间查看订单统计
    public function orderTime(Request $request)
    {
        $shop_id = Auth::user()->business_id;
        if ($request->date==null and $request->month==null and ($request->datetime1==null or $request->datetime2==null)){
            return back()->withInput()->with('danger','请输入要搜索的日期!');
        }
        if ($request->date!=null){
            $date = $request->date;
            $count = DB::select("select count('id') as m from `orders` where shop_id={$shop_id} and created_at LIKE ?",[$date.'%'])[0]->m;
        }elseif ($request->month!=null){
            $date = $request->month;
            $count = DB::select("select count('id') as m from `orders` where shop_id={$shop_id} and created_at LIKE ?",[$date.'%'])[0]->m;
        }elseif($request->datetime1!=null and $request->datetime2!=null){
            $date = $request->datetime1;
            $date1 = $request->datetime2;
//            dd($date,$date1);
            $count = DB::select("select count('id') as m from `orders` where shop_id={$shop_id} and created_at between ? and ?",[$date,$date1])[0]->m;
        }
        return view('shop_business.orderTime',compact('count'));
    }

    /**- 菜品销量统计[按日统计,按月统计,累计]（每日、每月、总计） **/
    //菜品统计
    public function foodCount()
    {
        //查询当前用户的店铺的订单id
        $shop_id = Auth::user()->business_id;
        $orders = Order::where('shop_id',$shop_id)->get();
        $ids = [];
        foreach ($orders as $row){
            $ids[] = $row->id;
        }
        $str = implode(',',$ids);
        //判断
        $total = DB::select("select foods_id,sum(foods_amount) as total from `order_foods` where order_id in ($str) GROUP by `foods_id` order BY total desc");
//        $month = DB::select("select count('id') as m from `orders` where created_at between ? and ?",[date('Y-m-1 00:00:00'),date('Y-m-1 00:00:00',strtotime('next month'))])[0]->m;
//        $day = DB::select("select count('id') as d from `orders` where created_at>? and created_at<?",[date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00',strtotime('+1 day'))])[0]->d;
        $month = DB::select("select foods_id,sum(foods_amount) as m from `order_foods` WHERE order_id in ($str) and created_at like ? GROUP by `foods_id` order BY m desc",[date('Y-m').'%']);
        $day = DB::select("select foods_id,sum(foods_amount) as d from `order_foods` where order_id in ($str) and created_at like ? GROUP by `foods_id` order BY d desc",[date('Y-m-d').'%']);
        return view('shop_business.foodCount',compact('total','month','day'));
    }
    //按时间查看订单统计
    public function foodTime(Request $request)
    {
        //查询当前用户的店铺的订单id
        $shop_id = Auth::user()->business_id;
        $orders = Order::where('shop_id',$shop_id)->get();
        $ids = [];
        foreach ($orders as $row){
            $ids[] = $row->id;
        }
        $str = implode(',',$ids);
        //判断
        if ($request->date==null and $request->month==null and ($request->datetime1==null or $request->datetime2==null)){
            return back()->withInput()->with('danger','请输入要搜索的日期!');
        }
        if ($request->date!=null){
            $date = $request->date;
            $count = DB::select("select foods_id,sum(foods_amount) as d from `order_foods` where order_id in ($str) and created_at like ? GROUP by `foods_id` ORDER by d desc",[$date.'%']);
        }elseif ($request->month!=null){
            $date = $request->month;
            $count = DB::select("select foods_id,sum(foods_amount) as d from `order_foods` WHERE order_id in ($str) and created_at like ? GROUP by `foods_id` order BY d desc",[$date.'%']);
        }elseif($request->datetime1!=null and $request->datetime2!=null){
            $date = $request->datetime1;
            $date1 = $request->datetime2;
            $count = DB::select("select foods_id,sum(foods_amount) as d from `order_foods` where order_id in ($str) and created_at between ? and ? GROUP by `foods_id` order BY d desc",[$date,$date1]);
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
