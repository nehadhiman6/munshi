@extends('app')
@section('content')

    <section class="section" id="file-openings" v-cloak>
        <file-page :file_opening_id="file_opening_id" :lro="lro" :cities="cities" :permissions="permissions"
            :author="author" :client_name="client_name" :client_sub_title="client_sub_title"
            :client_address="client_address" :client_phone="client_phone" :client_email="client_email">
        </file-page>
    </section>
@stop

@section('script')

    <script>
        var vm = new Vue({
            'el': '#file-openings',

            data: {
                permissions: {!! json_encode(getPermissions()) !!},
                cities: {!! json_encode(getCities()) !!},
                file_opening_id: {{ $file_opening_id }},
                lro: {!! json_encode(lotNumbers()) !!},
                author: "{{ auth()->user()->name }}",
                client_name: "{{ config('app.client_name', 'client_name') }}",
                client_sub_title: "{{ config('app.client_sub_title', 'client_sub_title') }}",
                client_address: "{{ config('app.client_address', 'client_address') }}",
                client_phone: "{{ config('app.client_phone', 'client_phone') }}",
                client_email: "{{ config('app.client_email', 'client_email') }}",
            }
        });

    </script>
@stop
