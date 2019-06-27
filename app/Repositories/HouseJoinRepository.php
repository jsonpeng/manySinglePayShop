<?php

namespace App\Repositories;

use App\Models\HouseJoin;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class HouseJoinRepository
 * @package App\Repositories
 * @version October 15, 2018, 5:31 pm CST
 *
 * @method HouseJoin findWithoutFail($id, $columns = ['*'])
 * @method HouseJoin find($id, $columns = ['*'])
 * @method HouseJoin first($columns = ['*'])
*/
class HouseJoinRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'house_id',
        'user_id',
        'price',
        'number',
        'pay_status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return HouseJoin::class;
    }

    /**
     * [用户的所有花费]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function useAllConsume($user_id)
    {
        return HouseJoin::where('user_id',$user_id)->where('pay_status','已支付')->sum('price');
    }


    /**
     * [用户参与支持的小屋记录]
     * @param  [type] $user_id    [description]
     * @param  [type] $pay_status [description]
     * @return [type]             [description]
     */
    public function userHouseJoins($user_id,$pay_status = null,$use_unique=false){
        $joins =  HouseJoin::where('user_id',$user_id);
        if(!empty($pay_status)){
             $joins =  $joins->where('pay_status',$pay_status);
        }

        if($use_unique){
            $joins = $joins->select('house_id');
        }

        return $joins
            // ->select('house_id','price','body','gear_num','gear','pay_status','pay_platform','hetong')
            ->distinct()
            ->orderBy('created_at','desc')
            ->paginate(10);
    }
}
