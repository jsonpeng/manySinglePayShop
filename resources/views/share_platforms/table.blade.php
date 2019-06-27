<table class="table table-responsive" id="sharePlatforms-table">
    <thead>
        <tr>
        <th>平台名称</th>
        <th>分享链接</th>
        <th>二维码</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($sharePlatforms as $sharePlatform)
        <tr>
            <td>{!! $sharePlatform->name !!}</td>
            <td>{!! $sharePlatform->link !!}</td>
            <td><img src="{!! $sharePlatform->qrcode !!}"  style="min-width: 100px;height: auto;" /></td>
            <td>
                {!! Form::open(['route' => ['sharePlatforms.destroy', $sharePlatform->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                   {{--  <a href="{!! route('sharePlatforms.show', [$sharePlatform->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                   {{--  <a href="{!! route('sharePlatforms.edit', [$sharePlatform->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>