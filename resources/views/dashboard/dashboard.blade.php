
@extends('app')
@section('content')

<section class="section" id="dashboard" v-cloak>
    <dashboard
    :permissions="permissions">
    </dashboard>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#dashboard',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
