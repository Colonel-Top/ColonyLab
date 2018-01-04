@extends('layouts.app')

@section('content')

<script src="components/c3/c3.min.js"></script>
<script src="components/d3/d3.min.js"></script>
<script src="components/jquery-match-height/dist/jquery.matchHeight-min.js"></script>


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

                   Welcome You are logged in as Administrator <strong> {{Auth::user()->name }} {{Auth::user()->surname}} </strong>
                </div>
            </div>
        </div>

     <!--   <a href="/admin/Course/courselist">Course Management</a> -->
    </div>
</div>
@endsection




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>

    $(document).ready(function(){
        $('#sidebar-btn').click(function(){
            $('#sidebar').toggleClass('visible');
        });
    });

    </script>