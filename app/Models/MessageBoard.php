<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MessageBoard
 * @package App\Models
 * @version September 6, 2018, 11:29 am CST
 *
 * @property string content
 * @property integer zan
 * @property integer user_id
 */
class MessageBoard extends Model
{
    use SoftDeletes;

    public $table = 'message_boards';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'zan',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
        'zan' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function attach(){
        return $this->hasMany('App\Models\AttachMessageBoard','message_id','id');
    }


    public function user(){
        return $this->belongsTo('App\User');
    }

    
}
