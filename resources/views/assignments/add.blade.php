@extends('layouts.app')

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

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
                    <h2>Create Assignment</h2>
                    <h5>* Required</h5>
                </div>
            </div>
            <div class="panel-body">
               
                <form action="{{ route('admin.assignments.create') }}" method="POST" class="form-horizontal " enctype="multipart/form-data">
                    {{ csrf_field() }} 
              
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Assignment Name* </label>

                        <div class="col-md-6">
                             <input type="hidden" name="idc" id="idc" class="form-control" required value="{{$id}}">

                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Compile language* </label>
                        &nbsp;
                        <select name="language" id="language">
                            <option value="c">GCC C</option>
                            <option value="java">JAVA JDK</option>
                            <option value="python">Python py</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" >Full Score* </label>

                        <div class="col-md-1">
                            <input type="integer" name="fullscore" id="fullscore" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Allow Send Now ? </label>

                        <div class="col-md-6">
                              <input name="allow_send" type="checkbox" value="1">
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-md-4 control-label" >Question File</label>

                        <div class="col-md-1">
                             <input class="field" id = "fpath" name="fpath" type="file">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" >Output File</label>

                        <div class="col-md-1">
                             <input class="field" id = "foutput" name="foutput" type="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Start Date</label>

                        <div class="col-md-2">
                             <input class="date form-control" name="startdate" id="startdate" type="text">
                        </div>
                        </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" >Start Time</label>
                     <div class="col-md-2">
                            <input class="timepicker form-control" name="starttime"  id="starttime"  type="text">
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-md-4 control-label" >End Date</label>

                        <div class="col-md-2">
                             <input class="date form-control" name="enddate" id="enddate" type="text">
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-4 control-label" >End Time</label>
                         <div class="col-md-2">
                            <input class="timepicker form-control" name="starttime"  id="endtime"  type="text">
                        </div>
                    </div>
                     


                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-10">
                            <input type="submit" class="btn btn-default"  value="Create Assignment" />
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('.timepicker').datetimepicker({

        format: 'HH:mm:ss'

    }); 

</script>  
<script type="text/javascript">

    $('.date').datepicker({  

       format: 'mm-dd-yyyy'

     });  

</script> 
@endsection

