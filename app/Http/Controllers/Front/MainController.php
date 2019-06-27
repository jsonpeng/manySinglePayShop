<?php
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class MainController extends Controller
{

    //首页
    public function index(Request $request)
    { 
        app('common')->dealIndexPlatform($request);
        return view('front.index');
    }

    //处理支付
    public function settle(Request $request)
    { 
          $ip = $request->ip();
          $price = app('common')->countIpPrices($ip);
     	    if($price == 0)
          {
            return redirect('/');
          }
          $items = app('common')->ipItems($ip);
          return view('front.settle',compact('price','items'));
    }

    //服务协议
    public function protocol(Request $request)
    {
      return view('front.protocol');
    }
    
}