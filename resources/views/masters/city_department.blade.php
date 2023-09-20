
@extends('app')
@section('content')

<section class="section" id="city_departments" v-cloak>
    <city-departments
        :city_id="city_id"
        :city="city"
        :department_types="department_types"
        :permissions = 'permissions'>
    </city-departments>
</section>
@stop

@section('script')
    <script>
        var vm = new Vue({
            'el':'#city_departments',
            data:{
                permissions: {!! json_encode(getPermissions()) !!},
                city_id :{!!$city_id !!},
                city :{!! json_encode($city) !!},
                department_types:{!! json_encode(getDepartmentTypes()) !!}
            }
        });
    </script>
@stop
