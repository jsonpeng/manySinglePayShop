<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>芸来软件</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/select2/4.0.3/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css">
    <link rel="stylesheet" href="{{ asset('vendor/adminLTE/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminLTE/css/skins/skin-blue.min.css') }}">

    
    <link rel="stylesheet" href="https://cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://cdn.bootcss.com/element-ui/1.4.3/theme-default/index.css" rel="stylesheet">
    

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style type="text/css">
    .skin-blue .main-header .logo,.skin-blue .main-header .navbar , .btn-primary , .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover , .skin-blue .main-header .logo , .skin-blue .main-header .navbar .sidebar-toggle:hover{
        background-color: #019875 !important;
        border-color: white;
    }

    .skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side {
        background-color: #fff;
    }

    .skin-blue .sidebar-menu>li.header {
        color: #4b646f;
        background: #fff;
    }

    .skin-blue .sidebar a {
        color: black;
    }

    .skin-blue .sidebar-menu>li>.treeview-menu {
        margin: 0 1px;
        background: black;
    }

    .box.box-info,.nav-tabs-custom>.nav-tabs>li.active{
        border-top-color: green;
    }
    </style>
    @yield('css')
</head>

<body class="skin-blue sidebar-mini">
    <style type="text/css">
        .content-header{overflow: hidden;}
        .box.box-primary{border-top: none;}
        thead {
            border-bottom: 1px solid #d0d0d0;
        }
        .mce-i-browse:before {
            content: "\e014";
        }
    </style>

  @if (auth('admin')->check())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <b>芸来软件后台管理系统</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation" style="position: relative;">
                
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ asset('logo/logo.png') }}"
                                     class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! auth('admin')->user()->name !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{!! route('settings.edit_pwd') !!}" class="btn btn-default btn-flat">
                                            修改密码
                                        </a>

                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/zcjy/logout') !!}" class="btn btn-default btn-flat">
                                            退出
                                        </a>
                                   {{--      <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form> --}}
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright 2018 <a href="/" target="_blank">芸来软件</a>.</strong> All rights reserved.
        </footer>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                    InfyOm Generator
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Login</a></li>
                    <li><a href="{!! url('/register') !!}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/adminLTE/js/app.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/tinymce/jquery.tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/vue/vue.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jquery.nestable.js') }}"></script>
    <script src="https://cdn.bootcss.com/element-ui/1.4.3/index.js"></script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/zcjy.js') }}"></script>
    <script src="{{ asset('vendor/layer/layer.js') }}"></script>

    @yield('scripts')
    <script type="text/javascript">
    $('#add_post').click(function(){
       $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
      $.ajax({
                url: '/zcjy/getCustomType',
                type: 'POST',
                success: function(data) {

                 var status=data.status;
                 var alltype=data.msg;
                 var html='';

                 if(status){
                for(var i=0;i<alltype.length;i++){
                    html +='<a class="btn btn-success" style="margin-left:10px;" href="/zcjy/posts/create?post_type='+alltype[i].slug+'">'+alltype[i].name+'</a>';
                }
                console.log(html);

               layer.open({
                      type: 1,
                      area: ['680px', '450px'], 
                      content: '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h4 class="modal-title">请选择一种类型进行添加</h4></div><div class="modal-body"><a href="/zcjy/posts/create" class="btn btn-default">文章</a>'+html+'</div>'
                    });

            }else{
                alert('未知错误');
            }

            }
        });

    });

    var i=0;
    var slug_arr=[];
    $('.select_cat').click(function(){
        var slug=$(this).data('slug');
        var val=$(this).val();
        console.log("val:"+val);
        var that=this;
        if($(this).is(':checked')){
              i++;
              $.ajax({
                    url:'/getRootSlug/'+val,
                    type:'GET',
                    success:function(data){
                        if(data.status){
                            slug=data.msg;
                             $('#'+slug).show(500);
                          slug_arr.push(slug);
                            console.log(i);
                            if(i>1){
                            $('#post').val(slug_arr);
                          }else{
                              $('#post').val(slug_arr[0]);
                          }
                        }else{
                            return false;
                        }
                    }
              });       
        }else{
              i--;
                $.ajax({
                    url:'/getRootSlug/'+val,
                    type:'GET',
                    success:function(data){
                        if(data.status){
                            slug=data.msg;
                            console.log("还选中的分类别名"+$('.select_cat:checked').data('slug'));
                            if($('.select_cat').is(':checked') && $('.select_cat:checked').data('slug')==slug){
                                return false;
                            }
                            $('#'+slug).hide(500);
                          removeByValue(slug_arr,slug)
                          if(i>1){
                            $('#post').val(slug_arr);
                          }else{
                              $('#post').val(slug_arr[0]);
                          }
                           if(!$('.select_cat').is(':checked')){
                                $('#post').val("post");
                           }
                        }else{
                            return false;
                        }
                    }
              });            
        }
    });

    $('#custom_checkbox').click(function(){

    });

    function removeByValue(arr, val) {
      for(var i=0; i<arr.length; i++) {
        if(arr[i] == val) {
          arr.splice(i, 1);
          break;
        }
      }
    }

    $('#items_select').change(function(){
            var val=$(this).val();
            console.log(val);
            if(val=="select" || val=="checkbox"){
                $('#items_value').show();
            }else{
                $('#items_value').hide();
            }
    });

    //表格隐藏与显示
    $('.fa').click(function(){
       var type=$(this).data('type');
        var status= $(this).parent().parent().parent().children('.box-body').data('status');
        var functions =$(this).data('function');
        if(functions =='switch-table'){
            console.log($(this).parent().parent().parent().children('.box-body'));
       if(status=="show"){
            $(this).parent().parent().parent().children('.box-body').hide();
            $(this).parent().parent().parent().children('.box-body').data('status','hide');
       }else{
        $(this).parent().parent().parent().children('.box-body').show();
        $(this).parent().parent().parent().children('.box-body').data('status','show');
       }
   }else{
    return false;
   }
    });

    $('#refresh').click(function(){
            $.ajax({
                url:'/clearCache',
                type:'post',
                success:function(data){
                    if(data.status){
                layer.msg('清空缓存成功', {icon: 1});
                    }else{
                layer.open({
                    content: '未知错误!'
                    ,skin: 'msg'
                    ,time: 2 
                  });
                        return false;
                    }
                }
            })
    });
    
    </script>
</body>
</html>


