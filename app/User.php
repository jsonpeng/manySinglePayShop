<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','head_image','mobile','last_login','last_ip','des','type','zichan','fuzhai','brief','nickname','official_accounts_name','official_accounts_erweima','sex','weixin','openid','good_writer','update_nickname_time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //认证信息
    public function cert(){
        return $this->hasOne('App\Models\Certs','user_id','id');
    }

    //收货地址列表
    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id', 'id');
    }


    public function getShowNameAttribute(){
        if(!empty($this->nickname)){
            return $this->nickname;
        }
        if(empty($this->name)){
            return $this->nickname;
        }
        else{
            return $this->name;
        }
    }
}
