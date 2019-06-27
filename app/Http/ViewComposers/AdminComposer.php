<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;


class AdminComposer{

	public function compose(View $view)
    {
    	 $view->with('online',is_online());
    }
    
}