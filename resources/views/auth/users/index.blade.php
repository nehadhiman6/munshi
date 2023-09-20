@extends('app')
@section('content')

    <section class="main-body">
        <div class="main-wrapper">
            <div class="iw-sider-card-wrap mb-3">
                <div class="card-header">
                    <strong>Add User</strong>
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseExample">
                        <i class="mdi mdi-arrow-down-drop-circle"></i>
                    </button>
                </div>
                <!--table collapse-->
                <div class="collapse show" id="collapseOne">
                    <!--table-->
                    <div class="card-block">
                        @include('auth.users.create')
                    </div>
                    <!--table-->
                </div>

                <!--table collapse-->
            </div>
            <div class="iw-sider-card-wrap">
                <div class="card-header">
                    <strong>Users List</strong>
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="mdi mdi-arrow-down-drop-circle"></i>
                    </button>

                </div>
                <div id="collapseTwo" class="collapse show" >
                    <!--table-->
                    <div class="card-block">
                        <div class="iw-panel-wrapper">
                            <div class="table-responsive">
                                <table id="example1" class="table table-striped table-theme  table-bordered"  width= "100%">
                                    <thead>
                                        <tr>
                                            <th>Sr.no</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
                                            @foreach($users as $user)
                                                <tr>
                                                <td>{{$i }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->roles->count() > 0 ? $user->roles[0]->role : '' }}</td>
                                                <td>{{ $user->email }}</td>

                                                <td><a href="{{ url('users/' . $user->id . '/edit') }}" class="btn iw-btn iw-btn-edit">Edit</a></td>

                                                </tr>
                                            @php $i++ @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--table-->
                </div>
                <!--table collapse-->
            </div>
            <!--table wrapper-->
        </div>
    </section>
@stop
@section('script')
<script>
    $('#example1').DataTable();
</script>
@stop
