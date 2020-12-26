@component('mail::message')
# Thank you for registering your account!

Activate your account by pressing the button below

@component('mail::button', ['url' => ''])
Activate your account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent