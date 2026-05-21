@component('mail::message')
@component('mail::title')
{{ $title ?? __('Reset password request') }}
@endcomponent

{{ __('Hi :name', ['name' => $name]) }},

{{ $intro ?? __('You just asked for a password reset. To complete the process, click the button below.') }}

@component('mail::button', ['url' => $url, 'variant' => $variant ?? 'danger'])
{{ $action ?? __('Set your new password') }}
@endcomponent

@isset($notice)
@component('mail::alert', ['variant' => 'info'])
{{ $notice }}
@endcomponent
@endisset

@component('mail::signature')
@endcomponent
@endcomponent
