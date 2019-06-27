<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Certs
 * @package App\Models
 * @version November 27, 2018, 4:57 pm CST
 *
 * @property string type
 * @property string organization_name
 * @property string organization_code
 * @property string organization_img
 * @property string id_card_name
 * @property string id_card_num
 * @property string id_card_time_type
 * @property string id_card_end_time
 * @property string id_card_zhengmian
 * @property string id_card_fanmian
 * @property string id_card_shouchi
 */
class Certs extends Model
{
    use SoftDeletes;

    public $table = 'certs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'type',
        'organization_name',
        'organization_code',
        'organization_img',
        'id_card_name',
        'id_card_num',
        'id_card_time_type',
        'id_card_end_time',
        'id_card_zhengmian',
        'id_card_fanmian',
        'id_card_shouchi',
        'user_id',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'organization_name' => 'string',
        'organization_code' => 'string',
        'organization_img' => 'string',
        'id_card_name' => 'string',
        'id_card_num' => 'string',
        'id_card_time_type' => 'string',
        'id_card_end_time' => 'string',
        'id_card_zhengmian' => 'string',
        'id_card_fanmian' => 'string',
        'id_card_shouchi' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'type' => 'required',
        // 'id_card_name'=> 'required',
        // 'id_card_num'=> 'required',
        // 'id_card_time_type'=> 'required',
        // 'id_card_end_time'=> 'required',
        // 'id_card_zhengmian'=> 'required',
        // 'id_card_fanmian'=> 'required',
        // 'id_card_shouchi'=> 'required'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    
}
