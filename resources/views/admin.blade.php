@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Administrator Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in as You are logged in as <strong>Administrator</strong> {{Auth::user()->name }} {{Auth::user()->surname}}
                </div>
            </div>
        </div>
        <a href="/admin/Course/courselist">Course Management</a>
    </div>
</div>
@endsection
