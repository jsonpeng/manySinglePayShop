<?php

namespace App\Repositories;

use App\Models\AttachHouseBoard;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttachHouseBoardRepository
 * @package App\Repositories
 * @version November 7, 2018, 5:44 pm CST
 *
 * @method AttachHouseBoard findWithoutFail($id, $columns = ['*'])
 * @method AttachHouseBoard find($id, $columns = ['*'])
 * @method AttachHouseBoard first($columns = ['*'])
*/
class AttachHouseBoardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content',
        'message_id',
        'user_id',
        'reply_user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttachHouseBoard::class;
    }
}
