@extends('layouts.app')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@section('content')
<div class="container">
    <div class="row">
         @if (session('message1'))
                        <div class="alert alert-success">
                            {{ session('message1') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-warning">{{ Session::get('error') }}</div>
                    @endif
        <div class="col-md-8 ">
            <div class="panel panel-default animated zoomIn">

                <div class="panel-heading">Student Dashboard</div>

                <div class="panel-body">
                   

                    Welcome {{Auth::user()->pinid}} logged in as {{Auth::user()->name }} {{Auth::user()->surname}}
                </div>
            </div>
        </div>
         <div class="col-md-4">
            <div class="panel panel-default animated zoomIn">
                <div class="panel-heading">Current Server Date Time</div>

                <div class="panel-body">
                   Current Date: {{$date}} | Page Load at: {{$time}}
                </div>
            </div>
        </div>


        <div class="panel panel-default col-xs-12 col-sm-12 col-md-12">
              <div class="panel-heading">Incoming Due Assignment</div>
                <table class="table table-striped task-table animated fadeInUp">
                    <!-- Table Headings -->
                    <thead>
                        <th width="20%">Course Name</th>
                        <th width="20%">Assignment Name</th>
                        <th width="20%">Available at</th>
                        <th width="20%">End Date</th>
                        <th width="20%">Action</th>
                    </thead>
    
                    <!-- Table Body -->
                    <tbody>
                    @foreach($asn as $post)
                     @foreach($courses as $data)
                      @if($data->id == $post->courses_id)
                        <tr>
                            
                           
                            <td class="table-text">
                                <div>{{$data->coursename}}</div>
                            </td>
                            
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
                                <!--<a href="{{ route('user.assignments.score', $post->id) }}" class="label label-danger">Score</a>
                                    <a href="{{ route('user.assignments.submit',$post->id) }}" class="label label-success">Submit</a>
                                -->
                                <a href="{{ route('user.assignments.detail', $post->id) }}" class="label label-warning">Question</a>
                                 <a href="{{ route('user.assignments.indexmy',$post->id) }}" class="label label-success">See Details</a>
                               
                                
                                
                               
                            </td>
                        </tr>
                      @endif
                            @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
</div>
@endsection
