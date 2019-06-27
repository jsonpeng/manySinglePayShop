<table class="table table-responsive" id="certs-table">
    <thead>
        <tr>
        <th>发起人</th>
        <th>认证类型</th>
        <th>组织名称</th>
        <th>组织代码</th>
        <th>身份证姓名</th>
        <th>身份证号码</th>
        <th>审核状态</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($certs as $certs)
        <tr>
            <td>{!! optional($certs->user)->ShowName !!}</td>
            <td>{!! $certs->type !!}</td>
            <td>{!! $certs->organization_name !!}</td>
            <td>{!! $certs->organization_code !!}</td>
            <td>{!! $certs->id_card_name !!}</td>
            <td>{!! $certs->id_card_num !!}</td>
            <td>{!! $certs->status !!}</td>
            <td>
              
                <div class='btn-group'>
                     {!! Form::model($certs, ['route' => ['certs.update', $certs->id], 'method' => 'patch']) !!}
                    @if($certs->status != '已通过')
                        <a class="btn btn-success btn-xs" href="javascript:;" onclick="$(this).parent().submit();"> 设置为已通过</a>
                        <input type="hidden" name="status" value="已通过" />
                    @else
                        <a class="btn btn-danger btn-xs" href="javascript:;" onclick="$(this).parent().submit();"> 设置为未通过</a>
                        <input type="hidden" name="status" value="未通过" />
                    @endif
                          {!! Form::close() !!}
                   {{--  <a href="{!! route('certs.show', [$certs->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('certs.edit', [$certs->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                      {!! Form::open(['route' => ['certs.destroy', $certs->id], 'method' => 'delete']) !!}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?删除后用户的认证信息将失效')"]) !!}
                      {!! Form::close() !!}
                </div>
              
            </td>
        </tr>
    @endforeach
    </tbody>
</table>