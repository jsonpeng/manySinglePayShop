<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Cities;

/**
 * Class House
 * @package App\Models
 * @version October 14, 2018, 11:25 pm CST
 *
 * @property string name
 * @property string address
 * @property string content
 * @property integer view
 * @property float gear
 * @property string type
 * @property float target
 * @property string status
 * @property string endtime
 */
class House extends Model
{
    use SoftDeletes;

    public $table = 'houses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'address',
        'image',
        'content',
        'view',
        'gear',
        'type',
        'target',
        'status',
        'endtime',
        'user_id',
        'province',
        'city',
        'district',
        'lat',
        'lon',
        'plan_address',
        'index_show',
        'put_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'content' => 'string',
        'view' => 'integer',
        'type' => 'string',
        'target' => 'float',
        'status' => 'string',
        'endtime' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required',
        'target' => 'required',
        'endtime' => 'required'
    ];

    //支持的人
    public function join(){
        return $this->hasMany('App\Models\HouseJoin','house_id','id');
    }

    //发布小屋的人
    public function user(){
        return $this->belongsTo('App\User');
    }


    public function getAddressAttribute(){
        return getCitiesNameById($this->province).getCitiesNameById($this->city);
    }

    
}
