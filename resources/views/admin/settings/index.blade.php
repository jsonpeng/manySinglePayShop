@extends('layouts.app')


@section('content')
<section class="content pdall0-xs pt10-xs">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li>
                <a href="javascript:;">
                    <span style="font-weight: bold;">通用设置</span>
                </a>
            </li>
            <li class="active">
                <a href="#tab_1" data-toggle="tab">网站设置</a>
            </li>
            
            <li>
                <a href="#tab_2" data-toggle="tab">产品设置</a>
            </li>

            <li>
                <a href="#tab_3" data-toggle="tab">其他图片文案设置</a>
            </li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" id="form1">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">网站名称</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" maxlength="60" placeholder="网站名称" value="{{ getSettingValueByKey('name') }}"></div>
                            </div>

               {{--              <div class="form-group">
                                <label for="logo" class="col-sm-3 control-label">网站LOGO</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image1" name="logo" placeholder="网站LOGO" value="{{ getSettingValueByKey('logo') }}">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image1')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('logo')) {{ getSettingValueByKey('logo') }} @endif" style="max-width: 100%; max-height: 150px; display: block;"></div>
                                    <p class="help-block">默认网站首页LOGO,通用头部显示，最佳显示尺寸为240*60像素</p>
                                </div>
                            </div> --}}
                            <!--
                            <div class="form-group">
                                <label for="seo_title" class="col-sm-3 control-label">网站标题</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="seo_title" maxlength="60" placeholder="网站标题" value="{{ getSettingValueByKey('seo_title') }}"></div>
                            </div>-->
                            <div class="form-group">
                                <label for="seo_des" class="col-sm-3 control-label">网站描述</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="seo_des" maxlength="60" placeholder="网站描述" value="{{ getSettingValueByKey('seo_des') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="seo_keywords" class="col-sm-3 control-label">网站关键字</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="seo_keywords" maxlength="60" placeholder="网站关键字" value="{{ getSettingValueByKey('seo_keywords') }}"></div>
                            </div>

                        

                         
                            <div class="form-group">
                                <label for="inform_content" class="col-sm-3 control-label">购买成功短信模板</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control"  name="inform_content" rows="3" placeholder="购买成功短信模板">{{ getSettingValueByKey('inform_content') }}</textarea>
                                    </div>
                            </div>
                           
                            <div class="form-group">
                                <label for="protocol" class="col-sm-3 control-label">服务协议</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control intro"  name="protocol" rows="3" placeholder="服务协议">{{ getSettingValueByKey('protocol') }}</textarea>
                                    </div>
                            </div>

                   {{--          <div class="form-group">
                                <label for="address" class="col-sm-3 control-label">地址</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  name="address" placeholder="地址" value="{{ getSettingValueByKey('address') }}">
                                    <div class="input-append">
                                        <a  class="btn"  onclick="openMap('address')">在地图中设定</a>
                                    </div>
                                </div>
                            </div> --}}

                        </form>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-left" onclick="saveForm(1)">保存</button>
                    </div>
                    <!-- /.box-footer --> </div>
            </div>

            <!-- /.tab-pane -->

            <div class="tab-pane" id="tab_2">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" id="form2">
                   

                             <div class="form-group">
                                <label for="product_name" class="col-sm-3 control-label">产品名称</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="product_name" maxlength="60" placeholder="产品名称" value="{{ getSettingValueByKey('product_name') }}"></div>
                            </div>

                             <div class="form-group">
                                <label for="product_price" class="col-sm-3 control-label">产品1价格(不填默认0.1)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="product_price" maxlength="60" placeholder="产品价格(不填默认0.1)" value="{{ getSettingValueByKey('product_price') }}"></div>
                            </div>

                            <div class="form-group">
                                <label for="product_des" class="col-sm-3 control-label">产品介绍1</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control"  name="product_des" rows="6" placeholder="产品介绍1">{{ getSettingValueByKey('product_des') }}</textarea>
                                    </div>
                            </div>

                             <div class="form-group">
                                <label for="product_img1" class="col-sm-3 control-label">产品图1(建议上传图大小:960*550)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image55" name="product_img1" placeholder="产品图1" value="{{ getSettingValueByKey('product_img1') }}">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image55')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('product_img1')) {{ getSettingValueByKey('product_img1') }} @endif" style="max-width: 100%; max-height: 150px; display: block;"></div>
                                </div>
                            </div>

                        {{--      <div class="form-group">
                                <label for="product_name2" class="col-sm-3 control-label">产品2名称</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="product_name2" maxlength="60" placeholder="产品名称" value="{{ getSettingValueByKey('product_name2') }}"></div>
                            </div> --}}

                         {{--     <div class="form-group">
                                <label for="product_price2" class="col-sm-3 control-label">产品2价格(不填默认0.1)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="product_price2" maxlength="60" placeholder="产品价格(不填默认0.1)" value="{{ getSettingValueByKey('product_price2') }}"></div>
                            </div> --}}

                            <div class="form-group">
                                <label for="product_des2" class="col-sm-3 control-label">产品介绍2</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control"  name="product_des2" rows="6" placeholder="产品介绍2">{{ getSettingValueByKey('product_des2') }}</textarea>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label for="product_img2" class="col-sm-3 control-label">产品图2(建议上传图大小:960*550)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image56" name="product_img2" placeholder="产品图2" value="{{ getSettingValueByKey('product_img2') }}">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image56')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('product_img2')) {{ getSettingValueByKey('product_img2') }} @endif" style="max-width: 100%; max-height: 150px; display: block;"></div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="product_des3" class="col-sm-3 control-label">产品介绍3</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control"  name="product_des3" rows="6" placeholder="产品介绍3">{{ getSettingValueByKey('product_des3') }}</textarea>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label for="product_img3" class="col-sm-3 control-label">产品图3(建议上传图大小:960*550)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image566" name="product_img3" placeholder="产品图3" value="{{ getSettingValueByKey('product_img3') }}">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image566')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('product_img3')) {{ getSettingValueByKey('product_img3') }} @endif" style="max-width: 100%; max-height: 150px; display: block;"></div>
                                </div>
                            </div>

            
                        </form>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-left" onclick="saveForm(2)">保存</button>
                    </div>
                </div>
            </div>

               <div class="tab-pane" id="tab_3">
                <div class="box box-info form">
                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" id="form3">
                
                            <div class="form-group">
                                <label for="index_banner_img" class="col-sm-3 control-label">首页横幅底图(建议上传图大小:1920*650)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image75" name="index_banner_img" placeholder="首页横幅底图" value="{{ getSettingValueByKey('index_banner_img') }}">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image75')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('index_banner_img')) {{ getSettingValueByKey('index_banner_img') }} @endif" style="max-width: 100%; max-height: 150px; display: block;"></div>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="settle_banner_img" class="col-sm-3 control-label">结算页横幅底图(建议上传图大小:1920*550)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image855" name="settle_banner_img" placeholder="结算页横幅底图" value="{{ getSettingValueByKey('settle_banner_img') }}">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image855')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('settle_banner_img')) {{ getSettingValueByKey('settle_banner_img') }} @endif" style="max-width: 100%; max-height: 150px; display: block;"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="gongzhong_erweima" class="col-sm-3 control-label">公众号二维码</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image856" name="gongzhong_erweima" placeholder="公众号二维码" value="{{ getSettingValueByKey('gongzhong_erweima') }}">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image856')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('gongzhong_erweima')) {{ getSettingValueByKey('gongzhong_erweima') }} @endif" style="max-width: 100%; max-height: 150px; display: block;"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="kefu_erweima" class="col-sm-3 control-label">客服二维码</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="image857" name="kefu_erweima" placeholder="客服二维码" value="{{ getSettingValueByKey('kefu_erweima') }}">
                                    <div class="input-append">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image857')">选择图片</a>
                                        <img src="@if(getSettingValueByKey('kefu_erweima')) {{ getSettingValueByKey('kefu_erweima') }} @endif" style="max-width: 100%; max-height: 150px; display: block;"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="footer_des" class="col-sm-3 control-label">网站底部公司描述信息</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control"  name="footer_des" rows="3" placeholder="网站底部公司描述信息">{{ getSettingValueByKey('footer_des') }}</textarea>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label for="beian" class="col-sm-3 control-label">网站底部备案信息</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control"  name="beian" rows="3" placeholder="网站底部备案信息">{{ getSettingValueByKey('beian') }}</textarea>
                                    </div>
                            </div>

                   

                        </form>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-left" onclick="saveForm(3)">保存</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.tab-content --> </div>
</section>
@endsection

@include('admin.partial.imagemodel')

@section('scripts')


<script>
        function saveForm(index){
            tinyMCE.triggerSave();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/settings/setting",
                type:"POST",
                data:$("#form"+index).serialize(),
                success: function(data) {
                  if (data.code == 0) {
                    layer.msg(data.message, {icon: 1});
                  }else{
                    layer.msg(data.message, {icon: 5});
                  }
                },
                error: function(data) {
                  //提示失败消息

                },
            });  
        }

       function openMap(type=''){
            var name =type==''?'detail':'address';
            var address=$('input[name='+name+']').val();
            var url="/zcjy/settings/map?address="+address;
                if($(window).width()<479){
                        layer.open({
                            type: 2,
                            title:'请选择详细地址',
                            shadeClose: true,
                            shade: 0.8,
                            area: ['100%', '100%'],
                            content: url, 
                        });
                }else{
                     layer.open({
                        type: 2,
                        title:'请选择详细地址',
                        shadeClose: true,
                        shade: 0.8,
                        area:['60%', '680px'],
                        content: url, 
                    });
                }
        }

        function call_back_by_map(address,jindu,weidu){
            $('input[name=detail],input[name=address]').val(address);
            $('input[name=lat]').val(weidu);
            $('input[name=lon]').val(jindu);
            layer.closeAll();
        }

        $('#kecheng_list').keypress(function(e) { 
           var rows=parseInt($(this).attr('rows'));
            // 回车键事件  
           if(e.which == 13) {  
                rows +=1;
           }  
           $(this).attr('rows',rows);
      });
    </script>
@endsection