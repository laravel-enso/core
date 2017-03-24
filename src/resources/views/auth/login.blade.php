@extends('laravel-enso/core::layouts.auth')

@section('content')

	<div class="login-box">
		<div class="login-logo">
			<h2 class="app-title"><img class="logo center-block img-responsive" src="/images/logo.png"/>App</h2>
		</div>
	  	<div class="login-box-body">
			<div class="row">
				<p class="login-box-msg">Autentificare in sistem</p>
				<div class="col-xs-12">
				  	{!! Form::open(['method' => 'POST', 'url' => '/login']) !!}
				  	<div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
						{!! Form::text('email', old('email') or null, ['class' => 'form-control', 'placeholder' => 'email']) !!}
						<span class="fa fa-envelope-o form-control-feedback"></span>
				  	</div>
				  	<div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
						{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'parola']) !!}
						<span class="fa fa-lock form-control-feedback"></span>
				  	</div>
				</div>
			  	<div class="col-xs-7">
					<input name="remember" type="checkbox">
					<label for="remember"><i></i>{{ __("Tine-ma minte") }}</label>
			  	</div>
			  	<div class="col-xs-5">
					{!! Form::submit('Autentificare', ['class' => 'btn btn-primary btn-block']) !!}
			  	</div>
				{!! Form::close() !!}
			</div>
	  	</div>
	  	<a class="reset-link" href="{{ url('/password/reset') }}">Reset parola</a>
	</div>

@endsection


@push('scripts')

	<script>

		toastr.options = toastrDefaults;
		toastr.options.positionClass = "toast-top-center";

	  	$(function(){

			let errors = JSON.parse('{!! json_encode($errors->all()) !!}');

	  		if(errors.length) {

	  			errors.forEach((error) => {

	  				toastr.error(error);
	  			});
			}

	  });

	  </script>

@endpush
