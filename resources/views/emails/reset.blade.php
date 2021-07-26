@component('mail::message')
{{ __('Hi :name', ['name' => $name]) }},

{{ __("You just asked for a password reset") }}.
{{ __('To complete the process click the button below.') }}

@component('mail::button', ['url' => $url, 'color' => 'red'])
{{ __('Set your new password') }}
@endcomponent

@lang('Regards'),
<br>
{{ config('app.name') }}
@endcomponent
