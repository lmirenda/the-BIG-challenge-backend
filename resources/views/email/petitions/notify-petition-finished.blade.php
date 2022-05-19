@component('mail::message')
# Introduction

{{$user['name']}} your petition has been responded.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
