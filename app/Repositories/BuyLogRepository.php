<?php

namespace App\Repositories;

use App\Models\BuyLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BuyLogRepository
 * @package App\Repositories
 * @version January 9, 2019, 4:52 pm CST
 *
 * @method BuyLog findWithoutFail($id, $columns = ['*'])
 * @method BuyLog find($id, $columns = ['*'])
 * @method BuyLog first($columns = ['*'])
*/
class BuyLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_name',
        'price',
        'name',
        'mobile',
        'address',
        'pay_platform',
        'pay_status',
        'number'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BuyLog::class;
    }
}
