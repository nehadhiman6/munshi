<head>
    <title>Munshi</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}" />
    <!-- app favicon -->
    <link rel="shortcut icon" href="{{asset('assets/img/munshi-favicon.png')}}" type="image/png">
    {{-- webpack generated files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    {{-- DATATABLE --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/b-html5-1.5.6/fc-3.2.5/fh-3.1.4/r-2.2.2/rr-1.2.4/datatables.min.css"/>
    {{-- DATATABLE LINKS END --}}
    {{-- SELECT2   --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">
    {{-- SELECT2 END HERE --}}



    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    <link href="http://cdn.materialdesignicons.com/3.5.95/css/materialdesignicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset(mix('assets/css/style_structure.css')) }}" />
    <link rel="stylesheet" href="{{ asset(mix('assets/css/project_style.css')) }}" />
    <link rel="stylesheet" href="{{ asset('plugins/sidebar/sidebar.css')}}"  />
    <link rel="stylesheet" href="{{ asset('plugins/feather/feather.css')}}"  />
    <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
    {{-- jquery ui for datepicker style --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('js/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.css">




    <style>
        .filepond--root {
        width:170px;
       }
       th, td { white-space: nowrap; }
       div.dataTables_wrapper {
       margin: 0 auto;
       }

    </style>
 </head>
