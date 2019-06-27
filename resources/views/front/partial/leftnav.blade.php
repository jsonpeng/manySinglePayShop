<?php 
    $now = '';
    if(Request::is('message_board')){
        $now = '留言板';
    }
    elseif(Request::is('cat/2') || Request::is('cat/3') || Request::is('cat/4') || Request::is('cat/5')){
        $now = '公司概况';
    }
    elseif (Request::is('cat/7') || Request::is('cat/8')) {
        $now = '新闻资讯';
    }
    elseif (Request::is('cat/9')) {
        $now = '精品案例';
    }
    elseif (Request::is('cat/11')) {
        $now = '政策标准';
    }
    elseif (Request::is('cat/10')) {
        $now = '影像长廊';
    }
    elseif (Request::is('cat/12')) {
        $now = '下载中心';
    }
    elseif (Request::is('cat/3') || Request::is('page/1')) {
        $now = '联系我们';
    }
    elseif(Request::is('post/*')){
        $now = $post->name;
    }
    elseif(Request::is('cat*')){
        $now = $category->name;
    }
    elseif(Request::is('page*')){
        $now = $page->name;
    }
    elseif(Request::is('search*')){
        $now = '裕博搜索';
    }
?>

<div class="leftnav">
    @if($now)
    	<div class="brand text-center">
            <h1>{!! word_en($now) !!}</h1>
            <p>{!! $now !!}</p>
        </div>
        <?php 
            $child_menus = varifyMenusName($now,$menus);
        ?>
    @endif

    @if(isset($child_menus) && count($child_menus))
        <ol>
            @foreach ($child_menus as $menu)
               @if(isset($menu['link']) && isset($menu['name']))
        	       <li><a class="link @if(Request::url() == $menu['link']) active @endif" href="{!! $menu['link'] !!}" style="display:block;"><span>●</span>{!! $menu['name'] !!}<i></i></a></li>
               @endif
            @endforeach
        </ol>
    @endif

    <div class="hidden-xs">
        <div class="search">
            <form class="search-form" action="/search">
                <p>关键词搜索</p>
                <input type="text" name="word" ><p class="btn search-action" onclick="javascript:$('.search-form').submit();">搜索</p>
            </form>
        </div>
        <div class="hot-line">
        	<h3>咨询热线</h3>
        	<ul>
        		<li><a href="">{!! getSettingValueByKeyCache('service_tel') !!}</a></li>
        		<li><a href="">{!! getSettingValueByKeyCache('tel') !!}</a></li>
        	</ul>
        </div>
        <div class="tencent-service">
        	<h3>腾讯客服：</h3>
        	<ul>
        		<li>咨询在线客服1:<a href="tencent://message/?Menu=yes&uin=<?php echo getSettingValueByKeyCache('qq1'); ?>&Site=80fans&Service=300&sigT=45a1e5847943b64c6ff3990f8a9e644d2b31356cb0b4ac6b24663a3c8dd0f8aa12a545b1714f9d45"><img src="{{asset('images/qq-chat.png')}}" alt=""></a></li>
        		<li>咨询在线客服2:<a href="tencent://message/?Menu=yes&uin=<?php echo getSettingValueByKeyCache('qq2'); ?>&Site=80fans&Service=300&sigT=45a1e5847943b64c6ff3990f8a9e644d2b31356cb0b4ac6b24663a3c8dd0f8aa12a545b1714f9d45"><img src="{{asset('images/qq-chat.png')}}" alt=""></a></li>
        		<li>咨询在线客服3:<a href="tencent://message/?Menu=yes&uin=<?php echo getSettingValueByKeyCache('qq3'); ?>&Site=80fans&Service=300&sigT=45a1e5847943b64c6ff3990f8a9e644d2b31356cb0b4ac6b24663a3c8dd0f8aa12a545b1714f9d45"><img src="{{asset('images/qq-chat.png')}}" alt=""></a></li>
        	</ul>
        </div>
        <div class="head-address">
        	<h3>总部地址：</h3>
        	<p>{!! getSettingValueByKeyCache('address') !!}</p>
        </div>
    </div>
</div>