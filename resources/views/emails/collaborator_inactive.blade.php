@extends('emails.layouts.master')

@section('title', 'Your collaborator account has been deactivated')
@section('preheader', 'An update about the status of your collaborator account.')
@section('heading', 'Your collaborator account has been deactivated')

@section('content')
    <p style="margin:0 0 16px 0;">
        Hello {{ ucfirst($user->first_name) }},
    </p>

    <p style="margin:0 0 16px 0;">
        We are writing to let you know that your collaborator account has been deactivated by our
        administration team. While it is inactive you will not be able to sign in, and your store and
        courses will not be visible to members.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0; background-color:#fffbeb; border-left:4px solid #f59e0b; border-radius:4px;">
        <tr>
            <td style="padding:14px 16px; font-size:14px; color:#92400e;">
                If you believe this was done in error, or you would like your account reinstated,
                please get in touch with our team and we will be glad to help.
            </td>
        </tr>
    </table>

    @include('emails.partials.button', ['url' => url('/contact'), 'label' => 'Contact Our Team'])

    <p style="margin:24px 0 0 0;">
        Kind regards,<br>
        <strong>The Institute for Living Longer Team</strong>
    </p>
@endsection
