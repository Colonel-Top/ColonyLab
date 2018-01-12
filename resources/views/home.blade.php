@extends('layouts.app')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default animated zoomIn">
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

                    Welcome {{Auth::user()->pinid}} logged in as {{Auth::user()->name }} {{Auth::user()->surname}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
