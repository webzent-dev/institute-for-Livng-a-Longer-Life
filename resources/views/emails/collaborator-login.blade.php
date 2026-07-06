<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Details</title>
</head>
<body>
    <h2>Hello {{ $user->first_name }},</h2>
    <p>Your collaborator account has been created.</p>
    <p><strong>Login URL:</strong><br>
        <a href="{{ url('/collaborator') }}">{{ url('/collaborator') }}</a>
    </p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    @if(!empty($resetUrl))
    <p>To set your password and access your account, click the link below:</p>
    <p><a href="{{ $resetUrl }}">Set Your Password</a></p>
    @elseif(!empty($password))
    <p><strong>Password:</strong> {{ $password }}</p>
    @endif
    <p><strong>Note:</strong> Your account is currently inactive. Please wait for the administrator to activate it. Once you log in for the first time, we recommend changing your password.</p>
    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>