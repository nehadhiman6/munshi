@extends('app')
@section('content')
     <section class="main-body">
        <div class="main-wrapper">
            <div class="iw-sider-card-wrap mb-3">
                <div class="card-header">
                    <strong>Edit User</strong>
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="mdi mdi-arrow-down-drop-circle"></i>
                    </button>
                </div>
                <!--table collapse-->
                <div id="collapseOne" class="collapse show" >
                    <!--table-->
                    <div class="card-block">
                        <div class="iw-panel-wrapper">
                            {!! Form::model($user, ['method' => 'PATCH', 'url' =>'users/'. $user->id, 'class' => 'form-horizontal']) !!}
                            @include('auth.users.form')
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn iw-btn-submit  btn-sm mr-1">UPDATE</button>
                                <a href="{{url('users')}}" class="btn iw-btn-cancel btn-sm">CANCEL</a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <!--table-->
                </div>
            </div>
        </div>
    </section>
@stop
