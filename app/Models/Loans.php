<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Loans
 * @package App\Models
 * @version August 17, 2018, 3:37 pm CST
 *
 * @property string name
 * @property string image
 * @property string link
 * @property double edu_qi
 * @property double edu_zhi
 * @property integer qixian_qi
 * @property integer qixian_zhi
 * @property string qixian_type
 * @property double lilv
 * @property integer num
 */
class Loans extends Model
{
    use SoftDeletes;

    public $table = 'loans';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'link',
        'edu_qi',
        'edu_zhi',
        'qixian_qi',
        'qixian_zhi',
        'qixian_type',
        'lilv',
        'num'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'link' => 'string',
        'edu_qi' => 'double',
        'edu_zhi' => 'double',
        'qixian_qi' => 'integer',
        'qixian_zhi' => 'integer',
        'qixian_type' => 'string',
        'lilv' => 'double',
        'num' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    
}
