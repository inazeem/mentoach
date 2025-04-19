@component('mail::message')
# New Enquiry Received

A new enquiry has been received from **{{ $enquiry->name }}**.

**Details:**
- Name: {{ $enquiry->name }}
- Email: {{ $enquiry->email }}
- Phone: {{ $enquiry->phone }}
- Service: {{ $enquiry->service }}
- Subject: {{ $enquiry->subject }}
- Preferred Date: {{ $enquiry->preferred_date }}

**Message:**
{{ $enquiry->message }}

@component('mail::button', ['url' => $url])
View Enquiry
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 