<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostUser;
use App\Models\PostAdmin;
use App\Models\Admin;
use App\User;

use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Class PostRepository
 * @package App\Repositories
 * @version October 17, 2017, 6:10 pm CST
 *
 * @method Post findWithoutFail($id, $columns = ['*'])
 * @method Post find($id, $columns = ['*'])
 * @method Post first($columns = ['*'])
*/
class PostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
        'brief',
        'content',
        'view',
        'seo_title',
        'seo_des',
        'seo_keyword',
        'status',
        'type',
        'more',
        'author_type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Post::class;
    }

    //延伸阅读
    public function yanshenPosts($skip=0,$take=3)
    {
           return Cache::remember('zcjy_yanshen_posts', Config::get('web.shrottimecache'), function() use($skip,$take){
                return Post::orderBy('view','desc')
                        ->where('publish_status','已通过')
                        ->where('status',1)
                        ->orderBy('is_top','desc')
                        ->orderBy('created_at','desc')
                        ->skip($skip)
                        ->take($take)
                        ->get();
           });
    }

    public function generateAuthors()
    {
        $posts = Post::all();
        foreach ($posts as $key => $value) {
            PostAdmin::create([
                'post_id'=>$value->id,
                'admin_id'=>2
            ]);
        }
    }

    //文章的作者
    public function postAuthor($post)
    {
        return Cache::remember('zcjy_post_author_'.$post->id, Config::get('web.shrottimecache'), function() use ($post) {
                        $author = null;
                        $author_type = $post->author_type == 'admin' ? '管理员' : '用户';
                        $author_obj = null; 
                        if($author_type == '管理员'){
                            $author = PostAdmin::where('post_id',$post->id)->first();
                            if(!empty($author)){
                                $author = Admin::find($author->admin_id);
                                if(!empty($author)){
                                    $author_obj = $author;
                                    $author = $author->name;
                                }
                            }
                        }
                        else{
                            $author = PostUser::where('post_id',$post->id)->first();
                            if(!empty($author)){
                                $author = User::find($author->user_id);
                                if(!empty($author)){
                                    $author_obj = $author;
                                    $author = $author->nickname;
                                }
                            }
                        }
                        return ['author_type'=>$author_type,'author'=>$author,'author_obj'=>$author_obj];
        });
    }

    public function searchPosts($word,$paginate=false){
            $posts = Post::where('publish_status','已通过')->where('status',1)->where(function($query) use($word){
                    $query->where('name','like','%'.$word.'%')->orWhere('content','like','%'.$word.'%');
            });
            $posts = $posts
            ->orderBy('is_top','desc')
            ->orderBy('created_at','desc');
         //return Cache::remember('zcjy_post_search'.$word, Config::get('web.shrottimecache'), function() use ($word) {
            return $paginate ? $posts->paginate(15) : $posts->get();
         //});
    }

    public function getCachePost($id){
        return Cache::remember('zcjy_post_'.$id, Config::get('web.shrottimecache'), function() use ($id) {
            try {
                return Post::find($id);
            } catch (Exception $e) {
                return;
            }
        });
    }

    public function getCachePostFirstCat($id){
        return Cache::remember('zcjy_post_cats_'.$id, Config::get('web.shrottimecache'), function() use ($id) {
            return $this->getCachePost($id)->cats()->first();
        });
    }

    //取出不是这个id的几个来进行推荐
    public function getTuijianForId($id,$number=8){
        return Cache::remember('zcjy_post_tuijian_'.$id,Config::get('web.shrottimecache'),function () use ($id,$number){
            try {
                $posts=Post::where('id','<>', $id);
                if(!empty($posts->get())){
                    return $posts->take($number)->get();
                }else {
                    return collect([]);
                }
            } catch (Exception $e) {
                return;
            }
        });
    }


    public function PrevPost($id)
    {
        return Cache::remember('PrevPost_'.$id, Config::get('web.shrottimecache'), function() use ($id) {
            $post = $this->getCachePost($id);
            $cat = $this->getCachePostFirstCat($id);
            if (is_null($cat)) {
                return Post::where('id', '<', $id)->where('status', 1)->orderBy('id', 'desc')->first();
            } else {
                //dd($cat->posts()->where('status', 1)->orderBy('id', 'desc')->get());
                //return $cat->posts()->where('id', '<', $id)->where('status', 1)->orderBy('id', 'desc')->first();
                $posts = $cat->posts()->where('status', 1)->orderBy('id', 'desc')->get();
                return $posts->first(function ($value, $key) use($id) {
                    return $value->id < $id;
                });
            }
        });
    }

    public function NextPost($id)
    {
        return Cache::remember('NextPost_'.$id, Config::get('web.shrottimecache'), function() use ($id) {
            $post = $this->getCachePost($id);
            $cat = $this->getCachePostFirstCat($id);
            if (is_null($cat)) {
                return Post::where('id', '>', $id)->where('status', 1)->orderBy('id', 'asc')->first();
            } else {
                //return $cat->posts()->where('id', '>', $id)->where('status', 1)->orderBy('id', 'asc')->first();
                $posts = $cat->posts()->where('status', 1)->orderBy('id', 'asc')->get();
                return $posts->first(function ($value, $key) use($id) {
                    return $value->id > $id;
                });
            }
        });
    }

    //延伸阅读
    public function nearPosts($id,$take=3){
        return Cache::remember('NearPost_'.$id.$take, Config::get('web.shrottimecache'), function() use ($id,$take) {
            $post = $this->getCachePost($id);
            $cat = $this->getCachePostFirstCat($id);
            if (is_null($cat)) {
                return Post::where('id', '>', $id)->where('status', 1)->where('publish_status','已通过')
                ->orderBy('is_top','desc')
                ->orderBy('created_at','desc')
                ->take($take)
                ->get();
            } else {
                //return $cat->posts()->where('id', '>', $id)->where('status', 1)->orderBy('is_top','desc')
                        // ->orderBy('created_at','desc')->first();
                $posts = $cat->posts()
                ->where('posts.id','<>',$id)
                ->where('status', 1)
                ->orderBy('is_top','desc')
                ->orderBy('created_at','desc')
                ->take($take)
                ->get();
                return $posts;
            }
        });
    }


    //管理员发布文章
    public function adminPublishWithPost($post,$admin){
        PostAdmin::create([
            'post_id'=>$post->id,
            'admin_id'=>$admin->id
        ]);
    }

    //用户发布文章操作
    public function userPublishPost($input,$user){
        $varify = varifyInputParam($input,'name,content');

        if($varify){
            return zcjy_callback_data($varify,1);
        }
        $input['author_type'] = 'user';
        $input['status'] = 1;
        $post = Post::create($input);

        #如果存在分类
        if (array_key_exists('categories', $input)){
            if(!is_array($input['categories'])){
                $input['categories'] = explode(',',$input['categories']);
            }
            if(count($input['categories'])){
                foreach ($input['categories'] as $key => $value) {
                    if(empty($value)){
                        unset($input['categories'][$key]);
                    }
                }
            }
            $post->cats()->sync($input['categories']);
        }

        #关联用户
        PostUser::create([
            'post_id' => $post->id,
            'user_id' => $user->id
        ]);
        
        return zcjy_callback_data('发布文章成功');
    }

    //用户发布的文章列表
    public function userPosts($user,$skip=0,$take=20){
         return Cache::remember('UserPosts_'.$user->id.$skip.$take, Config::get('web.shrottimecache'), function() use ($user,$skip,$take){
                $post_users = PostUser::where('user_id',$user->id)->get();
                $post_id_arr = [];
                foreach ($post_users as $key => $val) {
                   $post_id_arr[] = $val->post_id;
                }
                return Post::whereIn('id',$post_id_arr)
                        // ->where('status',1)
                        ->orderBy('created_at','desc')
                        ->skip($skip)
                        ->take($take)
                        ->get();
         });
    }


    //置顶的文章
    public function topPosts($skip=0,$take=20){
         return Cache::remember('TopPosts_'.$skip.$take, Config::get('web.shrottimecache'), function() use ($skip,$take){
            return Post::where('is_top',1)
                  ->where('status', 1)
                  ->where('publish_status','已通过')
                  ->orderBy('created_at','desc')
                  ->skip($skip)
                  ->take($take)
                  ->get();
         });
    }

    //热门文字
    public function hotPosts($skip=0,$take=20){
            return Cache::remember('HotPosts_'.$skip.$take, Config::get('web.shrottimecache'), function() use ($skip,$take){
                return Post::where('status', 1)
                      ->where('publish_status','已通过')
                      ->orderBy('view','desc')
                      ->skip($skip)
                      ->take($take)
                      ->get();
         });
    }


}
