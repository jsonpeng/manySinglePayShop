<?php

namespace App\Repositories;

use App\Models\AttachMessageBoard;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttachMessageBoardRepository
 * @package App\Repositories
 * @version September 6, 2018, 11:44 am CST
 *
 * @method AttachMessageBoard findWithoutFail($id, $columns = ['*'])
 * @method AttachMessageBoard find($id, $columns = ['*'])
 * @method AttachMessageBoard first($columns = ['*'])
*/
class AttachMessageBoardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content',
        'zan',
        'message_id',
        'user_id',
        'replay_user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttachMessageBoard::class;
    }
}
