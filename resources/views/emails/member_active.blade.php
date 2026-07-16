@extends('emails.layouts.master')

@section('title', 'Your account is active')
@section('preheader', 'Good news — your membership account is now active.')
@section('heading', 'Your account is now active')

@section('content')
    <p style="margin:0 0 16px 0;">
        Hello {{ ucfirst($user->first_name) }},
    </p>

    <p style="margin:0 0 16px 0;">
        Good news — your membership account has been activated. You now have full access to your
        lectures, live sessions and member resources.
    </p>

    @include('emails.partials.button', ['url' => url('/auth'), 'label' => 'Sign In to Your Account'])

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0; background-color:#f0fdf4; border-left:4px solid #10b981; border-radius:4px;">
        <tr>
            <td style="padding:14px 16px; font-size:14px; color:#065f46;">
                <strong>Security tip:</strong> if an account password was issued to you, please change it
                from your profile settings the first time you sign in.
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0 0;">
        Here's to your health,<br>
        <strong>The Institute for Living Longer Team</strong>
    </p>
@endsection
