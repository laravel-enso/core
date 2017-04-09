@extends('laravel-enso/core::layouts.error')

@section('pageTitle', '405')

@section('content')

  <div class="content">
    <div class="title">Method not allowed.</div>
    <div class="quote">405 Error</div>
    <div class="explanation">
      <br>
      <small>
        {!! isset($exception) ? $exception->getMessage() : null !!}
        Please return to <a href="/">our homepage</a>.
      </small>
    </div>
  </div>

@endsection