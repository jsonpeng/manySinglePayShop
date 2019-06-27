<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostAttention
 * @package App\Models
 * @version November 29, 2018, 9:18 am CST
 *
 * @property integer post_id
 * @property integer user_id
 */
class PostAttention extends Model
{
    use SoftDeletes;

    public $table = 'post_attentions';
    

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
