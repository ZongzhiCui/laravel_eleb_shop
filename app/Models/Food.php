<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    //与$fillable相反.排除字段
    protected $guarded = [];

    public function foodcate()
    {
        return $this->belongsTo(FoodCate::class,'food_cates_id')->withDefault([
            'food_cates_id' => '数据不存在!',
        ]);
    }
}
