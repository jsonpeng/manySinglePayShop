<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test',function(){
		return sendSMS('13125110550');
});

Route::group(['prefix' => 'alipay','namespace'=>'Front'], function () {
	Route::any('notify','PayController@notify');
	Route::any('return','PayController@return');
	Route::get('pay','PayController@alipayIndex')->name('alipay.pay');
});


Route::group(['prefix' => 'wechat','namespace'=>'Front'], function () {
	Route::get('pay_web','PayController@weixinWeb');
	Route::any('notify','PayController@weixinNotify');
	Route::get('pay','PayController@weixinScan')->name('wechat.pay');
});


Route::group(['middleware'=>['web'],'namespace'=>'Front'],function(){
	//前端路由
	Route::get('/', 'MainController@index')->name('index');
	//结算
	Route::get('settle', 'MainController@settle')->name('settle');

	Route::get('protocol','MainController@protocol');

	Route::group(['prefix'=>'ajax'],function(){
		
		//保存记录
		Route::post('save','AjaxController@saveLog');
		//添加商品
		Route::post('add_product','AjaxController@addProduct');
		//更新item数量
		Route::post('update_item_num','AjaxController@updateItemNum');
		//询问记录是否支付成功
		Route::post('ask_log','AjaxController@askLogStatusAction');

	});

});

/**
 *后台
 */
//刷新缓存
Route::post('/clearCache','CommonApiController@clearCache');

//在页面中的URL尽量试用ACTION来避免前缀的干扰
Route::group([ 'prefix' => 'zcjy', 'namespace' => 'Admin'], function () {
	//登录
	Route::get('login', 'LoginController@showLoginForm');
	Route::post('login', 'LoginController@login');
	Route::get('logout', 'LoginController@logout');
});

//后台管理系统
Route::group(['middleware' => ['auth.admin:admin'], 'prefix' => 'zcjy'], function () {
	//说明文档
	Route::get('/doc', 'SettingController@settingDoc');

	//后台首页
	Route::get('/', 'SettingController@setting');
	
    //系统设置
    Route::get('settings/setting', 'SettingController@setting')->name('settings.setting');
    Route::post('settings/setting', 'SettingController@update')->name('settings.setting.update');
    //地图选择
    Route::get('settings/map','SettingController@map');
    //修改密码
	Route::get('setting/edit_pwd','SettingController@edit_pwd')->name('settings.edit_pwd');
    Route::post('setting/edit_pwd/{id}','SettingController@edit_pwd_api')->name('settings.pwd_update');

    //横幅管理
    Route::resource('banners','BannerController');
 	
	Route::resource('{banner_id}/bannerItems', 'BannerItemController');

	//部署操作
	Route::get('helper', 'SettingController@helper')->name('settings.helper');

	//推广平台
	Route::resource('sharePlatforms', 'SharePlatformController');

	//用户购买记录
	Route::resource('buyLogs', 'BuyLogController');	


});






// Route::resource('buyItems', 'BuyItemsController');

