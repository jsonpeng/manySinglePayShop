<?php

namespace App\Repositories;

use App\Models\Gol;
use App\Models\AttentionGol;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GolRepository
 * @package App\Repositories
 * @version October 25, 2018, 5:38 pm CST
 *
 * @method Gol findWithoutFail($id, $columns = ['*'])
 * @method Gol find($id, $columns = ['*'])
 * @method Gol first($columns = ['*'])
*/
class GolRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'brief',
        'content',
        'xukezheng',
        'zuqi',
        'area',
        'address',
        'hourse_status',
        'gaizao_status',
        'publish_status',
        'price',
        'give_word'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Gol::class;
    }


    //很多人喜欢
    public function manyManslike(){

        $gols = Gol::where('publish_status',1)
                ->with('users')
                ->get();

        foreach ($gols as $key => $val) {
            $val['user_num'] = count($val['users']);
        }

        $gols = $gols->sortByDesc('user_num');

        return $gols;
    }

    /**
     * 关注人数
     * @param  [type] $gol_id [description]
     * @return [type]           [description]
     */
    public function attentionGolPeopleNum($gol_id)
    {
        return AttentionGol::where('gol_id',$gol_id)->count();
    }


    /**
     * [搜索gol]
     * @param  [type] $word [description]
     * @return [type]       [description]
     */
    public function queryGols($word)
    {
        return Gol::where('name','like','%'.$word.'%')
                ->orWhere('content','like','%'.$word.'%')
                ->orWhere('address','like','%'.$word.'%')
                ->orWhere('price','like','%'.$word.'%')
                ->get();
    }



    /**
     * [获取城市唯一的gol]
     * @return [type] [description]
     */
    public function getGolsCities()
    {
      return  Gol::where('publish_status',1)
            ->select('city')
            ->distinct()
            ->get();
    }


    /**
     * [获取不同类型的gols]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function getTypeGols($type,$skip=0,$take=20){
        return Gol::where('type',$type)
            ->where('publish_status',1)
            ->orderBy('created_at','desc')
            ->skip($skip)
            ->take($take)
            ->get();
    }

    //我发布的gol
    public function myGols($user_id){
        return Gol::where('user_id',$user_id)
            ->orderBy('created_at','desc')
            ->paginate(15);
    }


    /**
     * [获取gol详情]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getGolDetail($id)
    {
        $gol = Gol::find($id);

        if(empty($gol)){
            return '没有找到该小屋';
        }

        if($gol->publish_status != '1'){
            return '该小屋已下架或者审核中';
        }

        return (object)['detail'=>$gol];
    }







}
