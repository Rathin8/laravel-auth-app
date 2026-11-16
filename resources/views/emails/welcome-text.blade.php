Welcome, {{ $user->name }}!

Thank you for registering your profile with {{ config('app.name', 'Laravel') }}. Your account is ready!

ACCOUNT DETAILS:
- Name: {{ $user->name }}
- Email: {{ $user->email }}
@if($sentAt)
- Sent Date & Time: {{ $sentAt->timezone(config('app.timezone', 'Asia/Kolkata'))->toDayDateTimeString() }} (IST)
@endif
- Account Status: Active

Go to your dashboard:
{{ route('home') }}

If you did not register for this account, please ignore this email or contact support.

Thanks,
The {{ config('app.name', 'Laravel') }} Team
