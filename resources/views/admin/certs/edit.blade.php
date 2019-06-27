@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
          编辑
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($certs, ['route' => ['certs.update', $certs->id], 'method' => 'patch']) !!}

                        @include('admin.certs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
    @include('admin.partial.imagemodel')
@endsection