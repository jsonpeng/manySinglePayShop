<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HouseBoard
 * @package App\Models
 * @version November 7, 2018, 5:37 pm CST
 *
 * @property integer house_id
 * @property string type
 * @property string content
 * @property integer user_id
 */
class HouseBoard extends Model
{
    use SoftDeletes;

    public $table = 'house_boards';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'house_id',
        'type',
        'content',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'house_id' => 'integer',
        'type' => 'string',
        'content' => 'string',
        'user_id' => 'integer'
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

    public function attach(){
        return $this->hasMany('App\Models\AttachHouseBoard','message_id','id');
    }
    
}
