<div class="iw-panel-wrapper">
    <div class="iw-form-header"></div>
    {!! Form::model($role, ['method' => 'PATCH', 'action' => ['Auth\RoleController@update', $role->id], 'class' => 'form-horizontal']) !!}
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('name','Name',['class' => 'col-md-2 control-label required']) !!}
            {!! Form::text('name',null,['class' => 'form-control']) !!}
            @if ($errors->has('name'))<span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>@endif
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn iw-btn-submit">UPDATE</button>
    </div>
</div>
