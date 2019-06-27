<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AttachPostComment
 * @package App\Models
 * @version August 30, 2018, 5:02 pm CST
 *
 * @property integer user_id
 * @property integer reply_user_id
 * @property integer comment_id
 * @property string content
 * @property integer zan
 */
class AttachPostComment extends Model
{
    use SoftDeletes;

    public $table = 'attach_post_comments';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'reply_user_id',
        'comment_id',
        'content',
        'zan'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'reply_user_id' => 'integer',
        'comment_id' => 'integer',
        'content' => 'string',
        'zan' => 'integer'
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
