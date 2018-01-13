@extends('layouts.app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@section('content')
<div class="container">
    <div class="col-lg-12">
   @if (Session::has('message1'))
    <div class="alert alert-info">{{ Session::get('message1') }}</div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-warning">{{ Session::get('error') }}</div>
    @endif
    <!-- courses list -->
    @if(!empty($data))
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left animated fadeInLeft">
                    <h2>Marks</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <table class="table table-striped task-table animated fadeInUp">
                    <!-- Table Headings -->
                    <thead>
                        <th width="30%">ID</th>
                        <th width="20%">Name</th>
                        <th width="20%">Score</th>
                        <th width="10%">Created</th>
                        <th width="20%">Action</th>
                    </thead>
    
                    <!-- Table Body -->
                    <tbody>
                    @foreach($data as $post)
                      
                        <tr>
                           
                            <td class="table-text">
                                <div>{{$post->pinid}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$post->name}} </div>
                            </td>
                            <td class="table-text">
                                <div>{{$post->scores}}</div>
                            </td>
                            <td class="table-text">
                                <div>{{$post->created_at}}</div>
                            </td>
                            <td>
                                <a href="{{ route('user.assignments.callpath', $post->id) }}" class="btn btn-success">Show</a>   
                              
                                 
                            
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