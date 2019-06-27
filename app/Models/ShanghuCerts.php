<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ShanghuCerts
 * @package App\Models
 * @version November 5, 2018, 5:06 pm CST
 *
 * @property string name
 * @property string work_image
 * @property string shop_image
 * @property integer user_id
 */
class ShanghuCerts extends Model
{
    use SoftDeletes;

    public $table = 'shanghu_certs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'work_image',
        'shop_image',
        'status',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'work_image' => 'string',
        'shop_image' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
