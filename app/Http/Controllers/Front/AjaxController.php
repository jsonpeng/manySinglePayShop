<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Hash;
use Mail;
use Illuminate\Support\Facades\Input;

use Cache;
use Log;

class AjaxController extends Controller
{
    //询问记录知否支付成功
    public function askLogStatusAction(Request $request)
    {
        return app('common')->askLogStatus($request->get('param'));
    }

    //更新item数量
    public function updateItemNum(Request $request)
    {
        return app('common')->updateItemNum($request);
    }

    //添加商品
    public function addProduct(Request $request)
    {
        return app('common')->addProduct($request);
    }

    //保存购买记录
    public function saveLog(Request $request)
    {
        return app('common')->generateOrderLog($request);
    }

    //上传文件
    public function uploadFile(Request $request)
    {
        $file =  Input::file('file');
        return app('common')->uploadFiles($file);
    }

    /**
     *发送邮箱验证码
     */
    public function sendEmailCode(Request $request,$type='reg'){
            $email=$request->input('email');
            $code=rand(1000,9999);
            $name = empty(getSettingValueByKeyCache('company_name')) ? 'gol公司' : getSettingValueByKeyCache('company_name');
            if(!empty($email)){
                 if($type == 'reg'){
                      if(User::where('email',$email)->count()){
                        return zcjy_callback_data('该用邮箱已被注册,请重新换个邮箱',1);
                      }
                    //保存验证码到session中去
                    session()->put('email_code_'.$request->ip(),$code);
                  }
                  else{
                    session()->put('email_code_'.$type.'_'.$request->ip(),$code);
                  }
                
                  Mail::send('emails.index',['name'=>$name,'code'=>$code],function($message) use ($email,$name){ 
                    $to = $email;
                    $message ->to($to)->subject('【'.$name.'】邮箱验证码');
                  });
                return zcjy_callback_data('发送成功');
            }
            else{
            return zcjy_callback_data('请输入邮箱',1);
          }
    }

    //发送手机验证码
    public function sendMobileCode(Request $request)
    {
        $input = $request->all();
        $varify = varifyInputParam($input,['mobile']);
        if($varify){
            return zcjy_callback_data($varify,1);
        }
        $type = 'reg';
        if(array_key_exists('type',$input) && !empty($input['type'])){
            $type = $input['type'];
        }
        $count = User::where('mobile',$input['mobile'])->count();
        if($type == 'reg'){
                #如果已经有用户注册过该手机号
                if($count)
                {
                    return zcjy_callback_data('该手机号已经被注册过',1);
                }
        }
        elseif($type == 'login'){
            #如果没有用户注册过该手机号
                if(!$count)
                {
                    return zcjy_callback_data('该手机号没有被注册过,请先完成注册后登陆',1);
                }
        }
    
        $code = app('common')->sendVerifyCode($input['mobile'],$type);

        return zcjy_callback_data($code);
    }

   


    //开始二维码扫码操作
    public function startErweimaScan(Request $request)
    {
        //session(['ip_scan'.$request->ip()=>'wait scan']);
        Cache::put('ip_scan'.$request->ip(), 'wait scan',1);

        $erweima_param = $request->root().'/weixin_auth?ip='.$request->ip();
       
        return zcjy_callback_data(app('common')->generateErweima($request,$erweima_param));
    }

    //询问二维码状态
    public function askScanErweimaResult(Request $request)
    {
        $scan_result = Cache::get('ip_scan'.$request->ip());

        if(is_numeric($scan_result)){
            $user = User::find($scan_result);
            if(!empty($user)){
                auth('web')->login($user);
                $this->updateUserInfo($user,$request);
                $scan_result = 'login success';
            }
        }
        return zcjy_callback_data($scan_result);
    }

    //下载图
    public function downloadImg(Request $request)
    {
        $input = $request->all();
        $rate = 60;
        if(array_key_exists('rate',$input) && !empty($input['rate']) && is_numeric($input['rate'])){
            $rate = $input['rate'];
        }
        return app('common')->downloadImage($request->get('url'),$rate);
    }
    

}