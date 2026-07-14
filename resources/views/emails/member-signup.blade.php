@extends('emails.layouts.master')

@section('title', 'Your membership account')
@section('preheader', 'Your account has been created — here is how to sign in.')
@section('heading', 'Welcome, ' . ucfirst($user->first_name) . '!')

@section('content')
    <p style="margin:0 0 16px 0;">
        Thank you for joining the Institute for Living Longer. Your membership account has been created
        and is ready for you.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0; border:1px solid #e5e7eb; border-radius:8px;">
        <tr>
            <td style="padding:16px 18px; background-color:#f9fafb; border-bottom:1px solid #e5e7eb; font-weight:600; font-size:14px; color:#1f2937;">
                Your account details
            </td>
        </tr>
        <tr>
            <td style="padding:16px 18px; font-size:14px; color:#374151;">
                <strong style="color:#6b7280;">Email</strong><br>
                {{ $user->email }}
                <br><br>
                <strong style="color:#6b7280;">Sign-in page</strong><br>
                <a href="{{ url('/auth') }}" style="color:#065f46;">{{ url('/auth') }}</a>
            </td>
        </tr>
    </table>

    @if(!empty($resetUrl))
        {{-- Account was created for the member (admin panel / guest checkout), so they
             have no password yet and must set one before they can sign in. --}}
        <p style="margin:0 0 8px 0;">
            To finish setting up your account, please choose a password using the secure link below.
        </p>

        @include('emails.partials.button', ['url' => $resetUrl, 'label' => 'Set Your Password'])

        <p style="margin:0 0 16px 0; font-size:13px; color:#6b7280;">
            If the button does not work, copy and paste this link into your browser:<br>
            <a href="{{ $resetUrl }}" style="color:#065f46; word-break:break-all;">{{ $resetUrl }}</a>
        </p>

        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0; background-color:#fffbeb; border-left:4px solid #f59e0b; border-radius:4px;">
            <tr>
                <td style="padding:14px 16px; font-size:14px; color:#92400e;">
                    <strong>Please note:</strong> your account is not active yet. Our team will activate it shortly,
                    and we will email you as soon as it is ready.
                </td>
            </tr>
        </table>
    @else
        {{-- Member signed up on the membership page and chose their own password;
             their account is activated as soon as payment completes. --}}
        <p style="margin:0 0 16px 0;">
            Sign in with the email address above and the password you chose during registration.
            As soon as your payment is confirmed, you will have full access to your membership.
        </p>

        @include('emails.partials.button', ['url' => url('/auth'), 'label' => 'Sign In to Your Account'])

        <p style="margin:0 0 16px 0; font-size:13px; color:#6b7280;">
            For your security we never store or send passwords in plain text. If you ever forget yours,
            you can reset it from the sign-in page at any time.
        </p>
    @endif

    <p style="margin:24px 0 0 0;">
        We are glad to have you with us.<br>
        <strong>The Institute for Living Longer Team</strong>
    </p>
@endsection
