<li class="">
    <a href="/" target="_blank"><i class="fa fa-home"></i><span>网站首页</span></a>
</li>

{{-- <li class="header">说明文档</li>
 <li class="{{ Request::is('zcjy/doc')  ? 'active' : '' }}">
      <a href="/zcjy/doc"><i class="fa fa-cog"></i><span>系统说明文档</span></a>
</li> --}}

<li class="header">网站设置</li>
    <li class="{{ Request::is('zcjy/settings/setting*') || Request::is('zcjy') ? 'active' : '' }}">
      <a href="{!! route('settings.setting') !!}"><i class="fa fa-cog"></i><span>系统设置</span></a>
    </li>
 {{--     <li class="{{ Request::is('zcjy/banners*') || Request::is('zcjy/*/bannerItems*') ? 'active' : '' }}">
      <a href="{!! route('banners.index') !!}"><i class="fa fa-edit"></i><span>横幅管理</span></a>
    </li> --}}


<li class="{{ Request::is('zcjy/sharePlatforms*') ? 'active' : '' }}">
    <a href="{!! route('sharePlatforms.index') !!}"><i class="fa fa-edit"></i><span>推广平台</span></a>
</li>

<li class="{{ Request::is('zcjy/buyLogs*') ? 'active' : '' }}">
    <a href="{!! route('buyLogs.index') !!}"><i class="fa fa-edit"></i><span>用户购买记录</span></a>
</li>

<li class="">
    <a href="javascript:;" id="refresh"><i class="fa fa-refresh"></i><span>刷新缓存</span></a>
</li>










