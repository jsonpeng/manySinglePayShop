<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Config;
use Log;


class UserController extends Controller
{
 

    public function __construct()
    {
      
    }

    public function index(Request $request)
    {
        $input=$request->all();
        $users=User::where('id','>','0');
        $page_list=false;
        $tools=1;

        if(array_key_exists('name',$input) && !empty($input['name'])){
            $users=$users->where('name','like','%'.$input['name'].'%');
        }
        if(array_key_exists('mobile',$input)&& !empty($input['mobile']) ){
            $users=$users->where('mobile','like','%'.$input['mobile'].'%');
        }
        if(array_key_exists('page_list',$input)&& !empty($input['page_list']) ){
            $page_list=$input['page_list'];
        }
        if($page_list){
            $users = $users->paginate($page_list);
        }else{
            $users=$users->paginate(15);
        }


    	return view('admin.user.index', compact('tools','users','input'));
    }

    /**
     * 显示用户详情
     * @param    [type]      $id [description]
     * @return   [type]          [description]
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        
        if (empty($user)) {
            return redirect('/zcjy/users');
        }

        // $orders = app('common')->houseJoinRepo()->userHouseJoins($user->id);
        // $houses = app('common')->houseRepo()->myHourses($user->id);
        // $gols = app('common')->golRepo()->myGols($user->id);
        $notices = app('notice')->authNotices($user,true);
        $posts =  app('common')->postRepo()->userPosts($user);
        $collects =  app('common')->userCollectPosts($user);
        
        return view('admin.user.show', compact('user','notices','posts','collects'));
    }



}
