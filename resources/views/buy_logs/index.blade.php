@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">用户购买记录</h1>
     {{--    <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('buyLogs.create') !!}">Add New</a>
        </h1> --}}
    </section>
    <div class="content">
        <div class="clearfix"></div>
              <?php $tools = 1;?>
     
              <div class="clearfix"></div>
        <div class="box box-default box-solid mb10-xs @if(!$tools) collapsed-box @endif">
            <div class="box-header with-border">
              <h3 class="box-title">查询</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-{!! !$tools?'plus':'minus' !!}"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="order_search">

                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="product_id_sort">支付状态</label>
                        <select class="form-control" name="pay_status">
                            <option value="" @if (!array_key_exists('pay_status', $input)) selected="selected" @endif>全部</option>
                            <option value="已支付" @if (array_key_exists('pay_status', $input) && $input['pay_status'] == '已支付') selected="selected" @endif>已支付</option>
                             <option value="未支付" @if (array_key_exists('pay_status', $input) && $input['pay_status'] == '未支付') selected="selected" @endif>未支付</option>
                        </select>
                    </div> 
                    
                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <label for="order_delivery">收货人姓名</label>
                       <input type="text" class="form-control" name="name" placeholder="收货人姓名" @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif>
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <label for="order_delivery">收货人地址</label>
                       <input type="text" class="form-control" name="address" placeholder="收货人地址" @if (array_key_exists('address', $input))value="{{$input['address']}}"@endif>
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="product_id_sort">支付平台</label>
                        <select class="form-control" name="pay_platform">
                            <option value="" @if (!array_key_exists('pay_platform', $input)) selected="selected" @endif>全部</option>
                            <option value="支付宝" @if (array_key_exists('pay_platform', $input) && $input['pay_platform'] == '支付宝') selected="selected" @endif>支付宝</option>
                             <option value="微信" @if (array_key_exists('pay_platform', $input) && $input['pay_platform'] == '微信') selected="selected" @endif>微信</option>
                        </select>
                    </div> 

      
                    <div class="form-group col-lg-1 col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                        <button type="submit" class="btn btn-primary pull-right " onclick="search()">查询</button>
                    </div>
                    <div class="form-group col-xs-6 visible-xs visible-sm" >
                        <button type="submit" class="btn btn-primary pull-left " onclick="search()">查询</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('buy_logs.table')
            </div>
        </div>
        <div class="text-center">
            {!! $buyLogs->links() !!}
        </div>
    </div>
@endsection

