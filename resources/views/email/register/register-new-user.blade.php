@component('mail::message')
# Introduction

{{$user['name']}} has registered. 

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
