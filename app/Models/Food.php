<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
//    //与$fillable相反.排除字段
    protected $guarded = [];
//    protected $fillable = [
//        'name','logo','rating','price','month_sales','rating_count','tips','desc',
//        'comment','norm','business_is','food_cates_id',
//    ];

    public function foodcate()
    {
        return $this->belongsTo(FoodCate::class,'food_cates_id')->withDefault([
            'food_cates_id' => '数据不存在!',
        ]);
    }
    public function shop_business()
    {
        return $this->belongsTo(shop_business::class,'business_is')->withDefault([
            'business_id' => '数据不存在!',
        ]);
    }
}
