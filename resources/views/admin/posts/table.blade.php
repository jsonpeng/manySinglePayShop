<table class="table table-responsive" id="posts-table">
    <thead>
        <tr>
            <th>名称</th>
    {{--         <th>别名</th> --}}
            {{-- <th>类型</th> --}}
            <th>图像</th>
            <th>分类</th>
            <th>文章状态</th>
            <th>审核状态</th>
            {{-- <th>链接</th> --}}
            <th>浏览量</th>
            <th>发布人</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($posts as $post)
    <?php $author = $post->AuthorWithType;?>
        <tr>
            <td>{!! $post->name !!}</td>
    {{--         <td>{!! $post->slug !!}</td> --}}
            {{-- <td>{!! $post->LeiXing !!}</td> --}}
            <td><img src="{{ asset($post->image) }}" style="height: 25px;"></td>
            <td>@foreach ($post->cats as $cat)
                &nbsp;{{$cat->name}}
            @endforeach</td>
            <td>{!! $post->publish !!}</td>
            <td>{!! $post->publish_status !!}</td>
            {{-- <td>{!! $baseurl !!}/post/{!! $post->id !!}</td> --}}
            <td>{!! $post->view !!}</td>
            <td>{!! $author['author'] !!}({!! $author['author_type'] !!})</td>
            <td>
                {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'delete']) !!}
                <div class='btn-group'>

                    @if(Request::get('cat') != '3')
                        <a href="{!! $baseurl !!}/post/{!! $post->id !!}" target="_blank" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    @else
                        <a href="/zcjy/quickNewsImg/{!! $post->id !!}" target="_blank" class="btn btn-default btn-xs">查看快讯图</a>
                    @endif

                    @if($post->LeiXing=="文章")
                    <a href="{!! route('posts.edit', [$post->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    @else
                     <a href="{!! route('posts.edit', [$post->id]) !!}?post_type={!! $post->type !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    @endif
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>