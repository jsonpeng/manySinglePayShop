<?php

namespace App\Repositories;

use App\Models\Message;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MessageRepository
 * @package App\Repositories
 * @version November 9, 2017, 9:24 pm CST
 *
 * @method Message findWithoutFail($id, $columns = ['*'])
 * @method Message find($id, $columns = ['*'])
 * @method Message first($columns = ['*'])
*/
class MessageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'tel',
        'info'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Message::class;
    }

    public function messages($skip=0,$take=12){
        return Message::orderBy('created_at','desc')
                ->skip($skip)
                ->take($take)
                ->get();
    }

}
