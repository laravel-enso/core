@if (count($errors))
	<div class="alert alert-danger" style="border-radius:0">
	    @foreach ($errors->all() as $error)
	        {{ $error }}
	    @endforeach
	</div>
@endif
