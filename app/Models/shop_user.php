<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shop_user extends Model
{
    protected $table = 'shop_users';
    protected $fillable = [
        'email','password','status','business_id',
    ];
    protected $hidden = [
        'password','remember_token',
    ];

    public function shop_business()
    {
        return $this->belongsTo(shop_business::class,'business_id')->withDefault([
            'id' => '',
        ]);
    }
}
