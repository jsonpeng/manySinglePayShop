<?php

namespace App\Http\Controllers\Front;

use Yansongda\Pay\Pay;
use Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubmitLog;
use EasyWeChat\Factory;
use Cache;

class PayController extends Controller
{
   #支付宝配置信息
    protected $alipay_config = [
        #appid
        'app_id' => '2019010862822541',
        #通知地址
        'notify_url' => '/alipay/notify',
        #验签地址
        'return_url' => '/alipay/return',
        #支付宝公钥
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAy2QxvfTeaT/HvYLjBRL48frfySXEi9UV2P965XtF7/aDOECtr/NsQ4R3s3WPx7jnu1gp080wChUVNocxks9xnlD3wLAFV1+LrgFXUuqFjOQMEUP7aJyRRHOoYAJD08PkE+d64ii35MR3EQ4Itymg2ohlamNQZA6HuH5HBYVraNLPOvUz0qLxZ67ZtKS/BItgu2qprSiq+Uz+7MLpF55PsypDlgGz/nZck2nAKmfBjUcSVrmKWaBSgetP0Ud1E5QCvt2CoACDjZrTNQgP2C2bAD5ZeGraO5SfDwofSVrsK0mIANBnhhA505W9bWkLs7m2L1A8cvm7Uigu/XSUfwNwcQIDAQAB',
        #商户私钥 加密方式： **RSA2**  
        'private_key' => 'MIIEpAIBAAKCAQEA5hUZaY6/MTFm4VTSms0ID8Zi1wcMmqdTJsPno7QxP9egbOB9ZNXhj9gGhFVZdqhpLeRGkVnX6+MHH9nWw5cL6lwxN6FLqHZ6UACdhdboyOqUff3IDTlXse+tMrOlUkgc1PYsa6CPrjaIxtLuJHmXXxrqxWG0jJcJJFkqL6Dhg589RCEviP1Cc4XLRamrqtN3RaxPt9N+xV4SHOVMwVh8Do3F4lXE5md3EhcYIQkdWkjp/fswOnktT0gGj9X685rE1ZHIAV4STEHCkGZTvrp+w66nUSpxmX0xUATdBcwplKYEfGLgN/wPdJ7ZaH1d9iNiFE7BQ2r6/Q2TipxBrsJdyQIDAQABAoIBAQC9RhQuswBznnlM2vOZ5xs/pur+i00CGK4d0MFI+V4eb+sIRjDBd/Vj2MmbqX68T1SfLRAkWG15Hr1opVK4ehSSSh8u7WCJCFYcZDUxuhar2dYoQ1KEFm0e8tVfRUu2AZ6+TnlCXMZ2AWTJcxH3LZOp6EHD+FmH4mPh4/wBTG7YT+LNJNzvkpErDkNVzIEB/8Tmg70AsX6Zsp70gkIg5puzGguMUcsDB5bwFkpX/TU26p7nk3hiUiZiNP81e31Vqe+epuTxtmCm8chmKR6dyFOGZAyBw/zjYF+ilz0PtsU5rfBeYIGwg83VJgr5QBh2JShQ7qjZJ9wrcZ28knhiRlCBAoGBAPRRsrw+3xgXIJWO3u42IGdsvV+IaFse16xYeous6gvUqSlvY+Z2/RG+nsaFT8+18+BslHnhIXhVRUHgXqW8UxRiQw6vxh66lJu2PVlrh705nj3pFKRUtf9VJqqL6cdRKxecwziJnzmGJtyJYvR8LDYTT8E5bPc5hN2/6NUejVYxAoGBAPEVJz0EodqUiwPATIsBriSeyUkolU23L6CIYJlgtL/srQczWkx2BcNoT0HlAM24PPudw6XjJxIRLmAkBYY5LZhzAruJwFIORad6FCNhSrDx7Xzhb/wjZ7laHJ3N4SA04zk1CJbhlf/5V9X53WHfhDOf5+Z4RmcCK8rx6rbsoGMZAoGAHeQI7AL9JGNf9yw9lgNFP6IMIS39JnjFhi5k/8Wt9LiV4Z3hKQcRuyQJJNyWgSEPrztZhvfGMoSsLn0W10wNFgdXkOpsYMIPAGXxZ4lCWCI+e/CSN/CtO4ndaywm8924WfEx6S7dLhp9kqm0U5kFh7AhJ9CwxiZhXQfnontUa2ECgYEAjVLLJ7fZcZr2SwKlXC9l+E2kzWAe9enW35JSnlbUXlXNsJTn8D6Xbk9tdsFZ0T6ZcR6wnEQmmS69Mtqq6l4GXoG9Lla4COIY7u5fc8YK1ONdRoGY9gODQGKUt+UCfbDDKrvuBxTCq8VtOiA5KLCwfNrWRIJpMuVQ6q0Z3JWmB7ECgYBdXaiLm5IAWxpWZemfp+/kDSAOUjvNOTE+fwliSfYquzEBVYP3c7q2VhwcZw1ZSrzmbCy1Wh1J5g977pEpwhqOEcyVhzy1dk9hpO2B+8OQMAQQ+hVy+HsM0nvLj0/7DkkhlCFKqs+Xb8vAgnVJwYipM58pyxpyRJkY9gGfiC2Txg==',
        #optional,设置此参数，将进入沙箱模式 一般可以直接注释
        //'mode' => 'dev', 
    ];

    #微信配置信息
     protected $wechat_config = [
        'appid' => 'wxe358634266217184', # APP APPID
        'app_id' => 'wxe358634266217184', # 公众号 APPID
        'miniapp_id' => 'wxb3fxxxxxxxxxxx', # 小程序 APPID
        'mch_id' => '1523180561',#商户号
        'key' => 'Nc0ifIrQJzDoAoBEDX478tLiODAa46N1',#商户key
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


    /**
     * 根据request生成订单
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    private function generateOrder($request,$type='alipay')
    {
        $input = session('shop_pay_'.$request->ip());

        if($request->has('param'))
        {
             $input = Cache::get('shop_pay_'.zcjy_base64_de($request->get('param')));
        }

        if(empty($input))
        {
            return null;
        }

        $order = null;

        $price = $input->price;

        if($type=='wechat')
        {
            $order = [
                'out_trade_no' =>  $input->number,
                'total_fee' => (string)$price*100, // **单位：分**
                'body' => '购买产品',
            ];
        }
        else{
            $order = [
                'out_trade_no' => $input->number,
                'total_amount' => (string)$price,
                'subject' => '购买产品',
            ];
        }
        return $order;
    }

    //支付宝网站支付
    public function alipayIndex(Request $request)
    {
        $order = $this->generateOrder($request);

        if(empty($order))
        {
            return redirect('/');
        }

        $config = $this->alipay_config;
        $config['notify_url'] = $request->root().$config['notify_url'];
        $config['return_url'] = $request->root().$config['return_url'];
        
        $alipay = Pay::alipay($config);

        if($request->get('pay_platform') == 'mobile')
        {
            return $alipay->wap($order);
        }

        return $alipay->web($order);
    }

    //支付宝同步通知
    public function return(Request $request)
    {
        $config = $this->alipay_config;
        $config['notify_url'] = $request->root().$config['notify_url'];
        $config['return_url'] = $request->root().$config['return_url'];

        $data = Pay::alipay($config)->verify(); // 是的，验签就这么简单！

        $input = $request->all();

        // app('common')->successOrderLog($input['out_trade_no']);

        return redirect('/');
        // 订单号：$data->out_trade_no
        // 支付宝交易号：$data->trade_no
        // 订单总金额：$data->total_amount
    }


    //支付宝异步通知
    public function notify(Request $request)
    {
        $config = $this->alipay_config;
        $config['notify_url'] = $request->root().$config['notify_url'];
        $config['return_url'] = $request->root().$config['return_url'];
        $alipay = Pay::alipay($config);
    
        try{
            $data = $alipay->verify(); // 是的，验签就这么简单！

            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            app('common')->successOrderLog(($data['out_trade_no']));
         

        } catch (Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success();// laravel 框架中请直接 `return $alipay->success()`
    } 

    //h5 wap付
    public function weixinWeb(Request $request)
    {
        $order = $this->generateOrder($request,'wechat');

        if(empty($order))
        {
            return redirect('/');
        }

        return (Pay::wechat($this->wechat_config)->wap($order));
    }

    //生成二维码
    public function generateErweima($param,$request_root = null)
    {
        $path = '/qrcodes/'.zcjy_base64_en($param).'.png';

        $public_path = public_path($path);

        if(!file_exists($public_path))
        {
            \QrCode::format('png')->size(200)->generate($param,$public_path);
        }

        if(!empty($request_root))
        {
            $path = $request_root.$path;
        }

        return $path;
    }

    //微信扫码付
    public function weixinScan(Request $request)
    {
       $order = $this->generateOrder($request,'wechat');

       if(empty($order))
       {
         return zcjy_callback_data('支付异常',1);
       }
    
        $result = Pay::wechat($this->wechat_config)->scan($order)->code_url;
    
        return zcjy_callback_data($this->generateErweima($result,$request->root()));
    }

    //微信异步通知
    public function weixinNotify()
    {
        $pay = Pay::wechat($this->wechat_config);
        try{
            $data = $pay->verify(); // 是的，验签就这么简单！
            $message = $data->all();   
             ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                   app('common')->successOrderLog($message['out_trade_no']);
                // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    
                }
            } 
            else {
                return $fail('通信失败，请稍后再通知我');
            }
            //Log::debug('Wechat notify', $data->all());
        } catch (Exception $e) {
            // $e->getMessage();
        }
        
        return $pay->success();// laravel 框架中请直接 `return $pay->success()`
    }

}