<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="TechnoMath ">
    <meta name="keywords"  content="TechnoMath">
    <meta name="author"  content="BA Solutions">
    <title>TechnoMath</title>
    <link rel="apple-touch-icon" href="{{asset('cms/cms/app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('cms/cms/app-assets/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"

        rel="stylesheet">
        <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/vendors.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/core/colors/palette-gradient.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/fonts/meteocons/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/fonts/simple-line-icons/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/fonts/line-awesome/css/line-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/pages/invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
        p{
            margin-bottom: 0px !important;
        }
    </style>
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu" data-col="2-columns">
<div class="container">
    <div class="content-wrapper">
            @yield('content')
    </div>
</div>
<script src="{{asset('cms/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/buttons.flash.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/jszip.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/pdfmake.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/vfs_fonts.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/buttons.html5.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/buttons.print.min.js')}}" type="text/javascript"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/scripts/tables/datatables/datatable-advanced.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/core/app.js')}}" type="text/javascript"></script>

</body>
</html>
