<?php

namespace App\Repositories;

use App\Models\PostUser;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PostUserRepository
 * @package App\Repositories
 * @version November 27, 2018, 11:35 am CST
 *
 * @method PostUser findWithoutFail($id, $columns = ['*'])
 * @method PostUser find($id, $columns = ['*'])
 * @method PostUser first($columns = ['*'])
*/
class PostUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'post_id',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PostUser::class;
    }
}
