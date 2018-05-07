<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnevtPrizes extends Model
{
    //关联商户ID用于显示获奖名字
    public function user()
    {
        return $this->belongsTo(shop_user::class,'member_id');
    }
}
