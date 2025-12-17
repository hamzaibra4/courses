<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="TechnoMath ">
    <meta name="keywords"  content="TechnoMath">
    <meta name="author"  content="BA Solutions">
    <title>TechnoMath</title>
    <link rel="apple-touch-icon" href="{{asset('cms/app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('cms/app-assets/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
          rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/vendors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/vendors/css/calendars/fullcalendar.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/fonts/simple-line-icons/style.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/pages/timeline.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/plugins/forms/switch.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/core/colors/palette-callout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/vendors/css/forms/selects/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/vendors/css/extensions/sweetalert.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/plugins/forms/checkboxes-radios.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/vendors/css/pickers/daterange/daterangepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/plugins/pickers/daterange/daterange.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/core/menu/menu-types/vertical-menu-modern.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('cms/app-assets/css/pages/invoice.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('cms/custom/css/bas.css?v1')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
          rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('cms/custom/css/editable.css?v1')}}">
    @yield('customcss')
    <style>


    </style>
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu" data-col="2-columns">
@include('commons.topbar')
@include('commons.sidebar')
<div class="app-content content">
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>
@include('commons.footer')
<input type="hidden" value="#" id="resolver" />


<script src="{{asset('cms/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/datatable/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js')}}"
        type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/extensions/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/extensions/fullcalendar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/buttons.flash.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/jszip.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/pdfmake.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/vfs_fonts.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/buttons.html5.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/tables/buttons.print.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/scripts/tables/datatables/datatable-advanced.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/extensions/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/scripts/extensions/sweet-alerts.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/pickers/pickadate/picker.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/pickers/pickadate/picker.date.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/pickers/pickadate/picker.time.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/pickers/pickadate/legacy.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/pickers/daterange/daterangepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/core/app.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/scripts/customizer.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/forms/tags/form-field.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/custom/app.js')}}" type="text/javascript"></script>
<script src="{{asset('cms/custom/delete.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
{{--<script src="{{asset('cms/app-assets/js/scripts/extensions/fullcalendar.js')}}" type="text/javascript"></script>--}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

@yield('customjs')

</body>
</html>
