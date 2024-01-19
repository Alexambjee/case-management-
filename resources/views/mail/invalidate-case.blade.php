@component('mail::message')
Dear, Taxpayer, <br>
<br>
{{ $emaildata['message'] }}

Regards,<br>
{{ $emaildata['username'] }}
<br>
<br>
{{ env('APP_NAME') }}
@endcomponent

