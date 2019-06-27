<?php

namespace App\Repositories;

use App\Models\AttachHouse;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttachHouseRepository
 * @package App\Repositories
 * @version October 15, 2018, 10:17 am CST
 *
 * @method AttachHouse findWithoutFail($id, $columns = ['*'])
 * @method AttachHouse find($id, $columns = ['*'])
 * @method AttachHouse first($columns = ['*'])
*/
class AttachHouseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'house_id',
        'key',
        'value'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttachHouse::class;
    }
}
