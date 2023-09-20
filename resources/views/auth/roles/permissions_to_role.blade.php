@extends('app')
@section('content')
  <div  id="permissions">
    <role-permissions :role='role' :opt_groups='opt_groups' :permissions="permissions"></role-permissions>
  </div>
@stop

@section('script')
<script>
    var vm = new Vue({
        el:"#permissions",
        data: {
          role: {!! $role !!},
          opt_groups: {!! $opt_groups !!},
          permissions: {!! json_encode($role->permissions->pluck('id')->toArray()) !!},
        }
    });
</script>
@stop


