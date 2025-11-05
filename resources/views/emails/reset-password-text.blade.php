Hello {{ $user->name }},

You are receiving this email because we received a password reset request for your account. Click the link below to reset your password:

{{ $url }}

This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.

If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:

{{ $url }}

Need help? Contact our support team.

© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.