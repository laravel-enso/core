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

        <link rel="icon" href="/images/favicon.ico"/>
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

        <link rel="stylesheet" type="text/css" href="{{ mix('css/all.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ mix('css/enso.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}"/>

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

        @php
            $polyfills = collect([
                'Promise',
                'Object.assign',
                'Object.values',
                'Array.prototype.find',
                'Array.prototype.findIndex',
                'Array.prototype.includes',
                'String.prototype.includes',
                'String.prototype.startsWith',
                'String.prototype.endsWith'
            ])->implode(',');
        @endphp

        <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features={{ $polyfills }}"></script>

        <script>window.Store = {!! $store !!};</script>

        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

        @include('laravel-enso/core::includes.mainJavascript')

        <script type="text/javascript" src="{{ mix('js/defaults.js') }}"></script>

        @stack('scripts')

    </body>
</html>