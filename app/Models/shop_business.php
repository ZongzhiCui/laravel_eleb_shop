<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shop_business extends Model
{
    protected $table = 'shop_businesses';
    protected $fillable = [
        'shop_name','shop_img','shop_rating','brand','on_time','fengniao',
        'bao','zhun','start_send','send_cost','estimate_time','notice','discount',
    ];

    public function shop_user()
    {
        return $this->belongsTo(shop_user::class,'id')->withDefault([
            'id' => '数据不存在!',
        ]);
    }
}
