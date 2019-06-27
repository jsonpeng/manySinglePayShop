<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttachHouseBoard
 * @package App\Models
 * @version November 7, 2018, 5:44 pm CST
 *
 * @property string content
 * @property integer message_id
 * @property integer user_id
 * @property integer reply_user_id
 */
class AttachHouseBoard extends Model
{
    use SoftDeletes;

    public $table = 'attach_house_boards';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
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
