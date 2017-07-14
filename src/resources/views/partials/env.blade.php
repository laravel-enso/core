@if(config('app.env') == 'local')
    <span class="badge bg-orange local-env">{{ __('Local') }}
    </span>
@endif