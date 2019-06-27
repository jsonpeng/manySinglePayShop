<div class="service-hotline">
	<div class="container">
		<p>联系方式：<span>{!! getSettingValueByKeyCache('service_tel') !!}</span></p>
	</div>
</div>
<div class="header container hidden-xs">
	<div class="logo pull-left">
		<a href="/">
			<img src="{{asset('images/logo.png')}}" alt="">
		</a>
	</div>
	<div class="slogan pull-left hidden-sm">
		<img src="{{asset('images/slogan.png')}}" alt="">
	</div>
	<div class="header-right pull-right">
		<div class="g-search-box">
			<input type="text" style="height:34px; padding:6px 12px;border-radius: 4px;font-size:14px;" class="form-control" name="word" placeholder="请输入搜索内容">
			<i class="s-icon site_search_all"></i>
		</div>
		<?php $user = auth('web')->user();?>
		@if(!$user)
		<!-- 未登录 -->
		<div class="g-user-box">
			<a href="/user/login">登录</a>/<a href="/user/reg/mobile">注册</a>
		</div>
		@else
		<!-- 登录后 -->
		<div class="g-user-box" style="background-image: none; padding-left: 0;border:none;margin-left: 40px; ">
			<a href="/user/center/index">
				<img  onerror="javascript:this.src='{{asset('images/user-head.png')}}';" src="{!! $user->head_image !!}" alt="" width="40" height="40">
			</a>

			<span>{!! empty($user->nickname) ? $user->name : $user->nickname !!}</span>
			<a href="javascript:;" class="user_logout" style="color:#1976d3;">/退出</a>
		</div>
		@endif
	</div>
	<div class="clearfix"></div>
</div>

@if(!Request::is('user/login') && !Request::is('user/reg/mobile'))
<div class="g-nav hidden-xs">
	<ul class="nav nav-pills container">
	  	<li role="presentation" @if(Request::is('/')) class="active" @endif><a href="/">头条</a></li>
	  	<li role="presentation" @if(Request::is('cat/news')) class="active" @endif><a href="/cat/news">资讯</a></li>
	  	<li role="presentation" @if(Request::is('cat/quick-news')) class="active" @endif><a href="/cat/quick-news">快讯</a></li>
	  	<li role="presentation" @if(Request::is('cat/shengtai')) class="active" @endif><a href="/cat/shengtai">生态</a></li>
	  	<li class="contribute"><a href="/user/publish_post">投稿</a></li>
	</ul>
</div>
@endif

<nav class="navbar navbar-default visible-xs" style="margin-bottom: 0;">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	    	
	      	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </button>
	      	<a class="navbar-brand" href="/" style="padding:5px 15px;">
	      		<img src="{{asset('images/logo.png')}}" alt="" height="40">
	      	</a>
	      	<?php $user = auth('web')->user();?>
			@if(!$user)
			<div class="" style="padding: 0 7.5px;float: right;height: 50px;line-height: 50px;">
				<span class="g-user-box" style="margin-left: 0;border:none;padding: 8px 0 8px 22px;background-position: 0 8px;">
					<a href="/user/login">登录</a>/<a href="/user/reg/mobile">注册</a>
				</span>
			</div>
			@else
			<div class="g-user-box" style="background-image: none; padding-left: 0;border:none;float: right;">
				<a href="/user/center/index">
					<img  onerror="javascript:this.src='{{asset('images/user-head.png')}}';" src="{!! $user->head_image !!}" alt="" width="40" height="40">
				</a>
				<a href="javascript:;" style="text-align:center;color:#1976d3;">/退出</a>
			</div>
			@endif
	      	<div class="clearfix"></div>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    <ul class="nav navbar-nav">
		        <li class="active">
		        	<a href="/">头条</a>
		        </li>
		        <li>
		        	<a href="/cat/news">资讯</a>
		        <li>
		        <li>
		        	<a href="/cat/quick-news">快讯</a>
		        <li>
		        <li>
		        	<a href="/cat/shengtai">生态</a>
		        <li>
		    </ul>
	    </div>
	</div>
	    
</nav>

