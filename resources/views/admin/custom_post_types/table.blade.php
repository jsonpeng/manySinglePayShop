<table class="table table-responsive" id="customPostTypes-table">
    <thead>
        <tr>
        <th>自定义文章类型名称</th>
        <th>自定义文章类型别名</th>
     
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($customPostTypes as $customPostType)
        <tr>
            <td>{!! $customPostType->name !!}</td>
            <td>{!! $customPostType->slug !!}</td>
            <td>
                {!! Form::open(['route' => ['customPostTypes.destroy', $customPostType->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('customPostTypeItems.index', [$customPostType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-plus"></i></a>
                    <a href="{!! route('customPostTypes.edit', [$customPostType->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                      @if(!$online){!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}@endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>