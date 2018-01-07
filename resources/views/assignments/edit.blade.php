@extends('layouts.app')

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  
  <script type="text/javascript">
  $('#starttime').datetimepicker({
    format: 'YY-MM-DD HH:mm:ss'
  });
   $('#endtime').datetimepicker({
    format: 'YY-MM-DD HH:mm:ss'
  });
</script> 
<style>
.hideplz
{
    visibility: hidden;
}
</style>
@section('content')
<div class="container">
    <div class="col-lg-12">
        @if($errors->any())
            <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach()
            </div>
        @endif
        <div class="panel panel-default">
            <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                    <h2>Edit Assignment</h2>
                    <h5>* Required</h5>
                </div>
            </div>
            <div class="panel-body">
               
                <form action="{{ route('admin.assignments.update') }}" method="POST" class="form-horizontal "enctype="multipart/form-data" >
                    {{ csrf_field() }} 
              
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Assignment Name* </label>

                        <div class="col-md-6">
                             <input type="hidden" name="idc" id="idc" class="form-control" required value="{{$ids->id}}">
    <input type="hidden" name="courses_id" id="courses_id" class="form-control" required value="{{$ids->courses_id}}">
     <input type="hidden" name="oldpath" id="oldpath" class="form-control" required value="{{$ids->fpath}}">
                            <input type="text" name="name" id="name" class="form-control" required value="{{$ids->name}}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Compile language* </label>
                        &nbsp;
                        <select name="language" id="language" value="{{$ids->language}}">

                            <option value="c">GCC C</option>
                            <option value="java">JAVA JDK</option>
                            <option value="python">Python py</option>
                        </select>
                    </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" >Max Attempts</label>

                        <div class="col-md-1">
                            <input type="integer" name="max_attempts" id="max_attempts" class="form-control" value="{{$ids->max_attempts}}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Full Score* </label>

                        <div class="col-md-1">
                            <input type="integer" name="fullscore" id="fullscore" class="form-control" required value="{{$ids->fullscore}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Allow Send Now ? </label>

                        <div class="col-md-6">
                              <input name="allow_send" id="allow_send" type="checkbox" >
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-md-4 control-label" >Question File*</label>

                        <div class="col-md-1">
                             <input class="field" id = "fpath" name="fpath" type="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Input File</label>

                        <div class="col-md-1">
                             <input class="field" id = "finput" name="finput" type="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Output File (Key)</label>

                        <div class="col-md-1">
                             <input class="field" id = "foutput" name="foutput" type="file">
                        </div>
                    </div>
                   <div class="form-group">
               <div class="form-group">
                <label class="col-md-4 control-label" >Start Date-Time</label>
                        <div class="col-sm-offset-3 col-md-4 input-group date" id="starttime"  >

                            <input type="text" class="form-control" id="starttime"/>  <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                        </div>
                    </div>

              <div class="form-group">
                <label class="col-md-4 control-label" >End Date-Time</label>
                 <div class="col-sm-offset-3 col-md-4 input-group date" id="endtime"  >
                            <input type="text" class="form-control" id="endtime"/>  <span class="input-group-addon" ><span class="glyphicon-calendar glyphicon"></span></span>
                        </div>
                        </div>

                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-10">
                            <input type="submit" class="btn btn-default"  value="Update Assignment" />
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
