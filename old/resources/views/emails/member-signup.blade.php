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
    <p><strong>Password:</strong> {{ $password }}</p>
    <p><strong>Note:</strong> Your account is currently inactive. Please wait for the administrator to activate it. Once you log in for the first time, we recommend changing your password.</p>
    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>