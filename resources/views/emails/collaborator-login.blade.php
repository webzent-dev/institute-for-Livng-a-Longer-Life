@extends('emails.layouts.master')

@section('title', 'Your collaborator account')
@section('preheader', 'Your collaborator account has been created — here is how to sign in.')
@section('heading', 'Welcome aboard, ' . ucfirst($user->first_name) . '!')

@section('content')
    <p style="margin:0 0 16px 0;">
        Your collaborator account with the Institute for Living Longer has been created. Once it is
        activated you will be able to manage your store, publish courses, and reach our community.
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
                <a href="{{ url('/collaborator') }}" style="color:#065f46;">{{ url('/collaborator') }}</a>

                @if(empty($resetUrl) && !empty($password))
                    <br><br>
                    <strong style="color:#6b7280;">Temporary password</strong><br>
                    <span style="font-family:Consolas, monospace; background-color:#f3f4f6; padding:3px 8px; border-radius:4px;">{{ $password }}</span>
                @endif
            </td>
        </tr>
    </table>

    @if(!empty($resetUrl))
        <p style="margin:0 0 8px 0;">
            To finish setting up your account, please choose a password using the secure link below.
        </p>

        @include('emails.partials.button', ['url' => $resetUrl, 'label' => 'Set Your Password'])

        <p style="margin:0 0 16px 0; font-size:13px; color:#6b7280;">
            If the button does not work, copy and paste this link into your browser:<br>
            <a href="{{ $resetUrl }}" style="color:#065f46; word-break:break-all;">{{ $resetUrl }}</a>
        </p>
    @elseif(!empty($password))
        <p style="margin:0 0 16px 0;">
            Please sign in with the temporary password above and change it straight away from your
            profile settings.
        </p>

        @include('emails.partials.button', ['url' => url('/collaborator'), 'label' => 'Sign In to Your Account'])
    @endif

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0; background-color:#fffbeb; border-left:4px solid #f59e0b; border-radius:4px;">
        <tr>
            <td style="padding:14px 16px; font-size:14px; color:#92400e;">
                <strong>Please note:</strong> your account is not active yet. Our team is reviewing it and
                will email you as soon as it has been approved.
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0 0;">
        We look forward to working with you.<br>
        <strong>The Institute for Living Longer Team</strong>
    </p>
@endsection
