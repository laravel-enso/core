<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="pusher-key" content="{{ $store->pusherKey }}">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <title>{{ __(config('app.name')) }} | @yield('pageTitle')</title>

        @include('laravel-enso/core::includes.mainCss')

        @yield('css')

        <link rel="icon" href="/images/favicon.png"/>
        <link rel="stylesheet" type="text/css" href="/css/all.css"/>
        <link rel="stylesheet" type="text/css" href="/css/app.css"/>
        <link rel="stylesheet" type="text/css" href="/css/main.css"/>
        <!-- <link rel="stylesheet" type="text/css" href="{{ mix('css/all.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ mix('css/main.css') }}"/> -->
    </head>

    <body class="sidebar-mini  skin-{{ $store->user->preferences->global->theme }} {{ $store->user->preferences->global->collapsedSidebar ? 'sidebar-collapse' : null }} {{ $store->user->preferences->global->fixedHeader ? 'fixed' : null }}">
        <div id="app" class="wrapper">

            @include('laravel-enso/core::partials.header')

            {!! $menu->render() !!}

            <div class="content-wrapper">

                @yield('content')

            </div>

            @include('laravel-enso/core::partials.flash')

            @include('laravel-enso/core::partials.footer')

            @include('laravel-enso/core::partials.sidebar')

            @includeIf('laravel-enso/impersonate::stop')

        </div>

        <script>window.Store = {!! $store !!};</script>

        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

        @include('laravel-enso/core::includes.mainJavascript')

        <script type="text/javascript" src="{{ mix('js/defaults.js') }}"></script>

        @stack('scripts')

    </body>
</html>