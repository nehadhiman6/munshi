<fieldset class="fieldset">
    <legend class="legend">Basic Details</legend>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('name','Name',['class' => 'control-label required ']) !!}
            {!! Form::text('name',null,['class' => "form-control",'placeholder'=>'Name']) !!}
            @if ($errors->has('name'))<span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>@endif
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('email','Email',['class' => 'control-label required']) !!}
            {!! Form::text('email',null,['class' => 'form-control ','placeholder'=>'Email']) !!}
            @if ($errors->has('email'))<div class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></div>@endif
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            {!! Form::label('role_id', 'Role', ['class' => 'control-label required']) !!}
            {!! Form::select('role_id', getRoles(), (isset($user) ? (isset($user->roles[0]) ?  $user->roles[0]->id: Null):Null),['class' => 'form-control' ]) !!}
            @if ($errors->has('role_id'))<div class="invalid-feedback"><strong>{{ $errors->first('role_id') }}</strong></div>@endif
        </div>
    </div>
</fieldset>
    @if(!isset($user))

    <fieldset class="fieldset">
        <legend class="legend">Login Credentials</legend>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('password','Password',['class' => 'control-label required']) !!}
                <input type='password' name='password' class='form-control' placeholder="Password">
                @if ($errors->has('password'))<div class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></div>@endif
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('password_confirmation','Confirm Password',['class' => 'control-label required']) !!}
                <input type='password' name='password_confirmation' class='form-control' placeholder="Confirm Password">
                @if ($errors->has('password_confirmation'))<div class="invalid-feedback"><strong>{{ $errors->first('password_confirmation') }}</strong></div>@endif
            </div>
        </div>
    </fieldset>
    @else
    <fieldset class="fieldset">
        <legend class="legend">Login Credentials</legend>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('password','Password',['class' => 'control-label']) !!}
                <input type='password' name='password' class='form-control' placeholder="Password">
                @if ($errors->has('password'))<div class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></div>@endif
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('password_confirmation','Confirm Password',['class' => 'control-label']) !!}
                <input type='password' name='password_confirmation' class='form-control' placeholder="Confirm Password">
                @if ($errors->has('password_confirmation'))<div class="invalid-feedback"><strong>{{ $errors->first('password_confirmation') }}</strong></div>@endif
            </div>
        </div>
    </fieldset>
    @endif


