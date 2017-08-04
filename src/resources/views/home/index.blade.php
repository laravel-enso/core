<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name') }} | {{ __('Welcome') }}</title>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato:200,300,400"/>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway:300,400,600"/>
        <link rel="stylesheet" type="text/css" href="{{ mix("css/enso.css") }}"/>
        <link rel="stylesheet" type="text/css" href="{{ mix("css/welcome.css") }}"/>
        <link rel="icon" href="/images/favicon.ico"/>
    </head>
    <body>
        <center>
            <div class="content">
                <div class="title">{{ $inspiringQuote }}</div>
                <br>
                <a id="enter" href="/{{ $menu->link }}" class="btn btn-primary">{{ __("Enter the application") }}</a>
            </div>
        </center>
    </body>
</html>