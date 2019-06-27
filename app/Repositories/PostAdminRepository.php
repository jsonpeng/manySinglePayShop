<?php

namespace App\Repositories;

use App\Models\PostAdmin;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PostAdminRepository
 * @package App\Repositories
 * @version November 27, 2018, 11:39 am CST
 *
 * @method PostAdmin findWithoutFail($id, $columns = ['*'])
 * @method PostAdmin find($id, $columns = ['*'])
 * @method PostAdmin first($columns = ['*'])
*/
class PostAdminRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'post_id',
        'admin_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PostAdmin::class;
    }
}
