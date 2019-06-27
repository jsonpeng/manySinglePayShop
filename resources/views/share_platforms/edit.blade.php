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
                   {!! Form::model($sharePlatform, ['route' => ['sharePlatforms.update', $sharePlatform->id], 'method' => 'patch']) !!}

                        @include('share_platforms.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection