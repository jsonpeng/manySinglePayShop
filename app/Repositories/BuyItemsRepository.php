<?php

namespace App\Repositories;

use App\Models\BuyItems;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BuyItemsRepository
 * @package App\Repositories
 * @version January 10, 2019, 10:19 pm CST
 *
 * @method BuyItems findWithoutFail($id, $columns = ['*'])
 * @method BuyItems find($id, $columns = ['*'])
 * @method BuyItems first($columns = ['*'])
*/
class BuyItemsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'access_ip',
        'product_name',
        'price',
        'num'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BuyItems::class;
    }

    //删除log关联的item
    public function deleteLogItems($log_id)
    {
        return BuyItems::where('order_id',$log_id)
        ->delete();
    }

}
