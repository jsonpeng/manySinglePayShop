<?php

namespace App\Repositories;

use App\Models\ShanghuCerts;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShanghuCertsRepository
 * @package App\Repositories
 * @version November 5, 2018, 5:06 pm CST
 *
 * @method ShanghuCerts findWithoutFail($id, $columns = ['*'])
 * @method ShanghuCerts find($id, $columns = ['*'])
 * @method ShanghuCerts first($columns = ['*'])
*/
class ShanghuCertsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'work_image',
        'shop_image',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ShanghuCerts::class;
    }
}
