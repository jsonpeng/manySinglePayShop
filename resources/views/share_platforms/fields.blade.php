<!-- Name Field -->
<div class="form-group col-sm-8">
    {!! Form::label('name', '名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Link Field -->
<div class="form-group col-sm-8">
    {!! Form::label('link', '链接:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<!-- Qrcode Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('qrcode', '二维码:') !!}
    {!! Form::text('qrcode', null, ['class' => 'form-control']) !!}
</div> --}}

<div class="form-group col-sm-8">
    {!! Form::label('size', '二维码图片大小(默认100*100):') !!}
    {!! Form::text('size', 100, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('sharePlatforms.index') !!}" class="btn btn-default">返回</a>
</div>
