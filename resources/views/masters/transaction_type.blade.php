
@extends('app')
@section('content')

<section class="section" id="transaction" v-cloak>
    <transaction-type-list
        :permissions = 'permissions'>
    </transaction-type-list>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#transaction',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
