<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale('zh');
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //防止污染后台
        if(!empty($_SERVER['REQUEST_URI']) && substr($_SERVER['REQUEST_URI'], 0, 5) != '/zcjy'){
            View::composer(
                '*', 'App\Http\ViewComposers\BaseComposer'
            );
        }
        View::composer(
                '*', 'App\Http\ViewComposers\AdminComposer'
        );
        //绑定setting
       $this->app->singleton('setting', 'App\Repositories\SettingRepository');
       $this->app->singleton('common', 'App\Repositories\CommonRepository');
    
        
    }
}
