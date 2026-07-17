@extends('emails.layouts.master')

@section('title', 'Order confirmation')
@section('preheader', 'Thank you for your order ' . $order->order_number . ' — here are the details.')
@section('heading', 'Thank you for your order')

@section('content')
    @php
        $shipping_address = json_decode($order->shipping_address);
        $billing_address  = json_decode($order->billing_address);
    @endphp

    <p style="margin:0 0 16px 0;">
        Hello {{ ucfirst($order->first_name) }},
    </p>

    <p style="margin:0 0 20px 0;">
        We have received your order and it is now confirmed. Here is a summary for your records.
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
                <strong style="color:#6b7280;">Order date:</strong> {{ $order->created_at->format('F d, Y') }}<br>
                <strong style="color:#6b7280;">Status:</strong> {{ ucfirst($order->status) }}<br>
                <strong style="color:#6b7280;">Payment method:</strong> {{ ucfirst($order->payment_method) }}
            </td>
        </tr>
    </table>

    {{-- Items --}}
    <h2 style="margin:0 0 10px 0; font-size:16px; color:#1f2937;">Items ordered</h2>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; margin:0 0 24px 0; font-size:14px;">
        <thead>
            <tr>
                <th align="left"   style="padding:10px 12px; background-color:#f9fafb; border-bottom:2px solid #e5e7eb; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.04em;">Product</th>
                <th align="center" style="padding:10px 12px; background-color:#f9fafb; border-bottom:2px solid #e5e7eb; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.04em;">Qty</th>
                <th align="right"  style="padding:10px 12px; background-color:#f9fafb; border-bottom:2px solid #e5e7eb; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.04em;">Price</th>
                <th align="right"  style="padding:10px 12px; background-color:#f9fafb; border-bottom:2px solid #e5e7eb; color:#6b7280; font-size:12px; text-transform:uppercase; letter-spacing:0.04em;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orderItems as $item)
                @php $purchaseLabel = \App\Support\CartLine::label($item->purchase_type, $item->subscription_plan); @endphp
                <tr>
                    <td align="left"   style="padding:12px; border-bottom:1px solid #e5e7eb; color:#1f2937;">
                        {{ $item->product_name }}
                        <span style="display:inline-block; margin-top:4px; font-size:12px; color:{{ $item->purchase_type === 'subscription' ? '#0f766e' : '#6b7280' }};">{{ $purchaseLabel }}</span>
                    </td>
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

    {{-- Totals --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; font-size:14px;">
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Subtotal</td>
            <td align="right" style="padding:6px 12px; color:#374151; width:120px;">${{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Shipping ({{ ucfirst($order->shipping_method) }})</td>
            <td align="right" style="padding:6px 12px; color:#374151;">${{ number_format($order->shipping_cost, 2) }}</td>
        </tr>
        @php
            $membershipDiscount = $order->membership_discount ?? 0;
            $subscriptionDiscount = $order->subscription_discount ?? 0;
            $planName = $order->membership_plan_name ?? ($order->user->plan_name ?? null);
        @endphp
        @if($membershipDiscount > 0)
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Membership Discount{{ $planName ? ' ('.$planName.')' : '' }}</td>
            <td align="right" style="padding:6px 12px; color:#059669;">- ${{ number_format($membershipDiscount, 2) }}</td>
        </tr>
        @endif
        @if($subscriptionDiscount > 0)
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Subscription Discount</td>
            <td align="right" style="padding:6px 12px; color:#059669;">- ${{ number_format($subscriptionDiscount, 2) }}</td>
        </tr>
        @endif
        @if($membershipDiscount <= 0 && $subscriptionDiscount <= 0 && ($order->discount ?? 0) > 0)
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Discount</td>
            <td align="right" style="padding:6px 12px; color:#059669;">- ${{ number_format($order->discount, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td align="right" style="padding:10px 12px; border-top:2px solid #e5e7eb; font-weight:600; color:#1f2937;">Total</td>
            <td align="right" style="padding:10px 12px; border-top:2px solid #e5e7eb; font-weight:700; color:#065f46; font-size:16px;">${{ number_format($order->total, 2) }}</td>
        </tr>
    </table>

    {{-- Addresses --}}
    @if(!empty($shipping_address) || !empty($billing_address))
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; font-size:14px; color:#374151;">
            <tr>
                @if(!empty($shipping_address))
                    <td valign="top" style="padding:0 12px 0 0; width:50%;">
                        <div style="font-weight:600; color:#1f2937; margin-bottom:6px;">Shipping address</div>
                        {{ $shipping_address->address_line_1 }}<br>
                        {{ $shipping_address->city }}, {{ $shipping_address->state }} {{ $shipping_address->zip_code }}<br>
                        {{ $shipping_address->country }}
                    </td>
                @endif
                @if(!empty($billing_address))
                    <td valign="top" style="padding:0 0 0 12px; width:50%;">
                        <div style="font-weight:600; color:#1f2937; margin-bottom:6px;">Billing address</div>
                        {{ $billing_address->address_line_1 }}<br>
                        {{ $billing_address->city }}, {{ $billing_address->state }} {{ $billing_address->zip_code }}<br>
                        {{ $billing_address->country }}
                    </td>
                @endif
            </tr>
        </table>
    @endif

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 8px 0; background-color:#f0fdf4; border-left:4px solid #10b981; border-radius:4px;">
        <tr>
            <td style="padding:14px 16px; font-size:14px; color:#065f46;">
                <strong>What happens next?</strong><br>
                We are preparing your order now. You will receive another email with tracking details as
                soon as it ships.
            </td>
        </tr>
    </table>

    @if($order->belongsToMember())
        @include('emails.partials.button', ['url' => url('/member/orders'), 'label' => 'View Your Orders'])
    @endif

    <p style="margin:16px 0 0 0;">
        Thank you for shopping with us,<br>
        <strong>The Institute for Living Longer Team</strong>
    </p>
@endsection
