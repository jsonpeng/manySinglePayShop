<?php

namespace App\Repositories;

use App\Models\PostAttention;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PostAttentionRepository
 * @package App\Repositories
 * @version November 29, 2018, 9:18 am CST
 *
 * @method PostAttention findWithoutFail($id, $columns = ['*'])
 * @method PostAttention find($id, $columns = ['*'])
 * @method PostAttention first($columns = ['*'])
*/
class PostAttentionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'post_id',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PostAttention::class;
    }
}
