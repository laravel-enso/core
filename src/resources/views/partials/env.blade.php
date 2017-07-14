@if(config('app.env') == 'local')
	<div class="text-center local-env col-xs-4">
	    <span class="label bg-orange">{{ __('Local') }}
	    </span>
	</div>
@endif