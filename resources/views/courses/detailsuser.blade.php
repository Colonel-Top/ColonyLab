@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <div class="pull-left">
            <h2>Course Info</h2>
        </div>
        <div class="pull-right">
            <a href="{{ route('user.courses.index') }}" class="label label-primary pull-right"> Back</a>
        </div>
    </div>
</div>
&nbsp;
<div class="row">
    <div class= "col-md-8 col-md-offset-2">
        <div class="form-group">
            <strong>Course Name:</strong>
            {{ $courses->coursename }}
        </div>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <strong>Owned By:</strong>
            {{ $courses->createby }}
        </div>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <strong>Course Publish On:</strong>
            {{ $courses->created }}
        </div>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <strong>Allow Register:</strong>
            @if($courses->allowregister == 1)
                Allowed Register
            @else
                Disallowed Register
            @endif
        </div>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group">
            <strong>Your Enroll Status for this Course:</strong>
             
            {{Auth::user()->with('courses')->get()}}
             
            
        </div>
    </div>
</div>
@endsection