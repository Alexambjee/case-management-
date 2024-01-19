@component('mail::message')

<br>
{{ $maildata['subject'] }}
<br>
<br>
Dear, Taxpayer, <br>
<br>
{{ $maildata['body'] }}
<br>
<br>



Regards,<br>
<br>
{{ $maildata['username'] }}
<br>
<br>
{{ env('APP_NAME') }}
@endcomponent
