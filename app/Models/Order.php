<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // 暂时由于User表被 商铺管理人员表shop_users占用了 所以查看不了前端买家的users信息
    /**public function user()
    {
        return $this->belongsTo(\App\User::class, 'users_id')
            ->withDefault(['username'=>'空-','tel'=>'未知']);
    }*/
}
