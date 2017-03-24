@extends('laravel-enso/core::layouts.error')

@section('pageTitle', '500')

@section('content')

  <div class="content">
    <div class="title">It's not you, it's me.</div>
    <div class="quote">500 Error</div>
    <div class="explanation">
      <br>
      <small>
        {!! isset($exception) ? ($exception->getMessage() ? $exception->getMessage().'<br>' : '') : '' !!}
        Please return to <a href="/">our homepage</a>.
      </small>
    </div>
  </div>

@endsection