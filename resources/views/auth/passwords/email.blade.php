@extends('layouts.auth')

@section('content')
    <div class="login-box">
      <div class="login-box-body">
        <p class="login-box-msg">Reseteaza parola</p>
        @if(count($errors))
            @push('scripts')
                <script>
                $(function(){
                    toastr["error"]("{{ $errors->first('email') }}");
                });
                </script>
            @endpush
        @endif
        @if (session('status'))
            @push('scripts')
            <script>
                $(function(){
                    toastr["success"]("{{ session('status') }}");
                });
            </script>
            @endpush
        @endif
        {!! Form::open(['method' => 'POST', 'url' => '/password/email']) !!}
        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'email']) !!}
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group">
            {!! Form::submit('Genereaza link pentru reset parola', ['class' => 'btn btn-primary btn-block']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
@endsection