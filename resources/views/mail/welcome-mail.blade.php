
@component('mail::message')
# Welcome {{ $user->name }}!!

@component('mail::button', ['url'=> 'https://www.google.com'])
Google.com
@endcomponent
@component('mail::panel')
This is a pannel
@endcomponent
@component('mail::table')
| Laravel    | Table  | Example |
| ---------- |:------:| ------- |
| hello ther |hey yaaa| $10     |
| what uppp  | people | $20     |
@endcomponent
@component('mail::subcopy')
This is  a subcopy
@endcomponent
Thanks,
{{ config('app.name') }}
@endcomponent

