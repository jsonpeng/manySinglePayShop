<ol class="nav-path">
  	<li><a href="/">首页</a></li>
  	{{-- 单页 --}}
  	@if(Request::is('page*'))
  		<li><a href="/page/{!! $page->id !!}"> > {!! $page->name !!}</a></li>
  	{{-- 分类 --}}
  	@elseif(Request::is('cat*'))
  		<?php $parent_cat = parent_cat($category);?>
  		{{-- 如果有父分类 --}}
  		@if($parent_cat)
  		<li><a href="/cat/{!! $parent_cat->id !!}"> > {!! $parent_cat->name !!}</a></li>
  		@endif
  		<li><a href="/cat/{!! $category->id !!}"> > {!! $category->name !!}</a></li>
  	{{-- 故事 --}}
		@elseif(Request::is('post*'))
			<?php $post_cat = $post->cats()->first();?>
			@if($post_cat)
				<?php $parent_post_cat = parent_cat($post_cat);?>
					@if($parent_post_cat)
						<li><a href="/cat/{!! $parent_post_cat->id !!}"> > {!! $parent_post_cat->name !!}</a></li>
					@endif
				<li><a href="/cat/{!! $post_cat->id !!}"> > {!! $post_cat->name !!}</a></li>
			@endif
  		<li><a href="/post/{!! $post->id !!}"> > {!! $post->name !!}</a></li>
	@endif
</ol>