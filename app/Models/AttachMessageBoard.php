<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttachMessageBoard
 * @package App\Models
 * @version September 6, 2018, 11:44 am CST
 *
 * @property string content
 * @property integer zan
 * @property integer message_id
 * @property integer user_id
 * @property integer replay_user_id
 */
class AttachMessageBoard extends Model
{
    use SoftDeletes;

    public $table = 'attach_message_boards';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'zan',
        'message_id',
        'user_id',
        'reply_user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
        'zan' => 'integer',
        'message_id' => 'integer',
        'user_id' => 'integer',
        'reply_user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function replyuser(){
        return $this->belongsTo('App\User','reply_user_id','id');
    }

    
}
