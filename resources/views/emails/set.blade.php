@component('mail::message')
@component('mail::title')
{{ __('Set your password') }}
@endcomponent

{{ __('Hi :name', ['name' => $name]) }},

{{ __('An account was created for you. Set your password to activate access and finish the first login.') }}

@component('mail::button', ['url' => $url, 'variant' => 'danger'])
{{ __('Set password') }}
@endcomponent

@component('mail::alert', ['variant' => 'info'])
{{ __('This link can be used only once and expires automatically.') }}
@endcomponent

@component('mail::signature')
@endcomponent
@endcomponent
