<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="pusher-key" content="{{ $pusherKey }}">
        <meta name="preferences" content="{{ $preferences }}">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <title>{{ __(config('app.name')) }} | @yield('pageTitle')</title>

        @include('laravel-enso/core::includes.mainCss')
        @yield('includesCss')

        <link rel="icon" href="/images/favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/all.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}"/>
    </head>

    <body class="skin-{{ $theme }} sidebar-mini fixed {{ $collapsedSidebar }}">
        <div id="app" class="wrapper">

            @include('laravel-enso/core::partials.header')

            {!! $menu->html !!}

            <div class="content-wrapper">

                @yield('content')

            </div>

            @include('laravel-enso/core::partials.flash')

            @include('laravel-enso/core::partials.footer')

            @include('laravel-enso/core::partials.sidebar')

            @include('laravel-enso/core::partials.stopImpersonating')

        </div>

        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <!-- <script type="text/javascript" src="http://localhost:8080/js/app.js"></script> -->

        @include('laravel-enso/core::includes.mainJavascript')

        <script type="text/javascript" src="{{ asset('js/defaults.js') }}"></script>

        @stack('scripts')

    </body>
</html>