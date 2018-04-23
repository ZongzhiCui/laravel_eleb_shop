<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodCate extends Model
{
    protected $fillable = [
        'name','business_id','description','type_accumulation','is_selected',
    ];
    public function shop_business()
    {
        return $this->belongsTo(shop_business::class,'business_id')->withDefault([
            'business_id' => '数据不存在!',
        ]);
    }
}
