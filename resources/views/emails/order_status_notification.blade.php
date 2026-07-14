@extends('emails.layouts.master')

@section('title', 'Order update')
@section('preheader', 'Order ' . $order->order_number . ' is now ' . strtolower($order->status) . '.')
@section('heading', 'An update on your order')

@section('content')
    <p style="margin:0 0 16px 0;">
        Hello {{ ucfirst($order->first_name) }},
    </p>

    <p style="margin:0 0 20px 0;">
        Your order <strong>{{ $order->order_number }}</strong> has been updated. Its current status is
        shown below.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; border:1px solid #e5e7eb; border-radius:8px;">
        <tr>
            <td style="padding:18px; text-align:center;">
                <div style="color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:8px;">Current status</div>
                <div style="display:inline-block; padding:8px 18px; background-color:#f0fdf4; color:#065f46; border-radius:999px; font-size:16px; font-weight:600;">
                    {{ ucfirst($order->status) }}
                </div>
            </td>
        </tr>

        @if(!empty($subOrder) && !empty($subOrder->tracking_number))
            <tr>
                <td style="padding:14px 18px; border-top:1px solid #e5e7eb; font-size:14px; color:#374151; text-align:center;">
                    <strong style="color:#6b7280;">Tracking number</strong><br>
                    <span style="font-family:Consolas, monospace; background-color:#f3f4f6; padding:4px 10px; border-radius:4px; display:inline-block; margin-top:4px;">{{ $subOrder->tracking_number }}</span>
                </td>
            </tr>
        @endif
    </table>

    @include('emails.partials.button', ['url' => url('/member/orders'), 'label' => 'View Your Order'])

    <p style="margin:16px 0 0 0; font-size:14px; color:#6b7280;">
        If you have any questions about this order, just reach out to our support team — we are happy to help.
    </p>

    <p style="margin:24px 0 0 0;">
        Kind regards,<br>
        <strong>The Institute for Living Longer Team</strong>
    </p>
@endsection
