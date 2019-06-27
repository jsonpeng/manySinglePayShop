<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostUser
 * @package App\Models
 * @version November 27, 2018, 11:35 am CST
 *
 * @property integer post_id
 * @property integer user_id
 */
class PostUser extends Model
{
    use SoftDeletes;

    public $table = 'post_users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'post_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'post_id' => 'integer',
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
