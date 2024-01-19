@component('mail::message')
Dear, Taxpayer, <br>
<br>
{{ $emaildata['message'] }}

Regards,<br>
{{ $emaildata['username'] }}
<br>
{{ $emaildata['useremail'] }}
<br>
@endcomponent

