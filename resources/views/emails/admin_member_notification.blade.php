@extends('emails.layouts.master')

@section('title', 'New member registration')
@section('preheader', 'A new member has registered and is awaiting review.')
@section('heading', 'New member registration')

@section('content')
    <p style="margin:0 0 16px 0;">
        Hello Administrator,
    </p>

    <p style="margin:0 0 16px 0;">
        A new member has just registered on the website. Their details are below.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0; border:1px solid #e5e7eb; border-radius:8px;">
        <tr>
            <td style="padding:16px 18px; background-color:#f9fafb; border-bottom:1px solid #e5e7eb; font-weight:600; font-size:14px; color:#1f2937;">
                Member details
            </td>
        </tr>
        <tr>
            <td style="padding:16px 18px; font-size:14px; color:#374151;">
                @if(!empty($user->first_name))
                    <strong style="color:#6b7280;">Name</strong><br>
                    {{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name ?? '') }}
                    <br><br>
                @endif
                <strong style="color:#6b7280;">Email</strong><br>
                {{ $user->email }}
                <br><br>
                <strong style="color:#6b7280;">Registered</strong><br>
                {{ optional($user->created_at)->format('F d, Y \a\t g:i A') ?? now()->format('F d, Y \a\t g:i A') }}
            </td>
        </tr>
    </table>

    <p style="margin:0 0 8px 0;">
        Please review the registration in the admin panel and activate the account when you are ready.
    </p>

    @include('emails.partials.button', ['url' => route('admin.users.index'), 'label' => 'Review in Admin Panel'])
@endsection
