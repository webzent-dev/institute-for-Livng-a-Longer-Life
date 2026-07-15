<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Membership Renewal Reminder</title>
</head>
<body>
    <h2>Hello {{ $user->first_name }},</h2>

    @if($daysLeft <= 0)
        <p>Your <strong>{{ $user->plan_name }}</strong> membership expired on
            <strong>{{ $expiryDate->format('M j, Y') }}</strong>.</p>
        <p>Renew now to restore access to your member benefits, video library and member-exclusive discounts.</p>
    @else
        <p>This is a friendly reminder that your <strong>{{ $user->plan_name }}</strong> membership will expire on
            <strong>{{ $expiryDate->format('M j, Y') }}</strong>
            — that's in {{ $daysLeft }} {{ \Illuminate\Support\Str::plural('day', $daysLeft) }}.</p>
        <p>Renew now to keep your benefits without interruption. When you renew early, the new period is added
            on top of your remaining days, so you never lose any time.</p>
    @endif

    <p>
        <a href="{{ route('member.subscription') }}"
           style="display:inline-block;padding:10px 18px;background:#16a34a;color:#ffffff;text-decoration:none;border-radius:6px;">
            Renew Membership
        </a>
    </p>

    <p style="font-size:13px;color:#666;">
        If the button above doesn't work, sign in to your account and open
        <a href="{{ route('member.subscription') }}">My Subscription</a> to renew.
    </p>

    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
