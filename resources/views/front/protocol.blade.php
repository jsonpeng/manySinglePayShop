@extends('front.partial.base')

@section('css')
<style type="text/css">
	.xieyi{
		padding:50px 15px;
	}
	.head{
		text-align: center;
		font-size: 18px;
		font-weight: bold;
		margin-bottom: 15px;
	}
	.content{
		font-size:14px;
		color:#333;
		line-height: 1.7em;
	}
	.content div,.content p{
		text-align: justify; text-justify: inter-ideograph; text-indent: 2em;
		margin-bottom: 10px;
	}
</style>
@endsection

@section('seo')
	<title>{!! getSettingValueByKeyCache('name') !!}</title>
    <meta name="keywords" content="{!! getSettingValueByKeyCache('seo_keywords') !!}">
    <meta name="description" content="{!! getSettingValueByKeyCache('seo_des') !!}">
@endsection

@section('content')
	<div class="xieyi container">
		<div class="head">服务协议</div>
		<div class="content">
			{!! getSettingValueByKeyCache('protocol') !!}
		</div>
	</div>
@endsection


@section('js')

@endsection
