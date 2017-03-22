@extends('core::layouts.error')

@section('pageTitle', '404')

@section('content')

  <div class="content">
    <div class="title">Page not found.</div>
    <div class="quote">404 Error</div>
    <div class="explanation">
      <br>
      <small>
        {!! isset($exception) ? ($exception->getMessage() ? $exception->getMessage().'<br>' : '') : '' !!}
        Please return to <a href="/">our homepage</a>.
      </small>
    </div>
  </div>

@endsection