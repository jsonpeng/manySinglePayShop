@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Buy Log
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($buyLog, ['route' => ['buyLogs.update', $buyLog->id], 'method' => 'patch']) !!}

                        @include('buy_logs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection