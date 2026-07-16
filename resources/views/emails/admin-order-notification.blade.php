@extends('emails.layouts.master')

@section('title', 'New order received')
@section('preheader', 'Order ' . $order->order_number . ' has been placed.')
@section('heading', 'New order received')

@section('content')
    @php
        $shipping = json_decode($order->shipping_address);
        $billing  = json_decode($order->billing_address);
    @endphp

    <p style="margin:0 0 20px 0;">
        A new order has been placed on the website. The details are below.
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
                <strong style="color:#6b7280;">Total:</strong> <strong>${{ number_format($order->total ?? 0, 2) }}</strong>
            </td>
        </tr>
    </table>

    {{-- Customer --}}
    <h2 style="margin:0 0 10px 0; font-size:16px; color:#1f2937;">Customer</h2>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; font-size:14px; color:#374151;">
        <tr>
            <td style="padding:4px 0; width:90px; color:#6b7280;">Name</td>
            <td style="padding:4px 0;">{{ $order->first_name }} {{ $order->last_name }}</td>
        </tr>
        <tr>
            <td style="padding:4px 0; color:#6b7280;">Email</td>
            <td style="padding:4px 0;"><a href="mailto:{{ $order->email }}" style="color:#065f46; text-decoration:none;">{{ $order->email }}</a></td>
        </tr>
        <tr>
            <td style="padding:4px 0; color:#6b7280;">Phone</td>
            <td style="padding:4px 0;">{{ $order->phone }}</td>
        </tr>
    </table>

    {{-- Items --}}
    <h2 style="margin:0 0 10px 0; font-size:16px; color:#1f2937;">Items</h2>
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

    {{-- Totals --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; font-size:14px;">
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Subtotal</td>
            <td align="right" style="padding:6px 12px; color:#374151; width:120px;">${{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Shipping</td>
            <td align="right" style="padding:6px 12px; color:#374151;">${{ number_format($order->shipping_cost, 2) }}</td>
        </tr>
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Tax</td>
            <td align="right" style="padding:6px 12px; color:#374151;">${{ number_format($order->tax, 2) }}</td>
        </tr>
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Discount</td>
            <td align="right" style="padding:6px 12px; color:#374151;">-${{ number_format($order->discount, 2) }}</td>
        </tr>
        <tr>
            <td align="right" style="padding:10px 12px; border-top:2px solid #e5e7eb; font-weight:600; color:#1f2937;">Total</td>
            <td align="right" style="padding:10px 12px; border-top:2px solid #e5e7eb; font-weight:700; color:#065f46; font-size:16px;">${{ number_format($order->total ?? 0, 2) }}</td>
        </tr>
    </table>

    {{-- Addresses --}}
    @if(!empty($shipping) || !empty($billing))
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; font-size:14px; color:#374151;">
            <tr>
                @if(!empty($shipping))
                    <td valign="top" style="padding:0 12px 0 0; width:50%;">
                        <div style="font-weight:600; color:#1f2937; margin-bottom:6px;">Shipping address</div>
                        {{ $shipping->address_line_1 ?? '' }}<br>
                        {{ ($shipping->city ?? '') . ', ' . ($shipping->state ?? '') . ' ' . ($shipping->zip_code ?? '') }}<br>
                        {{ $shipping->country ?? '' }}
                    </td>
                @endif
                @if(!empty($billing))
                    <td valign="top" style="padding:0 0 0 12px; width:50%;">
                        <div style="font-weight:600; color:#1f2937; margin-bottom:6px;">Billing address</div>
                        {{ $billing->address_line_1 ?? '' }}<br>
                        {{ ($billing->city ?? '') . ', ' . ($billing->state ?? '') . ' ' . ($billing->zip_code ?? '') }}<br>
                        {{ $billing->country ?? '' }}
                    </td>
                @endif
            </tr>
        </table>
    @endif

    @include('emails.partials.button', ['url' => route('admin.orders'), 'label' => 'Manage Order in Admin Panel'])
@endsection
