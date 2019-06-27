<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostComment
 * @package App\Models
 * @version August 30, 2018, 4:56 pm CST
 *
 * @property integer post_id
 * @property string content
 * @property integer user_id
 * @property integer zan
 */
class PostComment extends Model
{
    use SoftDeletes;

    public $table = 'post_comments';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'post_id',
        'content',
        'user_id',
        'zan'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'post_id' => 'integer',
        'content' => 'string',
        'user_id' => 'integer',
        'zan' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function attach(){
        return $this->hasMany('App\Models\AttachPostComment','comment_id','id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    
}
