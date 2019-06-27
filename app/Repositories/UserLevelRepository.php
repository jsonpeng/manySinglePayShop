<?php

namespace App\Repositories;

use App\Models\UserLevel;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserLevelRepository
 * @package App\Repositories
 * @version March 19, 2018, 6:49 am UTC
 *
 * @method UserLevel findWithoutFail($id, $columns = ['*'])
 * @method UserLevel find($id, $columns = ['*'])
 * @method UserLevel first($columns = ['*'])
*/
class UserLevelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'amount',
        'price',
        'rate'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserLevel::class;
    }
}
