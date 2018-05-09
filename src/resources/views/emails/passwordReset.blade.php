@extends('laravel-enso/core::emails.layouts.main')

@section('content')
    <p>
    {{$body}}
    </p>

    <p>
    {{$ending}}
    </p>
@endsection

@section('buttons')
    <a href="{{$resetURL}}" style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:220px;-webkit-text-size-adjust:none;">{{$buttonLabel}}</a>
@endsection