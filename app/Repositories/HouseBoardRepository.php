<?php

namespace App\Repositories;

use App\Models\HouseBoard;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class HouseBoardRepository
 * @package App\Repositories
 * @version November 7, 2018, 5:37 pm CST
 *
 * @method HouseBoard findWithoutFail($id, $columns = ['*'])
 * @method HouseBoard find($id, $columns = ['*'])
 * @method HouseBoard first($columns = ['*'])
*/
class HouseBoardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'house_id',
        'type',
        'content',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return HouseBoard::class;
    }
}
