@component('mail::message')
# Reset Your Password

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

This password reset link will expire in 15 minutes.

If you did not request a password reset, no further action is required.

Thanks,<br>
Your App Name
@endcomponent