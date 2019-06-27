<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HouseJoin
 * @package App\Models
 * @version October 15, 2018, 5:31 pm CST
 *
 * @property integer house_id
 * @property integer user_id
 * @property float price
 * @property string number
 * @property string pay_status
 */
class HouseJoin extends Model
{
    use SoftDeletes;

    public $table = 'house_joins';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'house_id',
        'user_id',
        'price',
        'number',
        'pay_status',
        'pay_platform',
        'hetong',
        'receive_man',
        'receive_mobile',
        'receive_address',
        'body',
        'gear_num',
        'gear'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'house_id' => 'integer',
        'user_id' => 'integer',
        'price' => 'float',
        'number' => 'string',
        'pay_status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function house(){
        return $this->belongsTo('App\Models\House');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getTrClassAttribute(){
        $trclass= trclass();
        $status = 0;
        if($this->pay_status == '未支付'){
            $status = 2;
        }
        elseif($this->pay_status == '已支付'){
            $status = 0;
        }
        else{
            $status = 10;
        }
        return trclass($status);
    }
    
}
