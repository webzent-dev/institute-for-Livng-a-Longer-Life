@extends('emails.layouts.master')

@section('title', 'New order for fulfilment')
@section('preheader', 'Sub-order ' . $subOrder->sub_order_number . ' is ready for you to fulfil.')
@section('heading', 'You have a new order to fulfil')

@section('content')
    @php
        // These come from the mailable as raw JSON or arrays depending on how they were stored.
        $ship = is_string($shippingAddress) ? json_decode($shippingAddress) : (object) (array) $shippingAddress;
        $from = is_string($originAddress)   ? json_decode($originAddress)   : (object) (array) $originAddress;
    @endphp

    <p style="margin:0 0 16px 0;">
        Hello {{ $sellerName }},
    </p>

    <p style="margin:0 0 20px 0;">
        A new order has been placed that includes your products. Please prepare the items below for
        shipment.
    </p>

    {{-- Sub-order meta --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; border:1px solid #e5e7eb; border-radius:8px;">
        <tr>
            <td style="padding:14px 18px; background-color:#f9fafb; border-bottom:1px solid #e5e7eb; font-weight:600; font-size:14px; color:#1f2937;">
                Sub-order {{ $subOrder->sub_order_number }}
            </td>
        </tr>
        <tr>
            <td style="padding:14px 18px; font-size:14px; color:#374151;">
                <strong style="color:#6b7280;">Parent order:</strong> {{ $order->order_number }}<br>
                <strong style="color:#6b7280;">Placed:</strong> {{ $order->created_at->format('F d, Y \a\t g:i A') }}<br>
                <strong style="color:#6b7280;">Status:</strong> {{ ucfirst($subOrder->status) }}<br>
                <strong style="color:#6b7280;">Customer:</strong> {{ $customerName }}
                @if(!empty($subOrder->tracking_number))
                    <br><strong style="color:#6b7280;">Tracking:</strong> {{ $subOrder->tracking_number }}
                    @if(!empty($subOrder->carrier)) ({{ $subOrder->carrier }}) @endif
                @endif
            </td>
        </tr>
    </table>

    {{-- Items --}}
    <h2 style="margin:0 0 10px 0; font-size:16px; color:#1f2937;">Items to fulfil</h2>
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
            @forelse($items as $item)
                <tr>
                    <td align="left"   style="padding:12px; border-bottom:1px solid #e5e7eb; color:#1f2937;">{{ $item->product_name }}</td>
                    <td align="center" style="padding:12px; border-bottom:1px solid #e5e7eb; color:#374151;">{{ $item->quantity }}</td>
                    <td align="right"  style="padding:12px; border-bottom:1px solid #e5e7eb; color:#374151;">${{ number_format($item->price, 2) }}</td>
                    <td align="right"  style="padding:12px; border-bottom:1px solid #e5e7eb; color:#1f2937;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center" style="padding:16px; border-bottom:1px solid #e5e7eb; color:#6b7280;">No items found for this sub-order.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Totals --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; font-size:14px;">
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Subtotal</td>
            <td align="right" style="padding:6px 12px; color:#374151; width:120px;">${{ number_format($subOrder->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td align="right" style="padding:6px 12px; color:#6b7280;">Shipping{{ !empty($subOrder->shipping_method) ? ' (' . ucfirst($subOrder->shipping_method) . ')' : '' }}</td>
            <td align="right" style="padding:6px 12px; color:#374151;">${{ number_format($subOrder->shipping_cost, 2) }}</td>
        </tr>
        <tr>
            <td align="right" style="padding:10px 12px; border-top:2px solid #e5e7eb; font-weight:600; color:#1f2937;">Total</td>
            <td align="right" style="padding:10px 12px; border-top:2px solid #e5e7eb; font-weight:700; color:#065f46; font-size:16px;">${{ number_format($subOrder->total, 2) }}</td>
        </tr>
    </table>

    {{-- Addresses --}}
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px 0; font-size:14px; color:#374151;">
        <tr>
            @if(!empty($ship))
                <td valign="top" style="padding:0 12px 0 0; width:50%;">
                    <div style="font-weight:600; color:#1f2937; margin-bottom:6px;">Ship to</div>
                    {{ $ship->name ?? $customerName }}<br>
                    {{ $ship->address_line_1 ?? $ship->street1 ?? '' }}<br>
                    {{ ($ship->city ?? '') . ', ' . ($ship->state ?? '') . ' ' . ($ship->zip_code ?? $ship->zip ?? '') }}<br>
                    {{ $ship->country ?? '' }}
                </td>
            @endif
            @if(!empty($from))
                <td valign="top" style="padding:0 0 0 12px; width:50%;">
                    <div style="font-weight:600; color:#1f2937; margin-bottom:6px;">Ship from</div>
                    {{ $from->name ?? $sellerName }}<br>
                    {{ $from->address_line_1 ?? $from->street1 ?? '' }}<br>
                    {{ ($from->city ?? '') . ', ' . ($from->state ?? '') . ' ' . ($from->zip_code ?? $from->zip ?? '') }}<br>
                    {{ $from->country ?? '' }}
                </td>
            @endif
        </tr>
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 8px 0; background-color:#f0fdf4; border-left:4px solid #10b981; border-radius:4px;">
        <tr>
            <td style="padding:14px 16px; font-size:14px; color:#065f46;">
                <strong>Next steps:</strong> print your shipping label from the dashboard, pack the items and
                mark the sub-order as shipped so the customer is notified.
            </td>
        </tr>
    </table>

    @include('emails.partials.button', ['url' => route('collaborator.sub-order-details', $subOrder->id), 'label' => 'Open Sub-Order'])

    <p style="margin:16px 0 0 0;">
        Thank you,<br>
        <strong>The Institute for Living Longer Team</strong>
    </p>
@endsection
