<!DOCTYPE html>
<html>
<head>
    <title>Reset Password muhammad hamza</title>
</head>
<body>
    <p>Hello,</p>
    @if(isset($resetLink))
        <p>You requested a password reset. Click the link below to reset your password:</p>
        <p><a href="{{ $resetLink }}">{{ $resetLink }}</a></p>
    @else
        <p>We received a request to reset your password. However, no reset link was provided.</p>
    @endif
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>
