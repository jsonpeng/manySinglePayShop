<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Notices
 * @package App\Models
 * @version September 5, 2018, 9:52 am CST
 *
 * @property string content
 * @property string link
 * @property integer user_id
 */
class Notices extends Model
{
    use SoftDeletes;

    public $table = 'notices';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'link',
        'user_id',
        'read'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
        'link' => 'string',
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
