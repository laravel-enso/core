@extends('laravel-enso/core::layouts.auth')

@section('content')
    <div class="login-box">
         <div class="login-logo">
          <a href="index.php"><img style = "height:60px; width:200px; margin-bottom:5px" class = "logo center-block img-responsive" src = "/images/logo.png"/></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Reset Parola</p>
            @if(count($errors))
              @push('scripts')
              <script>
              $(function(){
                toastr.error("{{ $errors->first('email') }} {{ $errors->first('password') }} {{ $errors->first('password_confirmation') }}");
              });
              </script>
              @endpush
            @endif
            {!! Form::open(['method' => 'POST', 'url' => '/password/reset']) !!}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
              {!! Form::email('email', $email, ['class' => 'form-control', 'placeholder' => 'email']) !!}
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'parola']) !!}
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
              {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => ' repeta parola']) !!}
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group">
                {!! Form::submit('Salveaza noua parola', ['class' => 'btn btn-primary btn-block']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection