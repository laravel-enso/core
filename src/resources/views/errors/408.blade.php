@extends('laravel-enso/core::layouts.error')

@section('pageTitle', '408')

@section('content')

  <div class="content">
    <div class="title">Request timeout.</div>
    <div class="quote">408 Error</div>
    <div class="explanation">
      <br>
      <small>
        {!! isset($exception) ? $exception->getMessage() : null !!}
        Please return to <a href="/">our homepage</a>.
      </small>
    </div>
  </div>

@endsection