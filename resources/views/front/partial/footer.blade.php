<footer>
	<div class="container">
		<div class="row cooperation">
			<div class="col-md-6">
				<div class="footer-hrader">内容合作</div>
				@if(count($hezuos_n))
					<ul class="row">

						@foreach($hezuos_n as $item)
						<li class="col-xs-4 col-md-3">
							<a href="{!! $item->link !!}">
								<img src="{{ $item->image }}" alt="">
							</a>
						</li>
						@endforeach
					
					</ul>
				@endif
			</div>
			<div class="col-md-6 cooperation-strategy">
				<div class="footer-hrader">战略合作</div>
					<div class="col-sm-9 col-xs-8">
						@if(count($hezuos_z))
							<ul class="row">
								@foreach($hezuos_z as $item)
								<li class="col-xs-6 col-md-4">
									<a href="{!! $item->link !!}">
										<img src="{{ $item->image }}" alt="">
									</a>
								</li>
								@endforeach
							</ul>
						@endif
					</div>
					<div class="erweima pull-right text-center col-sm-3 col-xs-4">
						<img src="{!! getSettingValueByKeyCache('weixin') !!}" onerror="javascript:this.src='{{asset('images/erweima.jpg')}}';" alt="" class="img-rounded img-responsive">
						<p>扫一扫二维码<br>添加微信公众号</p>
					</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="footer-down">
			<div class="copy pull-left">
				{!! getSettingValueByKeyCache('beian') !!}
			</div>
			<ul class="footer-nav pull-right">
				<li>
					<a href="/">头条</a>
				</li>
				<li>
					<a href="/cat/news">资讯</a>
				</li>
				<li>
					<a href="/cat/quick-news">快讯</a>
				</li>
				<li>
					<a href="/cat/shengtai">生态</a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>
</footer>
<div class="totop text-center">
	<span id="totop"></span>
</div>
