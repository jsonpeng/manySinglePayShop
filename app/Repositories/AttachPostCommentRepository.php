<?php

namespace App\Repositories;

use App\Models\AttachPostComment;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AttachPostCommentRepository
 * @package App\Repositories
 * @version August 30, 2018, 5:02 pm CST
 *
 * @method AttachPostComment findWithoutFail($id, $columns = ['*'])
 * @method AttachPostComment find($id, $columns = ['*'])
 * @method AttachPostComment first($columns = ['*'])
*/
class AttachPostCommentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'reply_user_id',
        'comment_id',
        'content',
        'zan'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttachPostComment::class;
    }
}
