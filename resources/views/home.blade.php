@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Student Dashboard</div>

                <div class="panel-body">
                    @if (session('message1'))
                        <div class="alert alert-success">
                            {{ session('message1') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-warning">{{ Session::get('error') }}</div>
                    @endif

                    Welcome <{{Auth::user()->noid}}> logged in as {{Auth::user()->name }} {{Auth::user()->surname}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
