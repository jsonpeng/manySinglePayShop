<?php

namespace App\Repositories;

use App\Models\HeZuo;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Class HeZuoRepository
 * @package App\Repositories
 * @version December 17, 2018, 7:31 pm CST
 *
 * @method HeZuo findWithoutFail($id, $columns = ['*'])
 * @method HeZuo find($id, $columns = ['*'])
 * @method HeZuo first($columns = ['*'])
*/
class HeZuoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'image',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return HeZuo::class;
    }


    //获取合作类型
    public function getCacheHezuos($type,$take=20)
    {
            return Cache::remember('zcjy_hezuo_'.$type.$take, Config::get('web.shrottimecache'), function() use ($type,$take) {
                return HeZuo::where('type',$type)->take($take)->get();
            });
    }

}
