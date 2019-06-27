<table class="table table-responsive" id="banners-table">
    <thead>
        <tr>
            <th>名称</th>
            @if(!$online)<th>别名</th>@endif
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($banners as $banner)
        <tr>
            <td>{!! $banner->name !!}</td>
              @if(!$online)<td>{!! $banner->slug !!}</td>@endif
            <td>
                {!! Form::open(['route' => ['banners.destroy', $banner->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('bannerItems.index', [$banner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-plus"></i></a>
                    <a href="{!! route('banners.edit', [$banner->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    @if(!$online){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}@endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>