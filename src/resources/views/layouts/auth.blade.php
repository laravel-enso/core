<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta name="csrf_token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="icon" href="/favicon.ico"/>
        <link id="theme" rel="stylesheet" type="text/css" href="/themes/clean/bulma.min.css">
        <link href="{{ mix('css/enso.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ mix('css/auth.css') }}" rel="stylesheet" type="text/css"/>
    </head>

    <body class="hold-transition login-page">
        <div id="app">
            <section class="hero login is-fullheight is-primary is-bold">
                <div class="hero-body">
                    <div class="container">
                        <div class="columns is-mobile is-centered">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <script type="text/javascript" src="{{ mix('js/auth.js') }}"></script>

        @stack('scripts')
    </body>
</html>
