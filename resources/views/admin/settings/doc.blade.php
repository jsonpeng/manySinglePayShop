@extends('layouts.app')


@section('content')
<section class="content pdall0-xs pt10-xs">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li>
                <a href="javascript:;">
                    <span style="font-weight: bold;">系统使用说明文档</span>
                </a>
            </li>
          {{--   <li class="active">
                <a href="#tab_1" data-toggle="tab">网站设置</a>
            </li> --}}
            
        {{--     <li>
                <a href="#tab_2" data-toggle="tab">小屋设置</a>
            </li> --}}

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        

                    <iframe src="https://view.officeapps.live.com/op/view.aspx?src={!! asset('/doc/资讯网站操作说明文档.docx') !!}" id="zcjy_doc_iframe" style="width: 100%;min-height: 1000px;"></iframe>


                        
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {{-- <button type="submit" class="btn btn-primary pull-left" onclick="saveForm(1)">保存</button> --}}
                    </div>
                    <!-- /.box-footer --> </div>
            </div>

            <!-- /.tab-pane -->

   

        </div>
        <!-- /.tab-content --> </div>
</section>
@endsection



@section('scripts')
<script>
 
    </script>
@endsection