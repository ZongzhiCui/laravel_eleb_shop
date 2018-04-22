<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodCate extends Model
{
    protected $table = [
        'name','business_id','description','type_accumulation','is_selected',
    ];
//    public function shop_user()
//    {
//        return $this->belongsTo(shop_user::class,'id')->withDefault([
//            'id' => '数据不存在!',
//        ]);
//    }
}
