<?php

namespace App\Repositories;

use App\Models\SharePlatform;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SharePlatformRepository
 * @package App\Repositories
 * @version January 17, 2019, 5:02 pm CST
 *
 * @method SharePlatform findWithoutFail($id, $columns = ['*'])
 * @method SharePlatform find($id, $columns = ['*'])
 * @method SharePlatform first($columns = ['*'])
*/
class SharePlatformRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'link',
        'qrcode'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SharePlatform::class;
    }
}
