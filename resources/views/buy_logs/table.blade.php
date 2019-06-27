<table class="table table-responsive" id="buyLogs-table">
    <thead>
        <tr>
        <th>订单总价</th>
        <th>分享平台</th>
        <th>收货人姓名</th>
        <th>收货人电话</th>
        <th>收货人地址</th>
        <th>支付平台</th>
        <th>支付状态</th>
        <th>购买时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($buyLogs as $buyLog)
        <tr>
            <td>{!! $buyLog->price !!}</td>
            <td>{!! $buyLog->share_platform ? $buyLog->share_platform : '无(直接访问网站购买)' !!}</td>
            <td>{!! $buyLog->name !!}</td>
            <td>{!! $buyLog->mobile !!}</td>
            <td>{!! $buyLog->address !!}</td>
            <td>{!! $buyLog->pay_platform !!}</td>
            <td>{!! $buyLog->pay_status !!}</td>
            <td>{!! $buyLog->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['buyLogs.destroy', $buyLog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     <a href="{!! route('buyLogs.show', [$buyLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
              {{--       <a href="{!! route('buyLogs.edit', [$buyLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        <?php $items = $buyLog->items()->get();?>
        @if(count($items))
            @foreach($items as $item)
                <tr>
                    <td>&nbsp;&nbsp;购买商品:{!! $item->product_name !!}</td>
                    <td>购买金额:{!! $item->price !!}</td>
                    <td>购买数量:{!! $item->num !!}</td>
                </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>