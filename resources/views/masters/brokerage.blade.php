
@extends('app')
@section('content')

<section class="section" id="cities" v-cloak>
    <brokerage-list
        :permissions = 'permissions'>
    </brokerage-list>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#cities',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
