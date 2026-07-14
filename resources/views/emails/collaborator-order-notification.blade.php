@extends('emails.layouts.master')

@section('title', 'One of your products has sold')
@section('preheader', 'Order ' . $order->order_number . ' includes one of your products.')
@section('heading', 'You have a new order')

@section('content')
    @php
        // Only this collaborator's lines belong in their copy of the email.
        $myItems = collect($orderItems)->filter(
            fn ($item) => in_array($item->product_id, $collaboratorProductIds)
        );
        $myEarnings = $myItems->sum(fn ($item) => $item->price * $item->quantity);
    @endphp

    <p style="margin:0 0 16px 0;">
        Hello {{ ucfirst($collaboratorName) }},
    </p>

    <p style="margin:0 0 20px 0;">
        Good news — a member has just purchased from your store. Here are the details of your part of
        this order.
    </p>

    {{-- Order meta --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; border:1px solid #e5e7eb; border-radius:8px;">
        <tr>
            <td style="padding:14px 18px; background-color:#f9fafb; border-bottom:1px solid #e5e7eb; font-weight:600; font-size:14px; color:#1f2937;">
                Order {{ $order->order_number }}
            </td>
        </tr>
        <tr>
            <td style="padding:14px 18px; font-size:14px; color:#374151;">
                <strong style="color:#6b7280;">Date:</strong> {{ $order->created_at->format('F d, Y \a\t g:i A') }}<br>
                <strong style="color:#6b7280;">Status:</strong> {{ ucfirst($order->status) }}<br>
                <strong style="color:#6b7280;">Customer:</strong> {{ $order->first_name }} {{ $order->last_name }}
            </td>
        </tr>
    </table>

    {{-- The collaborator's items only --}}
    <h2 style="margin:0 0 10px 0; font-size:16px; color:#1f2937;">Your products in this order</h2>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; margin:0 0 16px 0; font-size:14px;">
        <thead>
            <tr>
                <th align="left"   style="padding:10px 12px; background-color:#f9fafb; border-bottom:2px solid #e5e7eb; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.04em;">Product</th>
                <th align="center" style="padding:10px 12px; background-color:#f9fafb; border-bottom:2px solid #e5e7eb; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.04em;">Qty</th>
                <th align="right"  style="padding:10px 12px; background-color:#f9fafb; border-bottom:2px solid #e5e7eb; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.04em;">Price</th>
                <th align="right"  style="padding:10px 12px; background-color:#f9fafb; border-bottom:2px solid #e5e7eb; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.04em;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($myItems as $item)
                <tr>
                    <td align="left"   style="padding:12px; border-bottom:1px solid #e5e7eb; color:#1f2937;">{{ $item->product_name }}</td>
                    <td align="center" style="padding:12px; border-bottom:1px solid #e5e7eb; color:#374151;">{{ $item->quantity }}</td>
                    <td align="right"  style="padding:12px; border-bottom:1px solid #e5e7eb; color:#374151;">${{ number_format($item->price, 2) }}</td>
                    <td align="right"  style="padding:12px; border-bottom:1px solid #e5e7eb; color:#1f2937;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center" style="padding:16px; border-bottom:1px solid #e5e7eb; color:#6b7280;">No items found for this order.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; font-size:14px;">
        <tr>
            <td align="right" style="padding:10px 12px; border-top:2px solid #e5e7eb; font-weight:600; color:#1f2937;">Your items total</td>
            <td align="right" style="padding:10px 12px; border-top:2px solid #e5e7eb; font-weight:700; color:#065f46; font-size:16px; width:120px;">${{ number_format($myEarnings, 2) }}</td>
        </tr>
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 8px 0; background-color:#f0fdf4; border-left:4px solid #10b981; border-radius:4px;">
        <tr>
            <td style="padding:14px 16px; font-size:14px; color:#065f46;">
                <strong>Next steps:</strong> please prepare these items for fulfilment and update the order
                in your dashboard once it has been shipped.
            </td>
        </tr>
    </table>

    @include('emails.partials.button', ['url' => route('collaborator.orders'), 'label' => 'View Order in Your Dashboard'])

    <p style="margin:16px 0 0 0;">
        Thank you for being part of our network,<br>
        <strong>The Institute for Living Longer Team</strong>
    </p>
@endsection
