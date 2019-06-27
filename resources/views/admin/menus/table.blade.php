<table class="table table-responsive" id="menus-table">
    <thead>
        <tr>
            <th>菜单名称</th>
           @if(!$online)<th>别名</th>@endif
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($menus as $menu)
        <tr>
            <td>{!! $menu->name !!}</td>
           @if(!$online)<td>{!! $menu->slug !!}</td>@endif
            <td>
                {!! Form::open(['route' => ['menus.destroy', $menu->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('menus.show', [$menu->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-plus"></i></a>
                    <a href="{!! route('menus.edit', [$menu->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                   @if(!$online) {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除?')"]) !!}@endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>