<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttentionGol
 * @package App\Models
 * @version November 8, 2018, 4:03 pm CST
 *
 * @property integer gol_id
 * @property integer user_id
 */
class AttentionGol extends Model
{
    use SoftDeletes;

    public $table = 'attention_gols';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'gol_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'gol_id' => 'integer',
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
