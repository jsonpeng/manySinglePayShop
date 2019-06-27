<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SharePlatform
 * @package App\Models
 * @version January 17, 2019, 5:02 pm CST
 *
 * @property string name
 * @property string link
 * @property string qrcode
 */
class SharePlatform extends Model
{
    use SoftDeletes;

    public $table = 'share_platforms';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'link',
        'qrcode'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'link' => 'string',
        'qrcode' => 'string'
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
