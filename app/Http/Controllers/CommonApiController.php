<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;


class CommonApiController extends Controller
{
  
    public function __construct(){
    }
     //清空缓存
    public function clearCache(){
        Artisan::call('cache:clear');
        return ['status'=>true,'msg'=>''];
    }

}
