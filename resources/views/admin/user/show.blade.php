@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="padding: 30px 15px;">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="padding-top: 0;">
          <h1>
            用户信息
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" style="height: 100px;" src="{{ $user->head_image }}">

                  <h3 class="profile-username text-center">{{ $user->name }}</h3>


                  <p class="text-muted text-center">
                
                    
                </p>

                  <ul class="list-group list-group-unbordered">

            
                 
                  </ul>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">其他信息</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="list-group list-group-unbordered">

                        <li class="list-group-item">
                          <b>注册时间</b> <span class="pull-right">{{ $user->created_at->format('Y-m-d') }}</span>
                        </li>
                        <li class="list-group-item">
                          <b>电话</b> <span class="pull-right">{{ $user->mobile }}</span>
                        </li>
                        <li class="list-group-item">
                          <b>最后活跃时间</b> <span class="pull-right">{{ $user->last_login }}</span>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">

            {{--       <li ><a href="#order_list" data-toggle="tab">订单</a></li>
                  <li ><a href="#hourse_list" data-toggle="tab">小屋</a></li>
                  <li ><a href="#芸来软件_list" data-toggle="tab">芸来软件</a></li> --}}
                  <li class="active"><a href="#notice_list" data-toggle="tab">通知消息</a></li>
                  <li class=""><a href="#post_list" data-toggle="tab">发布的文章</a></li>
                  <li class=""><a href="#collect_list" data-toggle="tab">收藏的文章</a></li>

                </ul>
                <div class="tab-content">

                  <div class=" tab-pane" id="post_list">

                    

                    <table class="table table-responsive" id="posts-table">
                          <thead>
                              <tr>
                                  <th>名称</th>
                          {{--         <th>别名</th> --}}
                                  {{-- <th>类型</th> --}}
                                  <th>图像</th>
                                  <th>分类</th>
                                  <th>文章状态</th>
                                  <th>审核状态</th>
                                  {{-- <th>链接</th> --}}
                                  <th>浏览量</th>
                                {{--   <th>发布人</th>
                                  <th colspan="3">操作</th> --}}
                              </tr>
                          </thead>
                          <tbody>
                          @foreach($posts as $post)
                         
                              <tr>
                                  <td>{!! $post->name !!}</td>
                          {{--         <td>{!! $post->slug !!}</td> --}}
                                  {{-- <td>{!! $post->LeiXing !!}</td> --}}
                                  <td><img src="{{ asset($post->image) }}" style="height: 25px;"></td>
                                  <td>@foreach ($post->cats as $cat)
                                      &nbsp;{{$cat->name}}
                                  @endforeach</td>
                                  <td>{!! $post->publish !!}</td>
                                  <td>{!! $post->publish_status !!}</td>
                                  {{-- <td>{!! $baseurl !!}/post/{!! $post->id !!}</td> --}}
                                  <td>{!! $post->view !!}</td>
                                
                              </tr>
                          @endforeach
                          </tbody>
                      </table>

                  </div>

               
                       <div class=" tab-pane" id="collect_list">

                    

                    <table class="table table-responsive" id="posts-table">
                          <thead>
                              <tr>
                                  <th>名称</th>
                          {{--         <th>别名</th> --}}
                                  {{-- <th>类型</th> --}}
                                  <th>图像</th>
                                  <th>分类</th>
                                  <th>文章状态</th>
                                  <th>审核状态</th>
                                  {{-- <th>链接</th> --}}
                                  <th>浏览量</th>
                                {{--   <th>发布人</th>
                                  <th colspan="3">操作</th> --}}
                              </tr>
                          </thead>
                          <tbody>
                          @foreach($collects as $post)
                         
                              <tr>
                                  <td>{!! $post->name !!}</td>
                          {{--         <td>{!! $post->slug !!}</td> --}}
                                  {{-- <td>{!! $post->LeiXing !!}</td> --}}
                                  <td><img src="{{ asset($post->image) }}" style="height: 25px;"></td>
                                  <td>@foreach ($post->cats as $cat)
                                      &nbsp;{{$cat->name}}
                                  @endforeach</td>
                                  <td>{!! $post->publish !!}</td>
                                  <td>{!! $post->publish_status !!}</td>
                                  {{-- <td>{!! $baseurl !!}/post/{!! $post->id !!}</td> --}}
                                  <td>{!! $post->view !!}</td>
                                
                              </tr>
                          @endforeach
                          </tbody>
                      </table>

                  </div>


    

                      <div class="active tab-pane" id="notice_list">
                            <table class="table table-responsive table-bordered table-hover" id="芸来软件s-table">
                                        <thead>
                                            <tr  class="">
                                            <th>消息内容</th>
                                            {{-- <th>阅读状态</th> --}}
                                            <th>消息创建时间</th>
                                    
                                            </tr>
                                        </thead>
                                        <tbody>
                                                  @foreach($notices as $notice)
                                                    <tr> 
                                                      <td>{!! $notice->content!!}</td>
                                                      {{-- <td>@if($notice->read) <span class="btn btn-success">已读</span> @else   <span class="btn btn-danger">未读</span> @endif</td> --}}
                                                      <td>{!! $notice->created_at !!}</td>
                                                    </tr>
                                                  @endforeach
                                        </tbody>
                                    </table>

                                    <div class="text-center">
                                          {!! $notices->appends('')->links() !!}
                                    </div>

                      </div>
   
                  <!-- /.tab-pane -->

             
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

        </section>
    </div>
@endsection


@include('admin.user.js')
