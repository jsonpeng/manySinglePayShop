@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Buy Log
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('buy_logs.show_fields')
                    <a href="{!! route('buyLogs.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
