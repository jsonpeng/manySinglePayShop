<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Gol
 * @package App\Models
 * @version October 25, 2018, 5:38 pm CST
 *
 * @property string name
 * @property string image
 * @property string brief
 * @property string content
 * @property string xukezheng
 * @property integer zuqi
 * @property float area
 * @property string address
 * @property string hourse_status
 * @property string gaizao_status
 * @property integer publish_status
 * @property float price
 * @property string give_word
 */
class Gol extends Model
{
    use SoftDeletes;

    public $table = 'gols';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'brief',
        'content',
        'xukezheng',
        'zuqi',
        'area',
        'address',
        'hourse_status',
        'gaizao_status',
        'publish_status',
        'price',
        'give_word',
        'type',
        'user_id',
        'province',
        'city',
        'district',
        'lat',
        'lon',
        'hourse_type',
        'services',
        'water_price',
        'electric_price',
        'mei_price',
        'ranqi_price',
        'service_price',
        'other_price',
        'zuqi_type',
        'view'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'brief' => 'string',
        'content' => 'string',
        'xukezheng' => 'string',
        'zuqi' => 'integer',
        'area' => 'float',
        'address' => 'string',
        'hourse_status' => 'string',
        'gaizao_status' => 'string',
        'publish_status' => 'integer',
        'price' => 'float',
        'give_word' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //发布状态
    public function getfabuStatusAttribute(){
         //0审核中1已发布2下架
        if($this->publish_status == 0){
            return '审核中';
        }
        elseif($this->publish_status == 1){
            return '已发布';
        }
        elseif($this->publish_status == 2){
            return '下架';
        }
    }

    //把服务设施处理为数组
    public function getServicesArrAttribute()
    {
        return explode(',',$this->services);
    }

    public function cityobj()
    {
        return $this->belongsTo('App\Models\Cities','city','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->belongsToMany('App\User','attention_gols','gol_id','user_id');
    }

}
