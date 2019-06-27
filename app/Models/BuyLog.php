<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BuyLog
 * @package App\Models
 * @version January 9, 2019, 4:52 pm CST
 *
 * @property string product_name
 * @property float price
 * @property string name
 * @property string mobile
 * @property string address
 * @property string pay_platform
 * @property string pay_status
 * @property string number
 */
class BuyLog extends Model
{
    use SoftDeletes;

    public $table = 'buy_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'price',
        'name',
        'mobile',
        'address',
        'pay_platform',
        'pay_status',
        'number',
        'share_platform'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
        'name' => 'string',
        'mobile' => 'string',
        'address' => 'string',
        'pay_platform' => 'string',
        'pay_status' => 'string',
        'number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


    public function items()
    {
        return $this->hasMany('App\Models\BuyItems','order_id','id');
    }

    
}
