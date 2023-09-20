
@extends('app')
@section('content')

<section class="section" id="employees" v-cloak>
    <employees
    :permissions="permissions">
    </employees>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#employees',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
