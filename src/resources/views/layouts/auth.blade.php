<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf_token" content="{{ csrf_token() }}">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <title>{{ config('app.name') }}</title>

        @include('laravel-enso/core::includes.authCss')

        <link rel = "icon" href = "/images/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="{{ mix("css/app.css") }}"/>
        <link rel="stylesheet" type="text/css" href="{{ mix("css/auth.css") }}"/>
    </head>

    <body class="hold-transition login-page">
        <div id="particles-js"></div>

        @yield('content')

        <script type="text/javascript" src="{{ mix("/js/auth.js") }}"></script>

        @include('laravel-enso/core::includes.authJavascript')

        @stack('scripts')

    </body>
</html>
