<div class="iw-panel-wrapper">
    <!-- {{-- <div class="iw-form-header">Users</div> --}} -->
    {!! Form::open(['url' => 'users', 'class' => 'form-horizontal']) !!}
        @include('auth.users.form')
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn iw-btn-submit">SAVE</button>
    </div>
</div>
