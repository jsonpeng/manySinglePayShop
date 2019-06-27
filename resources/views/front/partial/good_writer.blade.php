	<?php $good_writers_group1 = app('common')->goodWriters(0,9);?>
				@if(count($good_writers_group1))
					<?php 
						$good_writers_group2 = app('common')->goodWriters(9,18);
						$good_writers_group3 = app('common')->goodWriters(18,27);
					?>
					<div class="good-writes hidden-xs">
						<h3 class="title">
							优秀作家
							<a href="/good_writer">更多</a>
						</h3>
						<div id="writer-box" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								@if(count($good_writers_group1))
							    	<li data-target="#writer-box" data-slide-to="0" class="active"></li>
							    @endif
							    @if(count($good_writers_group2))
							    	<li data-target="#writer-box" data-slide-to="1"></li>
							    @endif
							    @if(count($good_writers_group3))
							    	<li data-target="#writer-box" data-slide-to="2"></li>
							    @endif
							</ol>
							<div class="carousel-inner" role="listbox">

								@if(count($good_writers_group1))
								    <div class="item active">
								    	@foreach($good_writers_group1 as $item)
											<div class="col-md-4 col-sm-4 text-center">
												<img src="{!! $item->head_image !!}" onerror="javascript:this.src='{{asset('images/write1.jpg')}}';"  alt="" class="img-circle" width="68" hieght="68">
												<p>{!! $item->ShowName !!}</p>
											</div>
										@endforeach
										<div class="clearfix"></div>
									</div>
								@endif

								@if(count($good_writers_group2))
								    <div class="item active">
								    	@foreach($good_writers_group2 as $item)
											<div class="col-md-4 col-sm-4 text-center">
												<img src="{!! $item->head_image !!}" onerror="javascript:this.src='{{asset('images/write1.jpg')}}';"  alt="" class="img-circle" width="68" hieght="68">
												<p>{!! $item->ShowName !!}</p>
											</div>
										@endforeach
										<div class="clearfix"></div>
									</div>
								@endif

								@if(count($good_writers_group3))
								    <div class="item active">
								    	@foreach($good_writers_group3 as $item)
											<div class="col-md-4 col-sm-4 text-center">
												<img src="{!! $item->head_image !!}" onerror="javascript:this.src='{{asset('images/write1.jpg')}}';"  alt="" class="img-circle" width="68" hieght="68">
												<p>{!! $item->ShowName !!}</p>
											</div>
										@endforeach
										<div class="clearfix"></div>
									</div>
								@endif

							</div>
						</div>
					</div>
				@endif