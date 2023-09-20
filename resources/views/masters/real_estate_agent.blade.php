
@extends('app')
@section('content')

<section class="section" id="real-estate-agents" v-cloak>
    <real-estate-agents
    :permissions="permissions">
    </real-estate-agents>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#real-estate-agents',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
