<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttentionHouse
 * @package App\Models
 * @version October 29, 2018, 10:34 am CST
 *
 * @property integer hourse_id
 * @property integer house_id
 * @property integer user_id
 */
class AttentionHouse extends Model
{
    use SoftDeletes;

    public $table = 'attention_houses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'house_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'house_id' => 'integer',
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
