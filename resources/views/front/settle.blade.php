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
<div class="ad pay_ad container-fluid">
	<img onerror="javascript:this.src='{{ asset('/images/pay_banner.jpg') }}';" src="{!! getSettingValueByKeyCache('settle_banner_img') !!}" class="img-responsive xs-hidden" alt="">
{{-- 	<div class="container logo">
		<div class="img"><img src="{!! getSettingValueByKeyCache('logo') !!}" class="img-responsive" alt=""></div>
	</div> --}}
	<div class="container content">
		<div class="row"> 
			<div class="head">武汉矿世大陆科技有限公司</div>
			<div class="txt">提供智能硬件的设计、开发、制造及OEM生产服务，提供轻钱包支持、POC矿池支持、存证算力合约平台支持、矿场托管等，实体矿机售卖</div>
		</div>
	</div>
</div>
<div class="form">
	<form action="">
		<div class="container">
	
			<div class="row">
				<div class="title">收货人姓名：</div>
				<input type="text" name="name" class="name col-xs-12 col-md-7" maxlength="12" placeholder="填写姓名">
			</div>
			<div class="row">
				<div class="title">收货人电话：</div>
				<input type="number" name="mobile" class="mobile col-xs-12 col-md-7" maxlength="11" placeholder="填写电话">
			</div>
			<div class="row">
				<div class="title">收货人地址：</div>
				<div class="col-xs-12 col-md-7">
					<div class="row">
						<div class="address col-xs-12 col-md-4">省：<input type="text"></div>
						<div class="address col-xs-12 col-md-4">市：<input type="text"></div>
						<div class="address col-xs-12 col-md-4">区：<input type="text"></div>
						<div class="address col-xs-12 detail_add">详细地址：<input type="text" name="address" ></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="title">确认订单信息：</div>
				<div class="col-xs-12 col-md-7">
					<div class="row head">
						<div class="address col-xs-3">商品</div>
						<div class="address col-xs-2  unit-price">单价</div>
						<div class="address col-xs-4  count">数量</div>
						<div class="address col-xs-3  total">小计</div>
					</div>

					@foreach($items as $item)
						<div class="row num">
							<div class="address  col-xs-3 products"><img onerror="javascript:this.src='{{ asset('/images/p1.jpg') }}';"  src="{!! $item->product_img !!}" alt="{!! $item->product_name !!}" class="img-responsive center-block" alt=""></div>
							<div class="address col-xs-2  unit-price">¥{!! $item->price !!}</div>
							<div class="address col-xs-4  count">
								<div class="counter">
								  <div class="fa fa-minus" style="float:left;" onclick="cartdel(this,{!! $item->id !!})"></div>
								  <input type="number" value="{!! $item->num !!}" class="shop_count" onkeyup="cartchange(this,{!! $item->id !!})" />
								  <div class="fa fa-plus" style="float:left;" onclick="cartadd(this,{!! $item->id !!})"></div>
								</div>
							</div>
							<div class="address col-xs-3  total">¥{!! $item->price*$item->num !!}</div>
						</div>
					@endforeach

					<div class="check_num row">
						<div class="col-xs-12">合计:<div class="check_now">¥{!! $price !!}</div></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="title">请选择支付方式：</div>
			</div>
			<div class="row pay_ways">
				<div class="col-xs-8 col-md-2">
					<div class="img active" data-type="支付宝">
						<img src="{{ asset('/images/alipay.jpg') }}" class="img-responsive center-block" alt="">
						<div class="select_pic"><img src="{{ asset('/images/55.png') }}" alt=""></div>
					</div>
				</div>
				<div class="col-xs-8 col-md-2">
					<div class="img" data-type="微信">
						<img src="{{ asset('/images/wechat_pay.jpg') }}" class="img-responsive center-block" alt="">
						<div class="select_pic"><img src="{{ asset('/images/55.png') }}" alt=""></div>
					</div>
				</div>
			</div>
			<div class="row">
				<input type="radio" id='agree'>
				<label for="agree">我已认真阅读并同意<a href="/protocol" target="_blank">&lt;&lt;服务协议&gt;&gt;</a></label>
			</div>
			<div class="row">
				<div class="total_price">实付款：   ¥{!! $price !!}</div>
			</div>
			<div class="row pay_btn">
				<div>立即付款</div>
			</div>
		</div>
	</form>
</div>
<div class="wechat_pay_code" style="display: none;">
	<div class="cover"></div>
	<div class="content">
		<div class="sacan_code"><img src="{{ asset('/images/code.jpg') }}" alt=""></div>
		<div class="info">请用微信扫描二维码付款</div>
		<div class="close">×</div>
	</div>
</div>
@include('front.footer')	
	
@endsection


@section('js')
	<script type="text/javascript" src="ap.js"></script>
	<script>
		$('.shop_count').numberInputLimit(3);
		$('.pay_ways .img').click(function(event) {
			/* Act on the event */
			$(this).addClass('active').parent().siblings().children('.img').removeClass('active');
		});
		$('.close').click(function(event) {
			if(confirm('确定取消微信支付?')){
				$.location('/',1200,function(obj){
					$.alert('请重新添加商品进行支付流程','error');
				});
			}
			/* Act on the event */
			//$('.wechat_pay_code').hide();
		});

		function cartdel(obj,item_id)
		{
			var num = parseInt($(obj).parent().find('input').val());
		
			num--;
			
			dealItemNumAndUpdatePrice(obj,item_id,num);
		}

		function cartadd(obj,item_id)
		{
			var num = parseInt($(obj).parent().find('input').val());
		
			num++;
			
			dealItemNumAndUpdatePrice(obj,item_id,num);
		}


		function cartchange(obj,item_id)
		{
			var num = parseInt($(obj).val());
	
			dealItemNumAndUpdatePrice(obj,item_id,num);
		}

		function dealItemNumAndUpdatePrice(obj,item_id,num)
		{
			if(num == 0)
			{
				$(obj).parent().parent().parent().remove();
			}
			$.zcjyRequest('/ajax/update_item_num',function(res){
				if(res){
					if(res.all_price == 0)
					{
						location.href = '/';
					}
					$(obj).parent().find('input').val(num);
					$(obj).parent().parent().parent().find('.total').text('¥'+res.item_price)
					$('.check_now').text('¥'+res.all_price);
					$('.total_price').text('实付款：   ¥'+res.all_price);
				}
			},{item_id:item_id,num:num},'POST');
		}

		//立即付款
		$('.pay_btn').click(function(){
			var radio = $('#agree').is(':checked');

			if(!radio)
			{
				layer.msg('请先确定同意协议', {icon: 5});
				return;
			}

			var pay_platform = $('.img.active').data('type');

			if($(window).width()<=479 && pay_platform == '微信')
			{
				    var ua = navigator.userAgent.toLowerCase();
			        var tip = document.querySelector(".weixin-tip");
			        var tipImg = document.querySelector(".J-weixin-tip-img");
			        if (ua.indexOf('micromessenger') != -1) 
			        {
			        	$.alert('请在微信外的浏览器打开进行支付或者切换支付宝进行支付','error');
			        	return;
			        }
			}

			$.zcjyRequest('/ajax/save',function(res){
				if(res)
				{
						//支付宝
						if(pay_platform == '支付宝')
						{
								if($(window).width()<=479)
								{
									  location.href = '/pay.htm?goto={!! Request::root() !!}/alipay/pay?param={!! zcjy_base64_en(Request::ip()) !!}&pay_platform=mobile';
									 return;
								}
							    location.href = res;
						}//微信
						else if(pay_platform == '微信')
						{	 	
								if($(window).width()<=479)
								{	
									location.href = '/wechat/pay_web?param={!! zcjy_base64_en(Request::ip()) !!}';
									return;
								}
							 	$.zcjyRequest('/wechat/pay',function(weixin_res){
							 			if(weixin_res)
							 			{
							 				$('.wechat_pay_code').find('img').attr('src',weixin_res);
							 				$('.wechat_pay_code').show();
							 				askTask(res);

							 			}
							 	},{param:res});
						}
				}
			},$('form').serialize()+'&pay_platform='+pay_platform+'&num=1','POST');
		
		});

		var task_time;
		var timeout = 0;
		function askTask(param)
		{
			task_time =setInterval(function(){
				timeout++;
				if(timeout >=30)
				{
					$.location('/',1200,function(obj){
							$.alert('超时未支付,支付失败!','error');
					});
				}
				$.zcjyRequest('/ajax/ask_log',function(res){
					if(res == '支付成功')
					{
						$.location('/',1200,function(obj){
							$.alert(res);
						});
					}
				},{param:param},'POST');
			},3000); 
		}
	</script>

@endsection
