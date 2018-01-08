@extends('layouts.app')
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
            <div class="panel-heading">
                Add a New Course <a href="{{ route('admin.courses.index') }}" class="label label-primary pull-right">Back</a>
            </div>
            <div class="panel-body">
                
                <form action="{{ route('admin.courses.insert') }}" method="POST" class="form-horizontal">
                    {{ csrf_field() }} 
              
              
                    
                   


                    <div class="form-group">
                        <label class="col-md-4 control-label" >Course Name </label>

                        <div class="col-md-6">
                            <input type="text" name="coursename" id="coursename" class="form-control">
                        </div>
                    </div>
                     <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Course Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Course Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group">
                        <label class="col-md-4 control-label" >Allow Register ?</label>

                        <div class="col-md-6">
                              <input name="allowregister" type="checkbox" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-default" value="Add Course" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

