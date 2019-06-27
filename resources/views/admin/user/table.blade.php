<table class="table table-responsive" id="users-table">
    <thead>
        <tr>
            {{-- <th class="hidden-xs">会员ID</th> --}}
            <th>姓名</th>
            <th>昵称</th>
            <th>手机号</th>
            <th>头像</th>
            <th>邮箱</th>
            <th>上一次登录时间</th>
            <th>上一次登录IP</th>

            <th>认证类型</th>
            <th>优秀作家</th>

            <th>注册时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
    <?php $cert = app('common')->varifyCert($user);?>
        <tr>
            {{-- <td class="hidden-xs">{!! $user->id !!}</td> --}}
            <td>{!! $user->name !!}</td>
            <td>{!! $user->nickname !!}</td>
            <td>{!! $user->mobile !!}</td>
            <td><img src="{!! $user->head_image !!}" style="max-width: 80px;height: auto;"></td>
            <td>{!! $user->email !!}</td>
            <td>{!! $user->last_login !!}</td>
            <td>{!! $user->last_ip !!}</td>
            <td>@if(!$cert) {!! optional($user->cert)->type !!}  @endif</td>
            <td>{!! $user->good_writer ? '是' : '否' !!}</td>
            <td>{!! $user->created_at !!}</td>
            <td>

                <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i>查看</a>

                  <a href="javascript:;" class='btn btn-default btn-xs authMessage' data-name="{{ $user->name }}" data-id="{{ $user->id }}"><i class="
glyphicon glyphicon-envelope"></i>消息</a>

                @if(!$cert)
                 <a href="javascript:;" class='btn btn-default btn-xs setWriter' data-now="{!! $user->good_writer !!}" data-id="{{ $user->id }}">
                    @if($user->good_writer)
                    取消优秀作家
                    @else
                    设置为优秀作家
                    @endif
                 </a>
                @endif
                <div class='btn-group'>
                 
            
                </div> 

            </td>
        </tr>
    @endforeach
    </tbody>
</table>