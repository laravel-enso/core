@extends('laravel-enso/core::layouts.error')

@section('pageTitle', '401')

@section('content')

  <div class="content">
    <div class="title">Unauthorized action.</div>
    <div class="quote">401 Error</div>
    <div class="explanation">
      <br>
      <small>
        {!! isset($exception) ? ($exception->getMessage() ? $exception->getMessage().'<br>' : '') : '' !!}
        Please return to <a href="/">our homepage</a>.
      </small>
    </div>
  </div>

@endsection