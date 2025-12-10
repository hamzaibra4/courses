<!DOCTYPE html>
<html lang="en"
      dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Luma</title>

    <meta name="robots"
          content="noindex">

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&amp;display=swap"
          rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css"
          href="{{asset('front/public/vendor/spinkit.css')}}"
          rel="stylesheet">

    <!-- Perfect Scrollbar -->
    <link type="text/css"
          href="{{asset('front/public/vendor/perfect-scrollbar.css')}}"
          rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css"
          href="{{asset('front/public/css/material-icons.css')}}"
          rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link type="text/css"
          href="{{asset('front/public/css/fontawesome.css')}}"
          rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css"
          href="{{asset('front/public/css/preloader.css')}}"
          rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css"
          href="{{asset('front/public/css/app.css')}}"
          rel="stylesheet">

</head>

<body class="layout-app ">

<div class="preloader">
    <div class="sk-chase">
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
    </div>

    <!-- <div class="sk-bounce">
<div class="sk-bounce-dot"></div>
<div class="sk-bounce-dot"></div>
</div> -->

</div>

<!-- Drawer Layout -->
<div class="mdk-drawer-layout js-mdk-drawer-layout"
     data-push
     data-responsive-width="992px">
    <div class="mdk-drawer-layout__content page-content">
        <!-- Header -->
        @include('commons/front-header')
        <!-- // END Header -->

        <!-- Page Content -->
            @yield('content')
        <!-- // END Page Content -->

        <!-- Footer -->
        @include('commons/front-footer')
        <!-- // END Footer -->

    </div>
    <!-- // END drawer-layout__content -->
    <!-- Drawer -->
        @include('commons/front-drawer')
    <!-- // END Drawer -->

</div>

<!-- // END Drawer Layout -->
<!-- jQuery -->
<script src="{{asset('front/public/vendor/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('front/public/vendor/popper.min.js')}}"></script>
<script src="{{asset('front/public/vendor/bootstrap.min.js')}}"></script>
<!-- Perfect Scrollbar -->
<script src="{{asset('front/public/vendor/perfect-scrollbar.min.js')}}"></script>
<!-- DOM Factory -->
<script src="{{asset('front/public/vendor/dom-factory.js')}}"></script>
<!-- MDK -->
<script src="{{asset('front/public/vendor/material-design-kit.js')}}"></script>

<!-- App JS -->
<script src="{{asset('front/public/js/app.js')}}"></script>

<!-- Preloader -->
<script src="{{asset('front/public/js/preloader.js')}}"></script>

</body>

</html>
