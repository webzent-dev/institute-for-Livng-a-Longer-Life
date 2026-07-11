<div style="text-align: center;">
    <h2 style="color: #333;">Welcome to the Institute for Living a Longer Life!</h2>
    <p style="font-size:16px;color:#555;">
        Dear {{ $order->first_name }},
    </p>
    <p style="font-size:16px;color:#555;">
        We are excited to inform you that your order with ID <strong>{{ $order->order_number }}</strong> has been
        updated to the status: <strong>{{ $order->status }}</strong>.
    </p>

    @if ($subOrder)
        @if ($subOrder->tracking_number)
            <p style="font-size:16px;color:#555;">
                <strong>Tracking number </strong>: <strong>{{ $subOrder->tracking_number }}</strong>
            </p>
        @endif
    @endif

    <p style="font-size:16px;color:#555;">
        Best regards,<br>
        Institute for Living a Longer Life Team
    </p>
</div>
