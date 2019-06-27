<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttachHouse
 * @package App\Models
 * @version October 15, 2018, 10:17 am CST
 *
 * @property integer house_id
 * @property string key
 * @property string value
 */
class AttachHouse extends Model
{
    use SoftDeletes;

    public $table = 'attach_houses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'house_id',
        'key',
        'value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'house_id' => 'integer',
        'key' => 'string',
        'value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
