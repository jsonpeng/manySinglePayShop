<?php

namespace App\Repositories;

use App\Models\GolServices;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GolServicesRepository
 * @package App\Repositories
 * @version November 8, 2018, 11:38 am CST
 *
 * @method GolServices findWithoutFail($id, $columns = ['*'])
 * @method GolServices find($id, $columns = ['*'])
 * @method GolServices first($columns = ['*'])
*/
class GolServicesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'group',
        'image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return GolServices::class;
    }
}
