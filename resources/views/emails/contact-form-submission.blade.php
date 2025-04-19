@component('mail::message')
# New Contact Form Submission

You have received a new contact form submission from {{ $data['name'] }}.

**Name:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  
**Subject:** {{ $data['subject'] }}

**Message:**  
{{ $data['message'] }}

@component('mail::button', ['url' => config('app.url')])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 