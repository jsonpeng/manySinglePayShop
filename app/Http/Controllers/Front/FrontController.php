<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Repositories\SettingRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\PageRepository;
use App\Repositories\MenuRepository;
use App\Repositories\MessageRepository;
use App\Repositories\LinkRepository;
use App\Repositories\BannerRepository;
use App\Repositories\CustomPostTypeRepository;
use App\Repositories\NoticesRepository;
use App\Repositories\MessageBoardRepository;
use App\Repositories\PostCommentRepository;
use App\Repositories\AttachMessageBoardRepository;
use App\Repositories\AttachPostCommentRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use Mail;
use App\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Notices;
use DB;
use Illuminate\Support\Facades\Input;
use Hash;
use EasyWeChat\Factory;
use Config;
use Cache;

class FrontController extends Controller
{
    private $settingRepository;
    private $categoryRepository;
    private $postRepository;
    private $pageRepository;
    private $menuRepository;
    private $messageRepository;
    private $linkRepository;
    private $bannerRepository;
    private $customPostTypeRepository;
    private $noticesRepository;
    private $messageBoardRepository;
    private $postCommentRepository;
    private $attachMessageBoardRepository;
    private $attachPostCommentRepository;
    public function __construct(
        SettingRepository $settingRepo,
        CategoryRepository $categoryRepo,
        PostRepository $postRepo,
        PageRepository $pageRepo,
        MenuRepository $menuRepo,
        MessageRepository $messageRepo,
        LinkRepository $linkRepo,
        BannerRepository $bannerRepo,
        CustomPostTypeRepository $customPostTypeRepo,
        NoticesRepository $noticesRepo,
        MessageBoardRepository $messageBoardRepo,
        PostCommentRepository $postCommentRepo,
        AttachMessageBoardRepository $attachMessageBoardRepo,
        AttachPostCommentRepository $attachPostCommentRepo
    )
    {
        $this->settingRepository = $settingRepo;
        $this->categoryRepository = $categoryRepo;
        $this->postRepository = $postRepo;
        $this->pageRepository = $pageRepo;
        $this->menuRepository = $menuRepo;
        $this->messageRepository = $messageRepo;
        $this->linkRepository = $linkRepo;
        $this->bannerRepository = $bannerRepo;
        $this->customPostTypeRepository=$customPostTypeRepo;
        $this->noticesRepository = $noticesRepo;
        $this->messageBoardRepository = $messageBoardRepo;
        $this->postCommentRepository = $postCommentRepo;
        $this->attachMessageBoardRepository = $attachMessageBoardRepo;
        $this->attachPostCommentRepository = $attachPostCommentRepo;
    }

    
    private function getPostTemplate($cats){
        foreach ($cats as $key => $cat) {
            if (view()->exists('front.post.'.$cat->slug)) {
                return 'front.post.'.$cat->slug;
            }
        }
        //搜寻三层父类
        foreach ($cats as $key => $cat) {
            if ($cat->parent_id != 0) {
                $parent_cat = $this->categoryRepository->getCacheCategory($cat->parent_id);
                if (view()->exists('front.post.'.$parent_cat->slug)) {
                    return 'front.post.'.$parent_cat->slug;
                }
                if ($parent_cat->parent_id != 0) {
                    $granpa_cat = $this->categoryRepository->getCacheCategory($parent_cat->parent_id);
                    if (view()->exists('front.post.'.$granpa_cat->slug)) {
                        return 'front.post.'.$granpa_cat->slug;
                    }
                }
            }
        }
        return 'front.post.index';
    }

    /*
    *根据分类别名，获取可用的模板
    *依次寻找自身分类别名，父分类别名，如果都找不到这返回默认
     */
    private function getCatTemplate($slugOrId){
        $category = '';
        if (is_numeric($slugOrId)) {
            $category = $this->categoryRepository->getCacheCategory($slugOrId);
        } else {
            $category = $this->categoryRepository->getCacheCategoryBySlug($slugOrId);
        }
        //分类信息不存在
        if (empty($category)) {
            return 'front.cat.index';
        }
        if (view()->exists('front.cat.'.$category->slug)) {
            return 'front.cat.'.$category->slug;
        }else{
            if ($category->parent_id == 0) {
                return 'front.cat.index';
            } else {
                return $this->getCatTemplate($category->parent_id);
            }
        }
    }

    /*
    *获取分类的根分类
     */
    private function getCatRoot($slugOrId){
        $category = '';
        if (is_numeric($slugOrId)) {
            $category = $this->categoryRepository->getCacheCategory($slugOrId);
        } else {
            $category = $this->categoryRepository->getCacheCategoryBySlug($slugOrId);
        }
        //分类信息不存在
        if (empty($category)) {
            return null;
        }else{
            if ($category->parent_id == 0) {
                return $category;
            } else {
                return $this->getCatRoot($category->parent_id);
            }
        }
    }

    //根据分类id返回是否设定自定义字段附加对应的分类别名
    public function getCatRootSlug($cat_id){
        $category = $this->categoryRepository->getCacheCategory($cat_id);
        if (empty($category)) {
            return ['status'=>false,'msg'=>null];
        }else{
            if ($category->parent_id == 0) {
                $cat_custom=$this->customPostTypeRepository->getNameBySlug($category->slug);
                if(!empty($cat_custom)){
                    return ['status'=>true,'msg'=>$category->slug];
                }else{
                    return ['status'=>false,'msg'=>null];
                }
            } else {
                $cat_root= $this->getCatRoot($category->parent_id);
                $cat_custom=$this->customPostTypeRepository->getNameBySlug($cat_root->slug);
                if(!empty($cat_custom)){
                    return ['status'=>true,'msg'=>$cat_root->slug];
                }else{
                    return ['status'=>false,'msg'=>null];
                }
            }
        }
    }

    // 首页
    public function index(Request $request)
    {
       #首页横幅上方的广告
       $index_top_guanggao = app('common')->bannerRepo()->getCacheBanner('shou-ye-heng-fu-shang-fang-guang-gao');

       #首页横幅
       $hot_posts = app('common')->postRepo()->hotPosts();
       
       #首页横幅下方的广告
       $index_bottom_guanggao = app('common')->bannerRepo()->getCacheBanner('shou-ye-heng-fu-xia-fang-guang-gao');
       
       #三条快讯
       $quick_news = app('common')->categoryRepo()->getCachePostOfCat('quick-news',0,3);

       #头条置顶的文章
       $top_posts = app('common')->postRepo()->topPosts();
       
       #底部下方的广告
       $right_bottom_guanggao = app('common')->bannerRepo()->getCacheBanner('index-bottom-right');

       #生态分类
       $shengtai_cat = app('common')->categoryRepo()->getCacheCategory('shengtai');

       #生态分类下的文章 3条
       $shengtai_posts = app('common')->categoryRepo()->getCachePostOfCatIncludeChildren($shengtai_cat,3);

       #优秀作家
       $good_writers = app('common')->goodWriters();
    
        return view('front.index',compact('index_top_guanggao','hot_posts','index_bottom_guanggao','quick_news','top_posts','right_bottom_guanggao','shengtai_cat','shengtai_posts','good_writers'));
    }

    //分类页面
    public function cat(Request $request, $id)
    {
        $category = $this->categoryRepository->getCacheCategory($id);
        //分类信息不存在
        if (empty($category)) {
            return redirect('/');
        }
        $cats = $this->categoryRepository->getCacheChildCatsOfParentBySlug($this->getCatRoot($category->id)->slug);

        // $take = empty(getSettingValueByKey('front_take')) ? 1 : getSettingValueByKey('front_take');
        // $skip = 0;
        $input = $request->all();

        // $last_link = 0;
        // $next_link = 2;
        // $next_skip = $take;
        // if(array_key_exists('page',$input) && !empty($input['page'])){
        //     $skip = $take * ($input['page'] - 1);
        //     $next_skip = $take * $input['page'];
        //     $last_link = $input['page'] - 1;
        //     $next_link = $input['page'] + 1;
        // }

        $posts = $this->categoryRepository->getCachePostOfCatIncludeChildrenPaginate($category);

        $top_guanggao = null;
        $bottom_guanggao = null;

        if($category->slug == 'quick-news'){
            $top_guanggao = app('common')->bannerRepo()->getCacheBanner('kuanxun_top_guanggao');
            $bottom_guanggao = app('common')->bannerRepo()->getCacheBanner('kuaixun_bottom_guanggao');
        }
  
        //是否为该分类自定义了模板
        return view($this->getCatTemplate($category->id))
            ->with('category', $category)
            ->with('cats', $cats)
            ->with('posts', $posts)
            ->with('top_guanggao',$top_guanggao)
            ->with('bottom_guanggao',$bottom_guanggao);
    }

    //文章页面
    public function post(Request $request, $id)
    {
        $input = $request->all();
        $post = $this->postRepository->getCachePost($id);
        //分类信息不存在
        if (empty($post)) {
            return redirect('/');
        }
        $post->update(['view' => $post->view + 1]);

       #文章所在的分类
       $cats = $post->cats;
        
        #延伸阅读
       $near_posts = app('common')->postRepo()->nearPosts($id);

       #延伸底部广告
       $yansheng_guanggao = app('common')->bannerRepo()->getCacheBanner('post_yansheng_guanggao');

       #右侧底部广告
       $bottom_guanggao = app('common')->bannerRepo()->getCacheBanner('post_guanggao');

       #底部通用广告
       $tongyong_bottom_guanggao = app('common')->bannerRepo()->getCacheBanner('post_all_guanggao');

       #收藏状态
       $collect_status = app('common')->attentionPostStatus(auth('web')->user(),$id);

       #发布人
       $author = app('common')->postRepo()->postAuthor($post)['author'];

       //dd($messages);
       return view($this->getPostTemplate($cats))
       ->with('post', $post)
       ->with('near_posts',$near_posts)
       ->with('yansheng_guanggao',$yansheng_guanggao)
       ->with('bottom_guanggao',$bottom_guanggao)
       ->with('tongyong_bottom_guanggao',$tongyong_bottom_guanggao)
       ->with('collect_status',$collect_status)
       ->with('author',$author);
    }

    //留言板
    public function messageBoard(Request $request)
    {
        $input = $request->all();
        $user = auth('web')->user();
        if(isset($input['comment_id'])){
             $type = isset($input['more']) ? 1 : 0;
             $messages = $this->messageBoardRepository->getAllMessages($input['comment_id'],$type);
        }
        else{
             $messages = $this->messageBoardRepository->getMessages();
        }
        if(isset($input['notice_id'])){
            $this->noticesRepository->setNoticeReadById($input['notice_id']);
        }
        $count = $this->messageBoardRepository->getMessages(0,0,true);

        // dd($messages);
        return view('front.message_boards',compact('messages','user','count','input'));
    }

    //单页面
    public function page(Request $request, $id)
    {
        $page = '';
        if (is_numeric($id)) {
            $page = $this->pageRepository->getCachePage($id);
        } else {
            $page = $this->pageRepository->getCachePageBySlug($id);
        }
        
        //分类信息不存在
        if (empty($page)) {
            return redirect('/');
        }

        $page->update(['view' => $page->view + 1]);

        //是否为该分类自定义了模板
        if (view()->exists('front.page.'.$page->slug)) {
            return view('front.page.'.$page->slug)->with('page', $page);
        } else {
            return view('front.page.index')->with('page', $page);
        }
    }

    //提交数据
    public function submitInfo(Request $request)
    {
        $this->messageRepository->create($request->all());
        return zcjy_callback_data('提交成功');
    }


    //修改用户数据
    public function changeUserData(Request $request)
    {
        $input = $request->all();
        $user = auth('web')->user();

        #替换邮箱
        if(array_key_exists('email',$input) && !array_key_exists('newpwd',$input)){
            if(empty($user)){
                return zcjy_callback_data('请先登录后使用',1);
            }
            if(empty($input['email'])){
                return zcjy_callback_data('请输入新邮箱',1);
            }
            if(!array_key_exists('code',$input) || array_key_exists('code',$input) && empty($input['code'])){
                return zcjy_callback_data('请输入邮箱验证码',1);
            }
            if($input['code'] != session('email_code_change_'.$request->ip())){
                return zcjy_callback_data('邮箱验证码错误',1);
            }
        }

        #根据原密码修改密码
        if(array_key_exists('password',$input)){
            if(empty($user)){
                return zcjy_callback_data('请先登录后使用',1);
            }
            if(empty($input['password'])){
                return zcjy_callback_data('请输入原密码',1);
            }
            if(!Hash::check($input['password'],$user->password)){
                return zcjy_callback_data('原密码错误',1);
            }
            if(array_key_exists('newpassword',$input)){
                 if(empty($input['newpassword'])){
                     return zcjy_callback_data('请输入新密码',1);
                 }
                 $input['password'] = Hash::make($input['newpassword']);
            }
        }

        #邮箱重置密码
        if(array_key_exists('newpwd',$input)){
            if(!array_key_exists('email',$input) || array_key_exists('email',$input) && empty($input['email'])){
                return zcjy_callback_data('请输入邮箱',1);
            }
            if(!array_key_exists('code',$input) || array_key_exists('code',$input) && empty($input['code'])){
                return zcjy_callback_data('请输入邮箱验证码',1);
            }
            if(empty($input['newpwd'])){
                return zcjy_callback_data('请输入密码',1);
            }
            if($input['code'] != session('email_code_change_'.$request->ip())){
                return zcjy_callback_data('邮箱验证码错误',1);
            }
            $input['password'] = Hash::make($input['newpwd']);
            $user = User::where('email',$input['email'])->first();
            if(empty($user)){
                return zcjy_callback_data('该邮箱未被绑定,请换一个邮箱',1);
            }
        }

        $user->update($input);
        return zcjy_callback_data('修改成功');
    }

    //搜索页面
    public function searchPage(Request $request)
    {
        $input = $request->all();
   
        if(isset($input['word']) && !empty($input['word'])){
            $messages = $this->postRepository->searchPosts($input['word']);
       
            $count = count($messages);

             return view('front.search',compact('messages','input','count'));
        }
        else{
            return redirect('/');
        } 
    }


    /**
     * 微信授权登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function weixinAuth(Request $request){
        $ip = $request->get('ip');
        //存储客户端要跳转的链接
        $options = Config::get('wechat.official_account.default');
        $options['oauth'] = [
              'scopes'   => ['snsapi_userinfo'],
              'callback' => '/weixin_auth_callback?ip='.$ip,
         ];
        //Log::info($options);
        $app = Factory::officialAccount($options);
       
        Cache::put('ip_scan'.$ip, 'scaned wait login',1);
   
        //->scopes(['snsapi_userinfo'])
        $response = $app->oauth
                          ->redirect();
        return $response;
    }


    /**
     * 微信授权登录回调
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function weixinAuthCallback(Request $request){
        $options = Config::get('wechat.official_account.default');
        //Log::info($options);
        $app =Factory::officialAccount($options);
        $oauth = $app->oauth;
        // 获取 OAuth 授权结果用户信息
        $userinfo = $oauth->user();
        
        $ip = $request->get('ip');
     
        //session(['ip_scan'.$request->ip()=>'scaned login success']);

        if(!empty($userinfo)){
            $user = User::where('openid', $userinfo->getId())->first();
            if (is_null($user)) {
                // 新建用户
                $user = User::create([
                    'openid' => $userinfo->getId(),
                    'nickname' => $userinfo->getNickname(),
                    'head_image' => $userinfo->getAvatar(),
                    ]);
            }
            else{
                $user->update([
                    'nickname' => $userinfo->getNickname(),
                    'head_image' => $userinfo->getAvatar()
                    ]);
                // $token = zcjy_base64_en($user->id.'__'.strtotime($user->created_at).'__'.$user->openid.'__'.time());
               
            }
            Cache::put('ip_scan'.$ip,$user->id,1);
            // Cache::forget('ip_scan'.$ip);
            return redirect('/weixin_success');
        }
    }

    /**
     * [微信登陆成功页面]
     * @return [type] [description]
     */
    public function weixinSuccess(){
        return view('front.success');
    }
      
}
