@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-lg-12">
   @if (Session::has('message1'))
    <div class="alert alert-danger">{{ Session::get('message1') }}</div>
    @endif
    <!-- courses list -->
    @if(!empty($asn))
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Assignment List of {{$course}}</h2>
                    
                </div>
                <div class="pull-right">

                    <a class="btn btn-danger" href="{{ route('logout') }}"> Logout</a>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                        <th width="30%">Assignment Name</th>
                        <th width="20%">Available at</th>
                        <th width="20%">End Date</th>
                        <th width="30%">Action</th>
                    </thead>
    
                    <!-- Table Body -->
                    <tbody>
                    @foreach($asn as $post)
                        <tr>
                            <td class="table-text">
                                <div>{{$post->name}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$post->starttime}} </div>
                            </td>
                                <td class="table-text">
                                <div>{{$post->endtime}}</div>
                            </td>
                            <td>
                                <a href="{{ route('user.assignments.score', $post->id) }}" class="btn btn-danger">Score</a>
                                <a href="{{ route('user.assignments.detail', $post->id) }}" class="btn btn-warning">Question</a>
                                <a href="{{ route('user.assignments.submit',$post->id) }}" class="btn btn-success">Submit</a>
                            
                               
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    </div>
</div>
@endsection