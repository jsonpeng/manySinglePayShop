<?php

namespace App\Http\Middleware;

use Closure;
use Overtrue\Socialite\User as SocialiteUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class WebAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth('web')->check()){
            if($request->ajax()){
                 return zcjy_callback_data('请登录后使用',1);
            }
            else{
                  return redirect('/user/login');
            }
        }
        return $next($request);
    }
}
