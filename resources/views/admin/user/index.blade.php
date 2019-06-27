@extends('layouts.app')

@section('css')
<style type="text/css">
.message {
      border: none;
      display: inline-block;
      background: #ddd;
      margin-left: 15px;
}

button[disabled] {
    color: #fff;
  
}

.message-active {
    background: #FF5511;
    border: none;
    display: inline-block;
    margin-left: 15px;
    color:#fff;
}
</style>
@endsection

@section('content')
    <div class="container-fluid" style="">
        <div class="row">

 <!--            <div class="col-sm-3 col-lg-2">
                <ul class="nav nav-pills nav-stacked nav-email">
                    <li class="{{ Request::is('zcjy/users*') ? 'active' : '' }}">
                        <a href="{!! route('users.index') !!}">
                            <span class="badge pull-right"></span>
                            <i class="fa fa-user"></i> 会员列表
                        </a>
                    </li>
        
                </ul>
            </div> -->

            <div class="col-sm-9 col-lg-10">
                <section class="content-header ">
                    <h1 class="pull-left ">用户列表</h1>
                    <a class="group-notices" style="margin-left:15px;margin-top: 15px;font-size: 16px;"><i class="fa fa-commenting"></i>群发消息</a>
                </section>
                <div class="content pdall0-xs">
                    <div class="clearfix"></div>
                    <div class="box box-default box-solid mb10-xs {!! !$tools?'collapsed-box':'' !!} " style="margin-top: 15px;">
                        <div class="box-header with-border">
                            <h3 class="box-title">查询</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"> <i class="fa fa-{!! !$tools?'plus':'minus' !!}"></i>
                                </button>
                            </div>
                            <!-- /.box-tools --> </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form id="order_search">

                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label for="name">会员姓名</label>
                                    <input type="text" class="form-control" name="name" placeholder="会员姓名" @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif></div>


                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <label for="mobile">手机号</label>
                                    <input type="text" class="form-control" name="mobile" placeholder="手机号" @if (array_key_exists('mobile', $input))value="{{$input['mobile']}}"@endif></div>


                                <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                                    <label for="order_delivery">每页显示</label>
                                    <select class="form-control" name="page_list">
                                        <option value="" @if (!array_key_exists('page_list', $input)) selected="selected" @endif>全部</option>
                                        <option value="5" @if (array_key_exists('page_list', $input) && $input['page_list']=='5') selected="selected" @endif>5</option >
                                        <option value="15" @if (array_key_exists('page_list', $input) && $input['page_list']=='15') selected="selected" @endif>15</option >
                                      <option value="25" @if (array_key_exists('page_list', $input) && $input['page_list']=='25') selected="selected" @endif>25</option >
                                    </select>
                                </div>

                                <div class="form-group col-lg-1 col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                                    <button type="submit" class="btn btn-primary pull-right " onclick="search()">查询</button>
                                </div>
                                <div class="form-group col-xs-6 visible-xs visible-sm" >
                                    <button type="submit" class="btn btn-primary pull-left " onclick="search()">查询</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body --> </div>
                    <!-- /.box -->
                   
                 @include('flash::message')
                    <div class="clearfix"></div>
                    <div class="box box-primary">
                        <div class="box-body">@include('admin.user.table')</div>
                    </div>

                    <div class="text-center">
                        {!! $users->appends($input)->links() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@include('admin.user.js')
