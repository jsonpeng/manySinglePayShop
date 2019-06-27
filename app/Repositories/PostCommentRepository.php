<?php

namespace App\Repositories;

use App\Models\PostComment;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
/**
 * Class PostCommentRepository
 * @package App\Repositories
 * @version August 30, 2018, 4:56 pm CST
 *
 * @method PostComment findWithoutFail($id, $columns = ['*'])
 * @method PostComment find($id, $columns = ['*'])
 * @method PostComment first($columns = ['*'])
*/
class PostCommentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'post_id',
        'content',
        'user_id',
        'zan'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PostComment::class;
    }

    public function getAllPostComments($post_id,$comment_id,$type=null)
    {
          $messages = PostComment::where('post_id',$post_id)
                ->orderBy('created_at','desc')
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

    //获取对应文章的评论内容
    public function getPostComments($post_id,$skip=0,$take=20,$count=false)
    {
          // return Cache::remember('zcjy_get_post_comments_'.$post_id.'_'.$skip.'_'.$take, Config::get('web.shrottimecache'), function() use ($post_id,$skip,$take) {
                    $messages = PostComment::where('post_id',$post_id)
                    ->orderBy('created_at','desc');
                    if($count){
                      $messages = $messages->count();
                    }
                    else{
                      $messages = $messages
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
                  }
                  return $messages;
          //});
    }
}
