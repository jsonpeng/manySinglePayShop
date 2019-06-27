@extends('front.partial.base')

@section('css')
<style type="text/css">

</style>
@endsection

@section('seo')
	<title>{!! getSettingValueByKeyCache('name') !!}</title>
    <meta name="keywords" content="{!! getSettingValueByKeyCache('seo_keywords') !!}">
    <meta name="description" content="{!! getSettingValueByKeyCache('seo_des') !!}">
@endsection

@section('content')
<div class="ad container-fluid">
	<img onerror="javascript:this.src='{{ asset('/images/banner-1.jpg') }}';" src="{!! getSettingValueByKeyCache('index_banner_img') !!}" class="img-responsive" alt="">
	<div class="container content">
		<div class="row"> 
			<div class="head">武汉矿世大陆科技有限公司</div>
			<div class="txt">提供智能硬件的设计、开发、制造及OEM生产服务，提供轻钱包支持、POC矿池支持、存证算力合约平台支持、矿场托管等，实体矿机售卖</div>
		</div>
	</div>
</div>
<div class="product_intr container-fluid">
	<div class="row" style="background-color:#f5f5f5;">
		<div class="col-xs-12 col-md-6  r_side">
			<div class="img">
				<img onerror="javascript:this.src='{{ asset('/images/p1.jpg') }}';" src="{!! getSettingValueByKeyCache('product_img1') !!}" class="img-responsive center-block" alt="">
			</div>
		</div>
		<div class="col-xs-12 col-md-6  l_side">
				<div class="content">
					<div class="name">{!! getSettingValueByKeyCache('product_name') !!}</div>
					<div class="text"> {!! getSettingValueByKeyCache('product_des') !!}</div>
					<div class="price">¥{!! getSettingValueByKeyCache('product_price') !!}</div>
					<a class="btn_buy" href="javascript:;" onclick="addCheckbox(1)">立即购买</a>
				</div>
		</div>

	</div>
</div>
<div class="product_intr container-fluid">
	<div class="row">
		<div class="col-xs-12 col-md-6 col-md-push-6 r_side">
			<div class="img">
				<img onerror="javascript:this.src='{{ asset('/images/p1.jpg') }}';" src="{!! getSettingValueByKeyCache('product_img2') !!}" class="img-responsive center-block" alt="">
			</div>
		</div>
		<div class="col-xs-12 col-md-6 col-md-pull-6 l_side">
				<div class="content">
					<div class="name">{!! getSettingValueByKeyCache('product_des2') !!}</div>
				</div>
		</div>
	</div>
</div>
<div class="product_intr container-fluid">
	<div class="row" style="background-color:#f5f5f5;">
		<div class="col-xs-12 col-md-6  r_side">
			<div class="img">
				<img onerror="javascript:this.src='{{ asset('/images/p1.jpg') }}';" src="{!! getSettingValueByKeyCache('product_img3') !!}" class="img-responsive center-block" alt="">
			</div>
		</div>
		<div class="col-xs-12 col-md-6  l_side">
				<div class="content">
					<div class="name">{!! getSettingValueByKeyCache('product_des3') !!}</div>
 					{{-- <div class="text"> {!! getSettingValueByKeyCache('product_des2') !!}</div> --}}
				</div>
		</div>

	</div>
</div>

@include('front.footer')

<div class="wechat_pay_code cartbox" style="display: none;">
	<div class="cover"></div>
	<div class="content">
		<div class="tips"><div class="words">温馨提示</div><div class="shut_down">×</div></div>
		<div class="sacan_code"><img src="{{ asset('/images/ok.jpg') }}" alt=""></div>
		<div class="info">商品已加入购买清单</div>
		<div class="tab">
			<a class="tab_1" href="/settle">立即付款</a>
			<div class="tab_r">再逛逛</div>
		</div>
	</div>
</div>	
@endsection


@section('js')
{{-- 	<script>
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "https://hm.baidu.com/hm.js?1b371103a347834e20e00c88eb355f42";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
	</script> --}}
	<script>
		// 左右两侧高度一致
		$(document).ready(function() {
			var w=window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
				$(window).resize(function() {
					if(w<=991){
						return false
					}
					console.log(w);
				  	// video
				  	var v_height=$('.video_intr #video').height();
				  	$('.video_intr .r-content').height(v_height);
				  	console.log(v_height);
				  	console.log(w);
				  	// 产品介绍
				  	var t_height=$('.product_intr .r_side').height();
				  	var pro_side=$('.product_intr .l_side').height(t_height);
				  	// var padding_size=(t_height-pro_side)/2;
				  	// $('.product_intr .col-md-8').css('padding-top', padding_size);
				  	// 性能介绍
				  	var H1=$('.IPFS .l_side').height();
				  	var H2=$('.IPFS .col-md-4').height();
				  	var H3=(H1-H2)/2;
				  	$('.IPFS .col-md-4').css('padding-top', H3);
				});
		})
		$(document).ready(function() {
			var w=window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
					if(w<=991){
						return false
					}
					console.log(w);
				  	// video
				  	var v_height=$('.video_intr #video').height();
				  	$('.video_intr .r-content').height(v_height);
				  	console.log(v_height);
				  	console.log(w);
				  	// 产品介绍
				  	var t_height=$('.product_intr .r_side').height();
				  	var pro_side=$('.product_intr .l_side').height(t_height);
				  	// var padding_size=(t_height-pro_side)/2;
				  	// $('.product_intr .col-md-8').css('padding-top', padding_size);
				  	// 性能介绍
				  	var H1=$('.IPFS .l_side').height();
				  	var H2=$('.IPFS .col-md-4').height();
				  	var H3=(H1-H2)/2;
				  	$('.IPFS .col-md-4').css('padding-top', H3);
		})
	    function addCheckbox(type=1){
	    	play = true;
	    	event.preventDefault();
	    	type = parseInt(type);
	    	var request_data = {
	    		product_name:'{!! getSettingValueByKeyCache('product_name') !!}',
	    		num:1,
	    		price:'{!! getSettingValueByKeyCache('product_price') !!}',
	    		product_img:'{!! getSettingValueByKeyCache('product_img1') !!}'
	    	};
	     	if(type === 2)
	    	{
	    		request_data = {
	    			product_name:'{!! getSettingValueByKeyCache('product_name2') !!}',
		    		num:1,
		    		price:'{!! getSettingValueByKeyCache('product_price2') !!}',
		    		product_img:'{!! getSettingValueByKeyCache('product_img2') !!}'
	    		};
	    	}
	    	 $.zcjyRequest('/ajax/add_product',function(res){
	    	 	if(res){
	    	 			$('.wechat_pay_code').show();
	    	 	}
	    	 },request_data,'POST');
	    }
	    $('.tab_r,.shut_down').click(function(event) {
	    	/* Act on the event */
	    	$('.wechat_pay_code').hide();
	    });
	</script>
@endsection
