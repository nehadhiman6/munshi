@extends('app')
@section('content')
    <section class="main-body">
        <div class="main-wrapper">

            <div class="iw-sider-card-wrap">
                <div class="card-header">
                    <strong>Role List</strong>
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="mdi mdi-arrow-down-drop-circle"></i>
                    </button>

                </div>
                <div id="collapseTwo" class="collapse show" >
                    <!--table-->
                    <div class="card-block">
                        <div class="iw-panel-wrapper">
                            <div class="table-responsive">
                                <table  id="example1" class="table table-bordered table-theme table-striped" width = "100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                            <th>Action</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td><a href="{{ url('roles/' . $role->id . '/permissions') }}" class="btn btn-sm  iw-btn iw-btn-edit">Permissions</a>
                                        {{-- <a href="{{ url('roles/' . $role->id . '/edit') }}" class="btn iw-btn iw-btn-edit">Edit</a> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
