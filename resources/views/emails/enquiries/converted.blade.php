@component('mail::message')
# Enquiry Converted to Client

An enquiry has been successfully converted to a client:

**Enquiry Details:**
- Client Name: {{ $enquiry->name }}
- Email: {{ $enquiry->email }}
- Converted By: {{ $convertedBy->name }}
- Conversion Date: {{ now()->format('d M Y') }}

@component('mail::button', ['url' => route('enquiries.show', $enquiry->id)])
View Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 