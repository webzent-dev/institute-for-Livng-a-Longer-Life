<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vital Boost Renewal Reminder</title>
</head>
<body>
    <h2>Hello,</h2>

    @if($daysLeft <= 0)
        <p>Your <strong>{{ $subscription->product_name ?? 'Vital Boost' }}</strong>
            ({{ ucfirst($subscription->plan) }}) subscription is due for renewal
            @if($renewalDate)(was scheduled for <strong>{{ $renewalDate->format('M j, Y') }}</strong>)@endif.</p>
        <p>Renew now to keep your supply going without interruption.</p>
    @else
        <p>This is a friendly reminder that your <strong>{{ $subscription->product_name ?? 'Vital Boost' }}</strong>
            ({{ ucfirst($subscription->plan) }}) subscription renews on
            <strong>{{ $renewalDate ? $renewalDate->format('M j, Y') : '' }}</strong>
            — that's in {{ $daysLeft }} {{ \Illuminate\Support\Str::plural('day', $daysLeft) }}.</p>
        @if(strtolower($subscription->plan) === 'yearly')
            <p>As a yearly subscriber you continue to enjoy <strong>free shipping</strong> on your renewal.</p>
        @endif
    @endif

    <p>
        <a href="{{ url('/vital-boost') }}"
           style="display:inline-block;padding:10px 18px;background:#16a34a;color:#ffffff;text-decoration:none;border-radius:6px;">
            Renew Vital Boost
        </a>
    </p>

    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
