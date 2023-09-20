
@extends('app')
@section('content')

<section class="section" id="reports" v-cloak>
    <file-report>
    </file-report>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#reports',
            data:{

            }
        });
    </script>
@stop
