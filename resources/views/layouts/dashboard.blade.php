<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !empty($title) ? $title : __('app.dashboard') }}</title>

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">
    <!-- Place favicon.ico in the root directory -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}">
    
    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-colvis-1.6.3/b-flash-1.6.3/b-html5-1.6.3/r-2.2.5/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css"/> --}}


    @yield('page-css')
    <!-- Scripts -->
    <script type='text/javascript'>
        /* <![CDATA[ */
        var page_data = {!! pageJsonData() !!};
        /* ]]> */
    </script>
</head>

    <!-- END: Head -->
    <body class="app">
    @php
    $pendingJobCount = \App\Models\Job::pending()->count();
    $approvedJobCount = \App\Models\Job::approved()->count();
    $blockedJobCount = \App\Models\Job::blocked()->count();
    $user = Auth::user();
    @endphp

        <!-- BEGIN: Mobile Menu -->
        @include('layouts.mobilemenu')
        <!-- END: Mobile Menu -->
        <div class="flex">
            <!-- BEGIN: Side Menu -->
            @include('layouts.sidemenu')
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div class="content">
                <!-- BEGIN: Top Bar -->
                @include('layouts.topbar')
                <!-- END: Top Bar -->
                @include('admin.flash_msg')
                <div class="action-btn-group">@yield('title_action_btn_gorup')</div>
                @yield('content')

            </div>
            <!-- END: Content -->
        </div>

        <!-- BEGIN: JS Assets-->
        @yield('page-js')
{{--         <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script> --}}
        
{{--         <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
        
        <script type="text/javascript">
            $('.datatable1').DataTable({
                responsive: true,
                dom: 'lBfrtip',
                buttons: [
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf fa-1x" aria-hidden="true"> PDF</i>' },
                    { extend: 'csv', text: '<i class="fas fa-file-csv fa-1x"> CSV</i>'},
                    { extend: 'print', text: '<i class="fas fa-file-excel" aria-hidden="true"> EXCEL</i>' }
                ]
            });
        </script> --}}
        <script src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript">
            function showMe (box) {
                var chboxs = document.getElementById("div1").style.display;
                var vis = "none";
                    if(chboxs=="none"){
                     vis = "block"; }
                    if(chboxs=="block"){
                     vis = "none"; }
                document.getElementById(box).style.display = vis;
            }

            function hideMe (box) {
                var chboxs = document.getElementById("div2").style.display;
                var vis = "none";
                    if(chboxs=="none"){
                     vis = "block"; }
                    if(chboxs=="block"){
                     vis = "none"; }
                document.getElementById(box).style.display = vis;
            }
        </script>
        <!-- App scripts -->
        @yield('scripts')        
        @stack('scripts')
        <!-- END: JS Assets-->
    </body>
</html>