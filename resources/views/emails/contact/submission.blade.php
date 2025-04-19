@component('mail::message')
# New Contact Form Submission

You have received a new contact form submission with the following details:

**Name:** {{ $contactData['name'] }}  
**Email:** {{ $contactData['email'] }}  
**Phone:** {{ $contactData['phone'] }}

**Message:**  
{{ $contactData['message'] }}

@component('mail::button', ['url' => config('app.url')])
View in Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 