<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameCommerce @yield('title')</title>

    <link rel="stylesheet" href="{{URL::to('/')}}/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="{{URL::to('/')}}/jquery/jquery-3.5.1.min.js"></script>
</head>

    <body>

    @include('includes.navigator')
    <div id="page-container">
        @yield('shopcontents')
        @yield('content')
    </div>
    @include('includes.footer')
    @include('includes.modal')
     
    </body>
{{--AJAX Modal --}}
@include('includes.ajax')

    <script type="text/javascript" src="{{URL::to('/')}}/js/popper.min.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/app.js"></script>
    <script type="text/javascript" src="{{URL::to('/')}}/js/custom.js"></script>
</html>
