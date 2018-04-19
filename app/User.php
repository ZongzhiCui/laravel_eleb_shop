<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'shop_users';
//    protected $table = 'users';  默认!
//    protected $primaryKey = 'my_id';
//    public $incrementing = false;  //如果你使用的不是自增的或者非数值类型的主键字段
//    public $timestamps = false;
//    protected $dateFormat = 'U'; 如下
//如果要自定义时间戳保存在数据库里的格式，就需要设置 $dateFormat 属性。这个属性决定时间戳字段保存在数据库里的格式，还有保存在序列化数组 / JSON 里的格式：

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','head','balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
//    protected $remember_token = '';
}
