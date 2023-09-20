
@extends('app')
@section('content')

<section class="section" id="solicitor" v-cloak>
    <solicitor-list
        :permissions = 'permissions'>
    </solicitor-list>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#solicitor',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
