<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HeZuo
 * @package App\Models
 * @version December 17, 2018, 7:31 pm CST
 *
 * @property string image
 * @property string type
 */
class HeZuo extends Model
{
    use SoftDeletes;

    public $table = 'he_zuos';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'image',
        'type',
        'link'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'string',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'image' => 'required',
        'link' => 'required',
    ];

    
}
