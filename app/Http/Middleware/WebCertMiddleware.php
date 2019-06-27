<?php

namespace App\Http\Middleware;

use Closure;
use Overtrue\Socialite\User as SocialiteUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class WebCertMiddleware
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
        $cert_varify = app('common')->varifyCert(auth('web')->user());
        if($cert_varify){
            if($request->ajax()){
                return $cert_varify;
            }
            else{
                return redirect('/user/center/certs');
            }
            
        }
        return $next($request);
    }
}
