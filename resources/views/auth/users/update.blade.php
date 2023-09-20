@extends('app')

@section('content')
<div class="col-md-8 col-md-offset-2">
  <div class="iw-sider-card-wrap mb-3">
      {!! Form::open(['method' => 'PATCH','url'=>'users/'.auth()->user()->id .'/updatepassword', 'class' => 'form-horizontal']) !!}

    <div class="card-header"><strong>Change Password</strong></div>
    <div class="card-body">

      <div class="form-group row">
        <label for="password" class="col-md-4 control-label required">Old Password</label>
        <div class="col-md-6">
          <input  type="password" class="form-control"  required name="old_password" autofocus>
        </div>
      </div>

      <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-4 control-label required">New Password</label>
        <div class="col-md-6">
          <input id="password" type="password" required  class="form-control" name="password" >

          @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="password-confirm" class="col-md-4 control-label required">Confirm Password</label>
        <div class="col-md-6">
          <input id="password-confirm" required type="password" class="form-control" name="password_confirmation" >

          @if ($errors->has('password_confirmation'))
          <span class="help-block">
            <strong>{{ $errors->first('password_confirmation') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row">
        <div class="col-md-6 col-md-offset-4">
          <button type="submit" class="btn iw-btn-add btn-sm">
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}

</div>
@stop
