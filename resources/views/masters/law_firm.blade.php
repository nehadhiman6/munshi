
@extends('app')
@section('content')

<section class="section" id="law-firm" v-cloak>
    <law-firm-list
        :permissions = 'permissions'>
    </law-firm-list>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#law-firm',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
