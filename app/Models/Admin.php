<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;

// use Zizaco\Entrust\Traits\EntrustUserTrait;


class Admin extends AuthenticatableUser implements AuthenticatableContract{

    use Authenticatable, Notifiable;
    /** 
     * The attributes that are mass assignable. 
     * 
     * @var array 
     */ 
    protected $fillable = [ 
        'name', 'email', 'password', 'type','system_tag'
    ]; 
 
    /** 
     * The attributes that should be hidden for arrays. 
     * 
     * @var array 
     */ 
    protected $hidden = [ 
        'password', 'remember_token', 
    ];

    public function getShowNameAttribute()
    {
        return $this->nickname ? $this->nickname : '管理员编号:'.$this->id;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
