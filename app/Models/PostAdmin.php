<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostAdmin
 * @package App\Models
 * @version November 27, 2018, 11:39 am CST
 *
 * @property integer post_id
 * @property integer admin_id
 */
class PostAdmin extends Model
{
    use SoftDeletes;

    public $table = 'post_admins';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'post_id',
        'admin_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'post_id' => 'integer',
        'admin_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
