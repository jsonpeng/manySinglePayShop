@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            添加客户
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'clients.store']) !!}

                        @include('admin.clients.fields',['client'=>null])

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
      @include('admin.partial.imagemodel')
@endsection
