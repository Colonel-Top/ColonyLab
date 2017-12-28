@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Student Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Welcome <{{Auth::user()->noid}}> logged in as {{Auth::user()->name }} {{Auth::user()->surname}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
