<!-- Type Field -->
<div class="form-group col-sm-8">
    {!! Form::label('type', '认证类型:') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
</div>

@if(isset($certs) && $certs->type != '个人')
    <!-- Organization Name Field -->
    <div class="form-group col-sm-8">
        {!! Form::label('organization_name', '企业/组织 名称:') !!}
        {!! Form::text('organization_name', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Organization Code Field -->
    <div class="form-group col-sm-8">
        {!! Form::label('organization_code', '企业/组织 营业执照注册号/组织机构代码:') !!}
        {!! Form::text('organization_code', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Organization Img Field -->
    <div class="form-group col-sm-8">
        {!! Form::label('organization_img', '营业执照扫描件图:') !!}
        {!! Form::text('organization_img', null, ['class' => 'form-control']) !!}
    </div>
@endif


<!-- Id Card Name Field -->
<div class="form-group col-sm-8">
    {!! Form::label('id_card_name', '身份证姓名:') !!}
    {!! Form::text('id_card_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Card Num Field -->
<div class="form-group col-sm-8">
    {!! Form::label('id_card_num', '身份证号码:') !!}
    {!! Form::text('id_card_num', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Card Time Type Field -->
<div class="form-group col-sm-8">
    {!! Form::label('id_card_time_type', '身份证有效期类型:') !!}
    {!! Form::text('id_card_time_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Card End Time Field -->
<div class="form-group col-sm-8">
    {!! Form::label('id_card_end_time', '身份证截止时间:') !!}
    {!! Form::text('id_card_end_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Card Zhengmian Field -->
<div class="form-group col-sm-8">
    {!! Form::label('id_card_zhengmian', '身份证正面:') !!}
    {{-- {!! Form::text('id_card_zhengmian', null, ['class' => 'form-control']) !!} --}}
    <div class="input-append">
                    {!! Form::text('id_card_zhengmian', null, ['class' => 'form-control', 'id' => 'image1']) !!}
                    <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image1')">选择图片</a>
                    <img src="@if($certs) {{$certs->id_card_zhengmian}} @endif" style="max-width: 100%; max-height: 300px; display: block;">
    </div>
</div>

<!-- Id Card Fanmian Field -->
<div class="form-group col-sm-8">
    {!! Form::label('id_card_fanmian', '身份证反面:') !!}
    {{-- {!! Form::text('id_card_fanmian', null, ['class' => 'form-control']) !!} --}}
    <div class="input-append">
                    {!! Form::text('id_card_fanmian', null, ['class' => 'form-control', 'id' => 'image2']) !!}
                    <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image2')">选择图片</a>
                    <img src="@if($certs) {{$certs->id_card_fanmian}} @endif" style="max-width: 100%; max-height: 300px; display: block;">
    </div>
</div>

<!-- Id Card Shouchi Field -->
<div class="form-group col-sm-8">
    {!! Form::label('id_card_shouchi', '手持身份证图:') !!}
    {{-- {!! Form::text('id_card_shouchi', null, ['class' => 'form-control']) !!} --}}
    <div class="input-append">
                    {!! Form::text('id_card_shouchi', null, ['class' => 'form-control', 'id' => 'image3']) !!}
                    <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image3')">选择图片</a>
                    <img src="@if($certs) {{$certs->id_card_shouchi}} @endif" style="max-width: 100%; max-height: 300px; display: block;">
    </div>
</div>

<div class="form-group col-sm-8">
    {!! Form::label('status', '审核状态:') !!}
    {{-- '审核中','已通过','未通过' --}}
    <select name="status" class="form-control">
            <option value="审核中" @if(isset($certs) && $certs->status == '审核中') selected="selected" @endif>审核中</option>
            <option value="已通过" @if(isset($certs) && $certs->status == '已通过') selected="selected" @endif>已通过</option>
            <option value="未通过" @if(isset($certs) && $certs->status == '未通过') selected="selected" @endif>未通过</option>
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('certs.index') !!}" class="btn btn-default">返回</a>
</div>
