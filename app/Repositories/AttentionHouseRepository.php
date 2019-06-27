<?php

namespace App\Repositories;

use App\Models\AttentionHouse;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttentionHouseRepository
 * @package App\Repositories
 * @version October 29, 2018, 10:34 am CST
 *
 * @method AttentionHouse findWithoutFail($id, $columns = ['*'])
 * @method AttentionHouse find($id, $columns = ['*'])
 * @method AttentionHouse first($columns = ['*'])
*/
class AttentionHouseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'house_id',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttentionHouse::class;
    }
}
