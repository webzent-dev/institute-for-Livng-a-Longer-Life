<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Details</title>
</head>
<body>
    <h2>Hello {{ $user->first_name }},</h2>
    <p>Your account has been created successfully.</p>
    <p>
        <strong>Login URL:</strong><br>
        <a href="{{ url('/auth') }}">{{ url('/auth') }}</a>
    </p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    @if(!empty($resetUrl))
        {{-- Account was created for the member (admin panel / guest checkout), so they
             have no password yet and must set one before they can sign in. --}}
        <p>To set your password and access your account, click the link below:</p>
        <p><a href="{{ $resetUrl }}">Set Your Password</a></p>
        <p><strong>Note:</strong> Your account is currently inactive. Please wait for the administrator to activate it.</p>
    @else
        {{-- Member signed up on the membership page and chose their own password;
             their account is activated as soon as payment completes. --}}
        <p><strong>Password:</strong> the password you chose when you registered.</p>
        <p>Once your payment is complete, you can sign in straight away with the email and password above.</p>
        <p>Please keep your password safe — we never store or send passwords in plain text. If you ever forget it, you can reset it from the login page.</p>
    @endif
    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>