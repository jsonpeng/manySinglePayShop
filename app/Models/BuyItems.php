<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BuyItems
 * @package App\Models
 * @version January 10, 2019, 10:19 pm CST
 *
 * @property string access_ip
 * @property string product_name
 * @property float price
 * @property integer num
 */
class BuyItems extends Model
{
    use SoftDeletes;

    public $table = 'buy_items';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'access_ip',
        'product_name',
        'product_img',
        'price',
        'num',
        'order_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'access_ip' => 'string',
        'product_name' => 'string',
        'price' => 'float',
        'num' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
