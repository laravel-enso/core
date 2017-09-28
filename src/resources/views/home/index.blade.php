<html>
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="pusher-key" content="">

        <title>{{ config('app.name') }}</title>

        <link rel="icon" href="/favicon.ico"/>
        <link id="theme" rel="stylesheet" type="text/css" href="{{ $theme }}">
        <link href="{{ mix('css/enso.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css"/>
    </head>
    <body>

        @routes()

        <div id="app">
            <app quote="{{ $inspiringQuote }}"></app>
        </div>

        <script src="{{ mix('js/enso.js') }}"></script>

    </body>
</html>
