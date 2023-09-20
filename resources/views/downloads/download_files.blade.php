
@extends('app')
@section('content')

<section class="section" id="download-documents" v-cloak>
    <download-documents
        :permissions = 'permissions'>
    </download-documents>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#download-documents',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
