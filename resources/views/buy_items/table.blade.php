<table class="table table-responsive" id="buyItems-table">
    <thead>
        <tr>
            <th>Access Ip</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Num</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($buyItems as $buyItems)
        <tr>
            <td>{!! $buyItems->access_ip !!}</td>
            <td>{!! $buyItems->product_name !!}</td>
            <td>{!! $buyItems->price !!}</td>
            <td>{!! $buyItems->num !!}</td>
            <td>
                {!! Form::open(['route' => ['buyItems.destroy', $buyItems->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('buyItems.show', [$buyItems->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('buyItems.edit', [$buyItems->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>