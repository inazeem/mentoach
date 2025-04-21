@component('mail::message')
# New Enquiry Assigned

Hello {{ $assignedTo->name }},

An enquiry has been assigned to you:

**Enquiry Details:**
- Subject: {{ $enquiry->subject }}
- From: {{ $enquiry->name }}
- Email: {{ $enquiry->email }}
- Status: {{ $enquiry->status }}

@component('mail::button', ['url' => route('enquiries.show', $enquiry->id)])
View Enquiry
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 