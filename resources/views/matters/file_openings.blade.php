
@extends('app')
@section('content')

<section class="section" id="file-openings" v-cloak>
    <file-openings
        :permissions = 'permissions'>
    </file-openings>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#file-openings',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
