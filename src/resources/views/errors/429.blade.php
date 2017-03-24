@extends('laravel-enso/core::layouts.error')

@section('pageTitle', '429')

@section('content')

  <div class="content">
    <div class="title">Too many requests.</div>
    <div class="quote">429 Error</div>
    <div class="explanation">
      <br>
      <small>
        {!! isset($exception) ? ($exception->getMessage() ? $exception->getMessage().'<br>' : '') : '' !!}
        Please return to <a href="/">our homepage</a>.
      </small>
    </div>
  </div>

@endsection