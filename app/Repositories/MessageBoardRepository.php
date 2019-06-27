<?php

namespace App\Repositories;

use App\Models\MessageBoard;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;


/**
 * Class MessageBoardRepository
 * @package App\Repositories
 * @version September 6, 2018, 11:29 am CST
 *
 * @method MessageBoard findWithoutFail($id, $columns = ['*'])
 * @method MessageBoard find($id, $columns = ['*'])
 * @method MessageBoard first($columns = ['*'])
*/
class MessageBoardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content',
        'zan',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MessageBoard::class;
    }

    public function getAllMessages($comment_id,$type=null){
            $messages = MessageBoard::orderBy('created_at','desc')
                    ->with('user')
                    ->with(['attach.user','attach.replyuser'])
                    ->get();
                    #带上等人信息
                    foreach ($messages as $key => $val) {
                        if(empty($type)){
                            if($val->id == $comment_id){
                                $val['active'] = 1;
                            }
                        }
                       if($val['attach']){
                                $index = 0;
                                $user_names_arr = [];
                                foreach ($val['attach'] as $key => $val2) {

                                    if($type){
                                         if($val2->id == $comment_id){
                                            $val2['active'] = 1;
                                        }
                                    }
                                   
                                    if($index < 3){
                                        $user_names_arr[] = $val2['user']->name;
                                    }
                                    
                                    $index++;

                                }
                                $val['user_names_arr'] = implode(',',array_unique($user_names_arr));
                       }
                    }
                  
            return $messages;
    }



    public function getMessages($skip=0,$take=20,$count=false){
             // return Cache::remember('zcjy_get_messages_'.$skip.'_'.$take, Config::get('web.shrottimecache'), function() use ($skip,$take) {
            //dd(\App\Models\AttachMessageBoard::all());
                    if($count){
                        return MessageBoard::orderBy('created_at','desc')->count();
                    }
                    $messages = MessageBoard::orderBy('created_at','desc')
                    ->with('user')
                    ->with(['attach.user','attach.replyuser'])
                    ->skip($skip)
                    ->take($take)
                    ->get();
                    #带上等人信息
                    foreach ($messages as $key => $val) {
                       if($val['attach']){
                                $index = 0;
                                $user_names_arr = [];
                                foreach ($val['attach'] as $key => $val2) {
                                    if($index < 3){
                                        $user_names_arr[] = $val2['user']->name;
                                    }
                                    $index++;
                                }
                                $val['user_names_arr'] = implode(',',array_unique($user_names_arr));
                       }
                    }
                  
                    return $messages;
             // });
    }
}
