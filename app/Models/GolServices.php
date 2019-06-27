<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class GolServices
 * @package App\Models
 * @version November 8, 2018, 11:38 am CST
 *
 * @property string name
 * @property string group
 * @property string image
 */
class GolServices extends Model
{
    use SoftDeletes;

    public $table = 'gol_services';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'group',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'group' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
       'name' => 'required',
    ];

    
}
