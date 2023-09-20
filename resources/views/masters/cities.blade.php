
@extends('app')
@section('content')

<section class="section" id="cities" v-cloak>
    <city-list
     :lro="lro"
        :permissions = 'permissions'>
    </city-list>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#cities',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
                 lro:{!! json_encode(lotNumbers()) !!},
            }
        });
    </script>
@stop
