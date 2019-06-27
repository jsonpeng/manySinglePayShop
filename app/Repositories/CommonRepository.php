<?php

namespace App\Repositories;


use App\Repositories\CityRepository;
use App\Repositories\PostRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\MessageRepository;
use App\Repositories\CertsRepository;
use App\Repositories\BannerRepository;
use App\Repositories\NoticesRepository;
use App\Repositories\HeZuoRepository;
use App\Repositories\BuyLogRepository;
use App\Repositories\BuyItemsRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

use Log;
use Overtrue\EasySms\EasySms;
use Image;
use Carbon\Carbon;
use App\User;
use App\Models\Post;
use App\Models\PostAttention;
use App\Models\BuyLog;
use App\Models\BuyItems;
use Request;
use Yansongda\Pay\Pay;

/**
 * Class ClientRepository
 * @package App\Repositories
 * @version December 26, 2017, 10:08 am CST
 *
 * @method Client findWithoutFail($id, $columns = ['*'])
 * @method Client find($id, $columns = ['*'])
 * @method Client first($columns = ['*'])
*/
class CommonRepository 
{
 
    #支付宝配置信息
    private $alipay_config = [
        #appid
        'app_id' => '2018072560803323',
        #通知地址
        'notify_url' => '/alipay/notify',
        #验签地址
        'return_url' => '/alipay/return',
        #支付宝公钥
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApV1yvR9FQ+OzADEQYKgs9W0UVG50NZ17Qw5iSUCHwDMpLuKQ3TRPApgpUcIImwrc9bzxihTUS1BbKsw22icV5xqLLmG1vGQnbVsycJqDsVe9ddCVC0lZ6Bf8x9uvPZaPZY6FwJMMfU4310ekZGgwwx+khZZM0on58hwy8VBWHFulf4wAF9KALV39DJ+NelJ6lFLvl9UzIeWPSZyyZmvo+Yf57ie8Vg4NWHumWTc+rVpVc/MyTMOnKd8SQZkhdWSy5I5cLzHVD0wFpTHYOo+jPTQUqblg8nsVwHl/arxoSCYgKkUpLjJdpqYgfB6J6DuXPqN191CUnY6Vs2hXzq6TtwIDAQAB',
        #商户私钥 加密方式： **RSA2**  
        'private_key' => 'MIIEowIBAAKCAQEA6Fbzu6H1AG1BUcz14S3bQZWMXQo84kCL67j4XHYszGmu/BGRuQs2m3AnPSZURn1ujk0cdvr2vR3BPyUz88Z891y/j6ktw4L+QRpmoVP933otuL2a+myD3Tu+KA6XZF0uaN/TD7WVoyH8IKecZ82XEwFKhIDaJu0/lhM4Kv4i2XncG9Yeh6UdLyGuc3RFhvwztF1QsvQy9rfl4uMf6ZJuihlAroyvAScZe7SAg/fBj2PsXPSnJgntXHKrjz2rT1IOOWfw4mi7+COlbZy87MOhtyY3kZat4VeNsrzQp1W8jybhqW5p2UkrXVxfQfWoVVP5ffnNOGjAUg6gyosKJrdmsQIDAQABAoIBAArG/cdWW+cJKl6BA2bOmb0REtG+B9T26Yalrd+cG7ffrx5CMmBDBOVw7mEHxiD+8IHpUcizG37qQmyLbT2Bl4ph4wDm+Bh5mxGqB9iz7LLRGA3ZvbagEf3RJ6D0DFG7gMuclk3EPoyypt9c5wRppPhctvgugfAMUUbE3XYhE7zCs7InnybEV1hXO/M6kGRAci3xDuMiqY3tn/ShvZ08RmQoyqXZsYn3EZ2q4K0RPuBV2NHyBz7fGbEHqZkHA2e0CkwRtM/4joQJ5ZiwY0bDAs13fBs990MMK3mtBt+tBSatg8mrK79WQkrcKTyc8aUPklFW2BAke3ny+B/Od9BuC4ECgYEA97xuMQa8/cUOcMeh/fd9MV4GDTksPZYqIp9+PV3egq2Z8CaBXonqZEpk1NJKENRixcEjIcAwFAKH9xS8o7kzTEXLatvlPq9NmZW9ydwGTbxOerSbw0OZb23cBUEFQ2bwku7bI/F2zfrY+mFvCpE26+VOKPiTN8Nx4HMAcU3J++cCgYEA8BcK2W2/3FNKHyXiJKDw/m5SJCISV69xpW5d9X6+ZRaAwywOu/J4XTb+99Mza+GuMLs94kpehHTACqbqbL9C99ZOTUtzcsrSikcy03lOCdWY8+AsjujoAtRUnzbUG+CTvfSZjcdQ4VUreFlEve8geU8kHOyWk3fWg3oEkNsg9acCgYEAhHVSsZH5wPH466JB4gnO/XNZZv6XwgIlW0fN9r/W9iYeNcJQz5yMH72LNiOOCHuWqEfBIg2hZ0GHMzv6NMwUOobi4arbYu3WXvUqeeDT2gKCL6eb1Qay5lpmFsUSLFzA6r8dmpVDwZSLKSypc4v7Qpvjc5KdHGa635h9txcxlScCgYBHC3qBZpGMn/TiDLLDhgBqObkCyjZFTjxB6MvS9mNexG7r0iC2CwUFCF4gdZXUyZ5i+zVPvhQD/AxL2qKp9VravcbD5pzODiiJFJJ8s3udO2CcYeytiUwGclBsIKxZZ3Ywkq3Rn3ZWh35qiXfnAFjKrNmR2YyhLKgEldm+B6nUJwKBgHy3UJsWjEZ6ApqSKxL1AqcWTGqLFphexEbiW/WS8dGT7Q5IO3bb1Y3m+9kdPR/ZxhBYqlcpBJMizNvHmR6QDXfKcZWnXVuSq6nKikznPb5uzGz4eeqRM1OPzAB+MeH12T9kpcJ6ZW5vHWSTpsQulwY3TSr7WrQPcyZGzgaMo5CQ',
        #optional,设置此参数，将进入沙箱模式 一般可以直接注释
        //'mode' => 'dev', 
    ];

    #微信配置信息
     private $wechat_config = [
        'appid' => 'wx0f5e37c357fcd593', # APP APPID
        'app_id' => 'wx0f5e37c357fcd593', # 公众号 APPID
        'miniapp_id' => 'wxb3fxxxxxxxxxxx', # 小程序 APPID
        'mch_id' => '1513531551',#商户号
        'key' => 'goPDvO7z7aGuljG8mtAcUasmfcKETh5t',#商户key
        'notify_url' => 'http://shop.sosoipfs.com/wechat/notify',#通知地址
        'cert_client' => './cert/apiclient_cert.pem',#optional，退款等情况时用到
        'cert_key' => './cert/apiclient_key.pem',#optional，退款等情况时用到
        'log' => [ #日志文件地址
            'file' => './logs/wechat.log',
            'level' => 'debug'
        ],
        #optional, dev/hk;当为 `hk` 时，为香港 gateway。一般可以直接注释
        //'mode' => 'dev', 
    ];
     private $cityRepository;
     private $postRepository;
     private $categoryRepository;
     private $messageRepository;
     private $certsRepository;
     private $bannerRepository;
     private $noticesRepository;
     private $HeZuoRepository;
     private $BuyLogRepository;
     private $BuyItemsRepository;
     public function __construct(
        CityRepository $cityRepo,
        PostRepository $postRepo,
        CategoryRepository $categoryRepo,
        MessageRepository $messageRepo,
        CertsRepository $certsRepo,
        BannerRepository $bannerRepo,
        NoticesRepository $noticesRepo,
        HeZuoRepository $HeZuoRepo,
        BuyLogRepository $BuyLogRepo,
        BuyItemsRepository $BuyItemsRepo
    ){
        $this->cityRepository = $cityRepo;
        $this->postRepository = $postRepo;
        $this->categoryRepository = $categoryRepo;
        $this->messageRepository = $messageRepo;
        $this->certsRepository = $certsRepo;
        $this->bannerRepository = $bannerRepo;
        $this->noticesRepository = $noticesRepo;
        $this->HeZuoRepository = $HeZuoRepo;
        $this->BuyLogRepository = $BuyLogRepo;
        $this->BuyItemsRepository = $BuyItemsRepo;
     }

     public function BuyItemsRepo()
     {
      return $this->BuyItemsRepository;
     }

     public function BuyLogRepo()
     {
      return $this->BuyLogRepository;
     }

     public function HeZuoRepo(){
      return $this->HeZuoRepository;
     }

     public function noticesRepo(){
        return $this->noticesRepository;
     }

     public function bannerRepo(){
        return $this->bannerRepository;
     }

     public function certsRepo(){
        return $this->certsRepository;
     }

     public function messageRepo(){
        return $this->messageRepository;
     }

     public function categoryRepo(){
        return $this->categoryRepository;
     }

     public function postRepo(){
        return $this->postRepository;
     }

     public function cityRepo(){
        return $this->cityRepository;
     }


     public function dealIndexPlatform($request)
     {
        $input = $request->all();

        if(isset($input['platform']))
        {
          Cache::put($request->ip.'_shareplatform',zcjy_base64_de($input['platform']),3);
        }
     }

     /**
      * [询问购买记录是否已经成功支付]
      * @param  [type] $param [description]
      * @return [type]        [description]
      */
     public function askLogStatus($param)
     {
        $item = BuyItems::where('access_ip',zcjy_base64_de($param))->orderBy('created_at','desc')->first();
        if(empty($item))
        {
            return zcjy_callback_data('没有加入商品');
        }

        if(isset($item->order_id))
        {
            $log = BuyLog::find($item->order_id);

            if(empty($log))
            {
              return zcjy_callback_data('没有该订单记录');
            }

            if($log->pay_status == '未支付')
            {
              return zcjy_callback_data('等待支付中');
            }
            elseif($log->pay_status == '已支付')
            {
              return zcjy_callback_data('支付成功');
            }

        }
        else{
            return zcjy_callback_data('加入商品没有订单记录');
        }
     } 

     /**
      * [成功处理订单]
      * @param  [type] $number [description]
      * @return [type]         [description]
      */
     public function successOrderLog($number)
     {
        $order = BuyLog::where('number',$number)->first();
        if(empty($order))
        {
          return;
        }
        if($order->pay_status == '已支付')
        {
          return;
        }
        $order->update(['pay_status'=>'已支付']);
        sendSMS($order->mobile);
     }

     //更新数量
     public function updateItemNum($request)
     {
        $input = $request->all();

        $varify =  varifyInputParam($input,'item_id,num');

        if($varify)
        {
          return zcjy_callback_data($varify,1);
        }

        $item = BuyItems::find($input['item_id']);

        if(empty($item))
        {
          return zcjy_callback_data('没有找到该记录',1);
        }

        if((int)$input['num'] == 0)
        {
          $item->delete();
          $item_price = 0;
        }
        else{

          $item->update(['num'=>$input['num']]);
          $item_price = round($item->price * $input['num'],2);

        }

        $all_price = $this->countIpPrices($request->ip());

        return zcjy_callback_data(['item_price'=>$item_price,'all_price'=>$all_price]);
     }

     //添加商品
     public function addProduct($request)
     {
        $input = $request->all();

        $varify =  varifyInputParam($input,'product_name,num,price');

        if($varify)
        {
          return zcjy_callback_data($varify,1);
        }

        $input['access_ip'] = $request->ip();

        $items = $this->ipItems($input['access_ip']);
        $create_status = 1;
        foreach ($items as $key => $item) {
            if($item->product_name == $input['product_name'] && $item->price == $input['price'])
            {
              $create_status = 0;
              $item->update(['num'=>$item->num+1]);
            }
        }
        if($create_status){
          BuyItems::create($input);
        }
        return zcjy_callback_data('添加成功');
     }

     //删除商品
     public function delProduct($request)
     {
        $input = $request->all();

        $varify =  varifyInputParam($input,'item_id');

        if($varify)
        {
          return zcjy_callback_data($varify,1);
        }

        $item = BuyItems::find($input['item_id']);

        if(empty($item))
        {
          return zcjy_callback_data('没有找到该记录',1);
        }

        $item->delete();
        return zcjy_callback_data($this->countIpPrices($request->ip()));
     }

     public function  ipItems($ip)
     {
        return BuyItems::where('access_ip',$ip)->whereNull('order_id')->get();
     }

     //统计一个ip段的所有金额
     public function countIpPrices($ip)
     {
        $items = $this->ipItems($ip);

        $price = 0;

        foreach ($items as $key => $item) {
            $price += $item->price * $item->num;
        }
        return round($price,2);
     }

     //删除不用的订单
     public function deleteUnPayOrder($ip)
     {
        $items = BuyItems::where('access_ip',$ip)->whereNotNull('order_id')->get();
        $order_id_arr = [];
        foreach ($items as $key => $item) 
        {
          $log = BuyLog::find($item->order_id);
          if(isset($log) && $log->pay_status == '未支付')
          {
              $order_id_arr[] =  $item->order_id;
              $item->delete();
          }
        }
        BuyLog::whereIn('id',$order_id_arr)->where('pay_status','未支付')->delete();
     }

     /**
      * [生成订单记录]
      * @param  [type] $input [description]
      * @return [type]        [description]
      */
     public function generateOrderLog($request)
     {
        $input = $request->all();

        $varify =  varifyInputParam($input,'name,mobile,address,pay_platform');

        if($varify)
        {
          return zcjy_callback_data($varify,1);
        }

        if(strlen($input['mobile']) != 11)
        {
          return zcjy_callback_data('手机号格式不正确',1);
        }

        #访问ip
        $ip = $request->ip();

        #删除之前未支付的订单
        $this->deleteUnPayOrder($ip);

        #订单总价
        $input['price'] = $this->countIpPrices($ip);

        #分享平台
        $input['share_platform'] =  Cache::get($request->ip.'_shareplatform');

        #创建记录
        $log = BuyLog::create($input);

        #更新订单号
        $log->update(['number'=>time().'_'.$log->id]);

        #更新items
        BuyItems::where('access_ip',$ip)->whereNull('order_id')->update(['order_id'=>$log->id]);
    
        Cache::put('shop_pay_'.$ip, $log, 2);

        if($input['pay_platform'] == '支付宝'){
            if(!empty($input)){

                return zcjy_callback_data(route('alipay.pay').'?param='.zcjy_base64_en($request->ip()));

            }
            else{
                return zcjy_callback_data('支付异常',1);
            }
        }
        elseif($input['pay_platform'] == '微信'){
            return zcjy_callback_data(zcjy_base64_en($request->ip()));
        }

     }

     public function autowrap($string,$fontsize=20, $angle=0, $width=760) {
          $fontface = public_path().'/fonts/XinH_CuJW.TTF';
          // 参数分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
          $content = "";
          // 将字符串拆分成一个个单字 保存到数组 letter 中
          preg_match_all("/./u", $string, $arr);
          $letter = $arr[0];
          foreach($letter as $l) {
              $teststr = $content.$l;
              $testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
              if (($testbox[2] > $width) && ($content !== "")) {
                  $content .= PHP_EOL;
              }
              $content .= $l;
          }
          return $content;
      }

     /**
      * [生成快讯]
      * @param  [type] $post_id [description]
      * @return [type]          [description]
      */
     public function generateQuickNews($post,$request,$generate_repeat=true){
        #生成的相对路径
        $generate_path = '/images/quicknews/'.$post->id.'.jpg';

        if(!file_exists(public_path().$generate_path) || $generate_repeat){

          #底图http路径
          $base_image_path =  empty(getSettingValueByKeyCache('quick_news_base_img')) ? $request->root().'/images/quicknews/base.jpg' : getSettingValueByKeyCache('quick_news_base_img');

          #底图绝对文件路径
          $base_image_path =  public_path(parse_url($base_image_path)['path']);

          #打开底图
          $base_image =  Image::make($base_image_path);

          #插入利好 
          $base_image->text($post->like, 145, 375, function($font) {
              $font->file(public_path().'/fonts/XinH_CuJW.TTF');
              $font->size(26);
              $font->color('#111');
          });

           #插入利空
          $base_image->text($post->like, 455, 375, function($font) {
              $font->file(public_path().'/fonts/XinH_CuJW.TTF');
              $font->size(26);
              $font->color('#111');
          });

          #插入标题
          $title = $this->autowrap($post->name,20,0,786);
          $base_image->text($title, 35, 445, function($font) {
              $font->file(public_path().'/fonts/XinH_CuJW.TTF');
              $font->size(20);
              $font->color('#111');
              //fe5757
          });

          #插入日期时间
          $post_date = time_parse($post->created_at)->format('m月d日 H:i');
          $base_image->text($post_date, 35, 525, function($font) {
              $font->file(public_path().'/fonts/XinH_CuJW.TTF');
              $font->size(20);
              $font->color('#636e9b');
          });

         
          #插入正文
          $content = $this->autowrap($post->KuaiXunLimit);
          $base_image->text($content, 35, 575, function($font) {
              $font->file(public_path().'/fonts/XinH_CuJW.TTF');
              $font->size(20);
              $font->color('#111');
          });

          #插入底部名称
          $name = getSettingValueByKeyCache('name');
          $base_image->text($name, 155, 1090, function($font) {
              $font->file(public_path().'/fonts/XinH_CuJW.TTF');
              $font->size(24);
              $font->color('#636e9b');
          });


          #插入公众号二维码
          $qrcode_url = empty(getSettingValueByKeyCache('weixin')) ? $request->root().'/images/erweima.png' : getSettingValueByKeyCache('weixin');

          $qrcode_base_path =  public_path(parse_url($qrcode_url)['path']);


          $qrcode = Image::make($qrcode_base_path)->resize(108, 108);

          #插入二维码
          $base_image->insert($qrcode, 'bottom-right', 60, 90);

          #保存图片
          $base_image->save(public_path().$generate_path,90);
        }

        return $request->root().$generate_path;
     }

     /**
      * 浏览器中直接打开图片
      * @param  [type] $path [description]
      * @return [type]       [description]
      */
     public function openImg($path)
     {
        $img = file_get_contents($path,true);
        header("Content-Type: image/jpeg;text/html; charset=utf-8");
        echo $img;
        exit;
     }

    /**
     * [下载处理压缩图]
     * @param  [type]  $url  [description]
     * @param  integer $rate [description]
     * @param  string  $path [description]
     * @return [type]        [description]
     */
    public function downloadImage($url,$rate=60,$path='download/')
    {
        #发起图片资源curl请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);
        #能请求到文件
        if($file)
        {
          #基本地址
          $path = public_path($path);
          #本地存储
          $filename = $this->saveAsImage($url, $file, $path);
          #拼接路径
          $img_path = $path.$filename;
          #新实例化图
          $img = Image::make($img_path);
          #压缩品质
          $img->save($img_path, $rate);
          #浏览器打开
          return $this->openImg(Request::root().'/download/'.$filename);
        }
     }
    
    /**
     * [保存图片]
     * @param  [type] $url  [description]
     * @param  [type] $file [description]
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    private function saveAsImage($url, $file, $path)
    {
      $filename = pathinfo($url, PATHINFO_BASENAME);
      if(file_exists($path.$filename)){
        unlink($path.$filename);
      }
      $resource = fopen($path . $filename, 'a');
      fwrite($resource, $file);
      fclose($resource);
      return $filename;
    }

     public function generateErweima($request,$param,$size=200){
         $qr_code_path = public_path('qrcodes/'.zcjy_base64_en($param).'.jpg');
         if(!file_exists($qr_code_path)){
              \QrCode::format('png')->size($size)->generate($param,$qr_code_path);
              $qrcode = Image::make($qr_code_path);
              $qrcode->save($qr_code_path, 60);

         }
         return $request->root().'/qrcodes/'.zcjy_base64_en($param).'.jpg';
     }


/**
 * [上传文件]
 * @param  [type] $file     [description]
 * @param  string $api_type [description]
 * @param  [type] $user     [description]
 * @return [type]           [description]
 */
function uploadFiles($file , $api_type = 'web' , $user = null,$insert_shuiyin=false){
        if(empty($file)){
            return zcjy_callback_data('文件不能为空',1,$api_type);
        }
        #文件类型
        $file_type = 'file';
        #文件实际后缀
        $file_suffix = $file->getClientOriginalExtension();
        if(!empty($file)) {
              #图片
              $img_extensions = ["png", "jpg", "gif","jpeg"];
              #音频
              $sound_extensions = ["PCM","WAVE","MP3","OGG","MPC","mp3PRo","WMA","wma","RA","rm","APE","AAC","VQF","LPCM","M4A","cda","wav","mid","flac","au","aiff","ape","mod","mp3"];
              #excel
              $excel_extensions = ["xls","xlsx","xlsm"];
              #word pdf ppt
              $word_extensions = ["PDF","pdf","doc","docx","ppt","pptx","pps","ppsx","pot","ppa"];
              if ($file_suffix && !in_array($file_suffix , $img_extensions) && !in_array($file_suffix , $sound_extensions) && !in_array($file_suffix,$excel_extensions)) {
                 // return zcjy_callback_data('上传文件格式不正确',1,$api_type);
              }
              if(in_array($file_suffix, $img_extensions)){
                  $file_type = 'image';
              }
              if(in_array($file_suffix, $sound_extensions)){
                  $file_type = 'sound';
              }
              if(in_array($file_suffix,$excel_extensions)){
                  $file_type = 'excel';
              }
              if(in_array($file_suffix,$word_extensions)){
                  $file_type = 'word';
              }
        }

        #文件夹
        $destinationPath = empty($user) ? "uploads/admin/" : "uploads/user/".$user->id.'/';
        #加上类型
        $destinationPath = $destinationPath.$file_type.'/';

        if (!file_exists($destinationPath)){
            mkdir($destinationPath,0777,true);
        }
       
        $extension = $file_suffix;
        $fileName = str_random(10).'.'.$extension;
        $file->move($destinationPath, $fileName);

        #对于图片文件处理
        if($file_type == 'image'){
          $image_path=public_path().'/'.$destinationPath.$fileName;
          $img = Image::make($image_path);
         // 插入水印, 水印位置在原图片的右下角, 距离下边距 10 像素, 距离右边距 15 像素
          //$img->insert(public_path().'/images/gol/water1.png', 'bottom-right', 15, 15);
         //$img->resize(640, 640);
         $img->save($image_path,70);

        }

        $host='http://'.$_SERVER["HTTP_HOST"];

        if(env('online_version') == 'https'){
             $host='https://'.$_SERVER["HTTP_HOST"];
        }

        #路径
        $path=$host.'/'.$destinationPath.$fileName;

        return zcjy_callback_data([
                'src'=>$path,
                'current_time' => Carbon::now()->format('Y-m-d H:i:s'),
                'type' => $file_type,
                'current_src' => public_path().'/'.$destinationPath.$fileName
            ],0,$api_type);
    }

    //发送短信验证码
    public function sendVerifyCode($mobile,$type='reg')
    {
      $code = rand(100000,999999);
      sendSMS($mobile,$code);
        // $config = [
        //     // HTTP 请求的超时时间（秒）
        //     'timeout' => 5.0,

        //     // 默认发送配置
        //     'default' => [
        //         // 网关调用策略，默认：顺序调用
        //         'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        //         // 默认可用的发送网关
        //         'gateways' => [
        //             'aliyun',
        //         ],
        //     ],
        //     // 可用的网关配置
        //     'gateways' => [
        //         'errorlog' => [
        //             'file' => '/tmp/easy-sms.log',
        //         ],
        //         'aliyun' => [
        //             'access_key_id' => Config::get('web.SMS_ID'),
        //             'access_key_secret' => Config::get('web.SMS_KEY'),
        //             'sign_name' => Config::get('web.SMS_SIGN'),
        //         ]
        //     ],
        // ];

        // $easySms = new EasySms($config);

        // $code = rand(1000,9999);

        // $easySms->send($mobile, [
        //     'content'  => '短信验证码:'.$code,
        //     'template' => Config::get('web.SMS_TEMPLATE_VERIFY'),
        //     'data' => [
        //         'code'=>$code
        //     ],
        // ]); 
        session(['mobile_code_'.$type.$mobile=>$code]);
        return $code;   
    }
    
    /**
     * [用户的认证状态]
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function authCert($user)
    {
        return  $user ? $user->cert()->orderBy('created_at','desc')->first() : null;
    }

    /**
     * [检查认证]
     * @param  [type] $user        [description]
     * @param  string $attach_word [description]
     * @param  string $api_type    [description]
     * @return [type]              [description]
     */
    public function varifyCert($user,$attach_word='您当前',$api_type="web"){
        if(empty($user)){
            return zcjy_callback_data('未知错误',1,$api_type);
        }
        $status = false;
        $cert = $this->authCert($user);
        if(empty($cert)){
            return zcjy_callback_data($attach_word.'未认证,请在个人中心完成身份认证后使用',1,$api_type);
        }

        if($cert->status == '审核中' || $cert->status =='未通过'){
            return zcjy_callback_data($attach_word.'认证正在审核中或未通过审核',1,$api_type);
        }

        // if($attach_word == 'result'){
        //     return $cert;
        // }

        return $status;
    }


    /**
     * [优秀作家]
     * @return [type] [description]
     */
    public function goodWriters($skip=0,$take=9){
       return Cache::remember('zcjy_good_writers_'.$skip.$take, Config::get('web.shrottimecache'), function() use($skip,$take){
              return User::where('good_writer',1)
              ->skip($skip)
              ->take($take)
              ->get();
        });
    }


    //检查文章的收藏状态
    public  function attentionPostStatus($user,$post_id)
    {
        $user = optional($user);
        return PostAttention::where('user_id',$user->id)
                ->where('post_id',$post_id)
                ->first();
    }

    //发起收藏操作
    public function actionAttentionPost($user,$post_id)
    {

        $attention_status = $this->attentionPostStatus($user,$post_id);
        $status = '收藏成功';
        #已经收藏的 删除
        if($attention_status){
            $attention_status->delete();
            $status = '取消收藏成功';
        }
        else{
            #之前如果没有收藏 就直接加记录
            PostAttention::create([
                'post_id'=>$post_id,
                'user_id'=>$user->id
            ]);
        }
        \Artisan::call('cache:clear');
        return zcjy_callback_data($status);
    }

    //用户收藏的文章
    public function userCollectPosts($user,$skip=0,$take=20)
    {
        return Cache::remember('zcjy_user_collect_posts_'.$user->id, Config::get('web.shrottimecache'), function() use ($user,$skip,$take){
            $post_attentions = PostAttention::where('user_id',$user->id)
            ->orderBy('created_at','desc')
            ->get();
            $post_id_arr = [];
            foreach ($post_attentions as $key => $val) {
                    $post_id_arr[] = $val->post_id;
            }
            return Post::whereIn('id',$post_id_arr)
            ->where('status',1)
            ->skip($skip)
            ->take($take)
            ->get();
        });
    }
  
}
