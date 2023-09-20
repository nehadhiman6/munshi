@extends('app')
@section('content')

<section class="section" id="contacts" v-cloak>
    <contacts-list
        :permissions = 'permissions'>
        <div slot="title">
                Mortgagees List
        </div>
    </contacts-list>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#contacts',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
            }
        });
    </script>
@stop
