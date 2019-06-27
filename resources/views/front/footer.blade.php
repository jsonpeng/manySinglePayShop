<div class="footer container-fluid">
	<div class="container content">
		<div class="row"> 
			<div class="col-xs-12 col-md-2 l_side">
				<div class="qr_code"><img onerror="javascript:this.src='{{ asset('/images/code.jpg') }}';" src="{!! getSettingValueByKeyCache('gongzhong_erweima') !!}" class="img-responsive center-block" alt=""></div>
				<div style="text-align: center;">扫一扫<br>添加微信公众账号</div>
			</div>
			<div class="col-xs-12 col-md-2 l_side">
				<div class="qr_code"><img onerror="javascript:this.src='{{ asset('/images/code.jpg') }}';" src="{!! getSettingValueByKeyCache('kefu_erweima') !!}" class="img-responsive center-block" alt=""></div>
				<div style="text-align: center;">扫一扫<br>添加微信客服</div>
			</div>
			<div class="col-xs-12 col-md-8 rigth-side">
				<div>{!! getSettingValueByKeyCache('footer_des') !!}</div>
			</div>
		</div>
	</div>
</div>

<div class="right container-fluid">
	<div>{!! getSettingValueByKeyCache('beian') !!}</div>
</div>	