<?php
/**

 */
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

use App\Models\Category;
use App\Models\Cities;
use App\Models\House;
use Intervention\Image\ImageManagerStatic as Image;
//use Image;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

include_once 'send-sms.php';



trait WeixinService
{
    public static function getWeixinInfo()
    {
      return 'weixin info';
    }
}

class TestWeixin{
    use WeixinService;
}


function trclass($key=null){
  $arr = ['success','danger','warning','info','error'];
  if(!empty($key) || $key == 0){
    return optional($arr)[$key];
  }
  else{
    return $arr;
  }
}

function hourse($id)
{
  try {
      $hourse = House::find($id);
      return $hourse;
  } catch (Exception $e) {
      return $e;
  }

}

/**
 * [手动分页]
 * @param  [type]  $data    [description]
 * @param  [type]  $request [description]
 * @param  integer $perPage [description]
 * @return [type]           [description]
 */
function operatPaginate($data,$request,$perPage = 3){
    if(!is_array($data)){
        $data = $data->toArray();
    }
    if ($request->has('page')) {
        $current_page = $request->input('page');
        $current_page = $current_page <= 0 ? 1 :$current_page;
    } 
    else {
        $current_page = 1;
    }
    $item = array_slice($data, ($current_page-1)*$perPage, $perPage);//$data为要分页的数组
    $totals = count($data);
    $paginator =new LengthAwarePaginator($item, $totals, $perPage, $current_page, [
        'path' => Paginator::resolveCurrentPath(),
        'pageName' => 'page',
    ]);
    return $paginator;
}


//加密
function zcjy_base64_en($str){
    $str = str_replace('/','@',str_replace('+','-',base64_encode($str)));
   // $str = str_replace('=','',$str);
    return $str;
}

//解密
function zcjy_base64_de($str){
    $encode_arr = array('UTF-8','ASCII','GBK','GB2312','BIG5','JIS','eucjp-win','sjis-win','EUC-JP');
    $str = base64_decode(str_replace('@','/',str_replace('-','+',$str)));
    $encoded = mb_detect_encoding($str, $encode_arr);
    $str = iconv($encoded,"utf-8",$str);
    return $str;
}

//截取指定字符串前多少位
function des($str, $num){
        global $Briefing_Length;
        mb_regex_encoding("UTF-8");
        $Foremost = mb_substr($str, 0, $num);
        $re = "<(\/?) 
    (P|DIV|H1|H2|H3|H4|H5|H6|ADDRESS|PRE|TABLE|TR|TD|TH|INPUT|SELECT|TEXTAREA|OBJECT|A|UL|OL|LI| 
    BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|SPAN)[^>]*(>?)";
        $Single = "/BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|BR/i";

        $Stack = array(); $posStack = array();

        mb_ereg_search_init($Foremost, $re, 'i');

        while($pos = mb_ereg_search_pos()){
            $match = mb_ereg_search_getregs();

            if($match[1]==""){
                $Elem = $match[2];
                if(mb_eregi($Single, $Elem) && $match[3] !=""){
                    continue;
                }
                array_push($Stack, mb_strtoupper($Elem));
                array_push($posStack, $pos[0]);
            }else{
                $StackTop = $Stack[count($Stack)-1];
                $End = mb_strtoupper($match[2]);
                if(strcasecmp($StackTop,$End)==0){
                    array_pop($Stack);
                    array_pop($posStack);
                    if($match[3] ==""){
                        $Foremost = $Foremost.">";
                    }
                }
            }
        }

        $cutpos = array_shift($posStack) - 1;
        $Foremost =  mb_substr($Foremost,0,$cutpos,"UTF-8");
        return strip_tags($Foremost);

    }

//gol 类型
function gol_types(){
  return [
      '青旅',
      '客栈',
      '民宿',
      '空间'
  ];
}


/**
 * [把文字加粗并且变色]
 * @param  [type] $string [文字]
 * @param  string $color  [颜色 默认红色]
 * @return [type]         [description]
 */
function tag($string,$color='red'){
    return '&nbsp;&nbsp;<strong style=color:'.$color.'>'.$string.'</strong>&nbsp;&nbsp;';
}

/**
 * [把文字变成链接 并且带上颜色]
 * @param  [type]  $string [文字]
 * @param  [type]  $link   [链接]
 * @param  string  $color  [颜色 默认橙色]
 * @param  boolean $nbsp   [是否加左右间隔]
 * @return [type]          [description]
 */
function a_link($string,$link,$color='orange',$nbsp=true){
     return $nbsp ? '&nbsp;&nbsp;<a target=_blank href='.$link.' style=color:'.$color.'>'.$string.'</a>&nbsp;&nbsp;' : '<a target=_blank href='.$link.' style=color:'.$color.'>'.$string.'</a>';
}


function varifyMenusName($name,$menus){
  $childMenus = [
    ['name'=>'公司概况','link'=>'/cat/2'],
    ['name'=>'新闻资讯','link'=>'/cat/7'],
    ['name'=>'精品案例','link'=>'/cat/9'],
    ['name'=>'联系我们','link'=>'/page/1'],
  ];
  if(count($menus)){
       foreach ($menus as $key => $val) {
          if($val->name == $name){
              $childMenus = $val['children'];
          }
          else{
            if(count($val['children'])){
              foreach ($val['children'] as $key => $childval) {
                if($childval->name == $name){
                    $childMenus = $val['children'];
                }
              }
            }
          }
        }
  }
  return $childMenus;
}


//时间倒序带分页
function descAndPaginateToShow($obj,$attr='created_at',$desc='desc'){
       if(!empty($obj)){
            return $obj->orderBy($attr,$desc)->paginate(15);
        }else{
            return [];
        }
}


function generateMobileUserName($mobile)
{
  return '手机号'.$mobile.'用户';
}
 

/**
 * [地图地址详细信息]
 * @param  [type] $address [description]
 * @return [type]          [description]
 */
function getAddressDetail($address)
{
     return Cache::remember('zcjy_get_address_detail'.$address, Config::get('web.longtimecache'), function() use ($address) {
            $client = new Client(['base_uri' => 'http://api.map.baidu.com']);
            $response = $client->request('GET', '/place/v2/suggestion?query='.mb_substr($address , 0 , 10 , 'utf-8').'&region='.mb_substr($address , 0 , 6 , 'utf-8').'city_limit=true&output=json&ak=usHzWa4rzd22DLO58GmUHUGTwgFrKyW5');
            $address_obj = $response->getBody();
            $address_obj = json_decode($address_obj,true);
            return $address_obj['result'][0];
     }); 
}


function getDetailBylt($jindu,$weidu)
{
     return Cache::remember('zcjy_get_address_by_location_lt'.$jindu.'_'.$weidu, Config::get('web.longtimecache'), function() use ($jindu,$weidu) {
            $client = new Client(['base_uri' => 'http://api.map.baidu.com']);
            $response = $client->request('GET', '/geocoder/v2/?ak=usHzWa4rzd22DLO58GmUHUGTwgFrKyW5&location='.$weidu.','.$jindu.'&output=json&pois=1');
            $obj = $response->getBody();
            $obj = json_decode($obj,true);
            return ($obj['result']['addressComponent']);

     }
    );
}

/**
 * [地图逆解析 根据经纬度获取地址详情]
 * @param  [type] $jindu [description]
 * @param  [type] $weidu [description]
 * @return [type]        [description]
 */
function getAddressLocation($jindu,$weidu){
  return Cache::remember('zcjy_get_address_by_location_'.$jindu.'_'.$weidu, Config::get('web.longtimecache'), function() use ($jindu,$weidu) {
            $address = file_get_contents('http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location='.$weidu.','.$jindu.'&output=json&pois=1&ak=usHzWa4rzd22DLO58GmUHUGTwgFrKyW5');

            $address = explode(',',$address); 

            $sub_address = address_str_sub($address,3,21);
            $province = address_str_sub($address,9,12);
            $city = address_str_sub($address,10,8);
            $district = address_str_sub($address,12,12);

         
            $client = new Client(['base_uri' => 'http://api.map.baidu.com']);
            $response = $client->request('GET', '/place/v2/search?query=大学&location='.$weidu.','.$jindu.'&radius=5000&output=json&ak=usHzWa4rzd22DLO58GmUHUGTwgFrKyW5');
            $school_obj = $response->getBody();
            $school_obj = json_decode($school_obj,true);
            //return ($school_obj['results']);
            return (object)['address'=>$sub_address,'province'=>$province,'city'=>$city,'district'=>$district,'school'=>$school_obj['results']];
    });
} 

/**
 * [address_str_sub description]
 * @param  [type]  $str [description]
 * @param  integer $len [3,21地址 9,12省份]
 * @return [type]       [description]
 */
function address_str_sub($address,$len1=3,$len2=21){
    $str = substr($address[$len1],$len2);
    $str =substr($str,0,strlen($str)-1);
    return $str;
}

function varifyPidToBackByPid($pid){
    $parent_cities=Cities::find($pid);
    if($parent_cities->level==1){
        return route('cities.index');
    }else{
        $back_cities=Cities::find($pid)->ParentCitiesObj;
        if(!empty($back_cities)) {
            return route('cities.child.index', [$back_cities->id]);
        }
    }
}

function getCitiesNameById($cities_id)
{
    $city=Cities::find($cities_id);
    if(!empty($city)) {
        return $city->name;
    }else{
        return null;
    }
}

function time_parse($time){
  return Carbon::parse($time);
}

function parent_cat($category){
  return Category::find($category->parent_id);
}

function is_online()
{
  return env('APP_ENV') == 'local' ? false : true;
}


function word_en($word){
  $en_arr = [
    '首页'=>'HOME',
    '公司概况'=>'ABOUT US',
    '新闻资讯'=>'NEWS',
    '精品案例'=>'CASES',
    '政策标准'=>'POLICY',
    '影像长廊'=>'IMAGE',
    '下载中心'=>'DOWNLOAD',
    '留言板'  =>'MESSAGE',
    '联系我们'=>'CONTACT US',
    '关于我们' => 'about'
  ];
  return isset($en_arr[$word]) ? $en_arr[$word] : '';
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
          $img->insert(public_path().'/images/gol/water1.png', 'bottom-right', 15, 15);
          $img->resize(640, 640);
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

/**
 * [过滤空的输入]
 * @param  [type] $input [description]
 * @return [type]        [description]
 */
function filterNullInput($input){
    foreach ($input as $key => $value) {
        if(is_null($value) || $value == '' || empty($value) && $value != 0){
           unset($input[$key]);
        }
    }
    return $input;
}


/**
 * [默认直接通过数组的值 否则通过数组的键]
 * @param  [type] $input      [description]
 * @param  array  $attr       [description]
 * @param  string $valueOrKey [description]
 * @return [type]             [description]
 */
function varifyInputParam($input,$attr=[],$valueOrKey='value'){
    #过滤空字符串
    $input = filterNullInput($input);
    $status = false;
    if(!is_array($attr)){
            $attr = explode(',',$attr);
    }
    #第一种带键值但值为空的情况
    foreach ($input as $key => $val) {
        if(array_key_exists($key,$input)){
            if(empty($input[$key]) && $input[$key]!=0){
                $status = '信息未完善';
            }
        }
    }
    #第二种是针对提交的指定键值
    if(count($attr)){
        foreach ($attr as $key => $val) {
            if($valueOrKey == 'value'){
                if(!array_key_exists($val,$input) || array_key_exists($val,$input) && empty($input[$val]) && $input[$val] != 0){
                    $status = '信息未完善';
                }
            }
            else{
                 if(!array_key_exists($key,$input) || array_key_exists($key,$input) && empty($input[$key]) && $input[$key] != 0){
                    $status = '信息未完善';
                }
            }
        }
    }
    return $status;
}

/**
 * [接口请求回转数据格式]
 * @param  type    $data     [成功/失败提示]
 * @param  integer $code     [0成功 1失败]
 * @param  string  $api      [默认不传是api格式 传web是web格式]
 * @return [type]            [description]
 */
function zcjy_callback_data($data=null,$code=0,$api='web'){
    return $api === 'api'
        ? api_result_data_tem($data,$code)
        : web_result_data_tem($data,$code);
}


/**
 * [api接口请求回转数据]
 * @param  [type]  $message  [成功/失败提示]
 * @param  integer $code     [0成功 1失败]
 * @return [type]            [description]
 */
function api_result_data_tem($data=null,$status_code=0){
     return response()->json(['status_code'=>$status_code,'data'=>$data]);
}

/**
 * [web程序请求回转数据]
 * @param  [type]  $message  [成功/失败提示]
 * @param  integer $code     [0成功 1失败]
 * @return [type]            [description]
 */
function web_result_data_tem($message=null,$code=0){
    return response()->json(['code'=>$code,'message'=>$message]);
}


/**
 * 获取设置信息
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
function getSettingValueByKey($key){
    return app('setting')->valueOfKey($key);
}

function getSettingValueByKeyCache($key){
    return Cache::remember('getSettingValueByKey'.$key, Config::get('web.cachetime'), function() use ($key){
        return getSettingValueByKey($key);
    });
}


function get_page_custom_value_by_key($page,$key){
    return Cache::remember('zcjy_custom_page_'.$key.'_'.$page->id, Config::get('web.shrottimecache'), function() use ($page,$key) {
        $pageItems = $page->pageItems();
        if (empty($pageItems->get())) {
            return '';
        } else {
            if (empty($pageItems->where('key', $key)->first())) {
                return '';
            } else {
                return $pageItems->where('key', $key)->first()->value;
            }
        }
    });
}

function get_post_custom_value_by_key($post,$key){
    return Cache::remember('zcjy_custom_post_'.$key.'_'.$post->id, Config::get('web.shrottimecache'), function() use ($post,$key) {
        $postItems = $post->items();
        if (empty($postItems->get())) {
            return '';
        } else {
            if (empty($postItems->where('key', $key)->first())) {
                return '';
            } else {
                return $postItems->where('key', $key)->first()->value;
            }
        }
    });
}

/**
 * 所有性格
 */
function settingList($attr){
  $list= preg_replace("/\n|\r\n/", "_",getSettingValueByKey($attr));
  $list_arr = explode('_',$list);
  return $list_arr;
}


//空格列表处理
function spaceList($attr)
{
  $list= preg_replace("/\n|\r\n/", "_",$attr);
  
  return explode('_',$list);;
}

//从html中获取图片
function get_content_img($text){
    preg_match_all('/(src)=("[^"]*")/i', $text, $matches);   
    $images_arr = $matches[0];
    $match_arr = [];
    if(count($images_arr)){
        foreach ($images_arr as $key => $value) {
            array_push($match_arr,substr($value,5));
        }   
    }
    return $match_arr;
}

