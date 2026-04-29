<meta charset="UTF-8">
    <title>New Order Received</title>



<table width="100%" cellpadding="0" cellspacing="0" style="padding:20px; background:#f4f6f8;">
<tbody><tr>
<td align="center">

    <!-- Container -->
    <table width="650" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

        <!-- Header -->
        <tbody><tr>
    <td style="background:#4CAF50; padding:20px; text-align:center;">
        
        <img src="https://bikewrapt.com/assets/logo.png" 
             alt="Logo" 
             width="130"
             style="display:block; margin:0 auto 10px auto;">

        <h2 style="color:#fff; margin:0;">New Order Received</h2>
    </td>
</tr>

        <!-- Body -->
        <tr>
            <td style="padding:20px; color:#333;">

                <p style="font-size:16px;">
                    A new order has been placed on your website.
                </p>

                <!-- Order Info -->
                <h3>Order Summary</h3>
                <table width="100%" cellpadding="6" cellspacing="0" style="margin-bottom:15px;">
                    <tbody><tr>
                        <td><strong>Order ID:</strong></td>
                        <td>{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td>{{ $order->created_at->format('F d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>{{ ucfirst($order->status) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total:</strong></td>
                        <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                </tbody></table>

                <!-- Customer Info -->
                <h3>Customer Details</h3>
                <table width="100%" cellpadding="6" cellspacing="0" style="margin-bottom:15px;">
                    <tbody><tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td>{{ $order->phone }}</td>
                    </tr>
                </tbody></table>

                <!-- Products -->
                <h3>Order Items</h3>
                
                        @foreach($orderItems as $item)
                        
                        @endforeach
                    <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse; border:1px solid #ddd;">
                    <thead>
                        <tr style="background:#f2f2f2;">
                            <th align="left" style="border:1px solid #ddd;">Product</th>
                            <th align="center" style="border:1px solid #ddd;">Qty</th>
                            <th align="right" style="border:1px solid #ddd;">Price</th>
                            <th align="right" style="border:1px solid #ddd;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody><tr>
                            <td style="border:1px solid #ddd;">{{ $item->product_name }}</td>
                            <td align="center" style="border:1px solid #ddd;">{{ $item->quantity }}</td>
                            <td align="right" style="border:1px solid #ddd;">${{ number_format($item->price, 2) }}</td>
                            <td align="right" style="border:1px solid #ddd;">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr></tbody>
                </table>

                <!-- Totals -->
                <table width="100%" cellpadding="6" cellspacing="0" style="margin-top:15px;">
                    <tbody><tr>
                        <td align="right"><strong>Subtotal:</strong></td>
                        <td align="right">${{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td align="right"><strong>Shipping:</strong></td>
                        <td align="right">${{ number_format($order->shipping_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td align="right"><strong>Tax:</strong></td>
                        <td align="right">${{ number_format($order->tax, 2) }}</td>
                    </tr>
                    <tr>
                        <td align="right"><strong>Discount:</strong></td>
                        <td align="right">-${{ number_format($order->discount, 2) }}</td>
                    </tr>
                    <tr>
                        <td align="right"><strong>Total:</strong></td>
                        <td align="right"><strong>${{ number_format($order->total ?? 0, 2) }}</strong></td>
                    </tr>
                </tbody></table>

                @php 
                    $shipping = json_decode($order->shipping_address);
                    $billing = json_decode($order->billing_address);
                @endphp

                <!-- Addresses -->
                
                        @if(!empty($shipping))
                    <table width="100%" cellpadding="10" cellspacing="0" style="margin-top:20px;">
                    <tbody><tr><td width="50%" valign="top">
                            <h4>Shipping Address</h4>
                            {{ $shipping->address_line_1 ?? '' }}<br>
                            {{ ($shipping->city ?? '') . ', ' . ($shipping->state ?? '') . ' ' . ($shipping->zip_code ?? '') }}<br>
                            {{ $shipping->country ?? '' }}
                        </td></tr>
                </tbody></table>
                        @endif

                        @if(!empty($billing))
                    <table width="100%" cellpadding="10" cellspacing="0" style="margin-top:20px;">
                    <tbody><tr><td width="50%" valign="top">
                            <h4>Billing Address</h4>
                            {{ $billing->address_line_1 ?? '' }}<br>
                            {{ ($billing->city ?? '') . ', ' . ($billing->state ?? '') . ' ' . ($billing->zip_code ?? '') }}<br>
                            {{ $billing->country ?? '' }}
                        </td></tr>
                </tbody></table>
                        @endif
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background:#f2f2f2; padding:15px; text-align:center; font-size:12px; color:#777;">
                Admin Notification • {{ config('app.name') }}
            </td>
        </tr>
    </tbody></table>
</td>
</tr>
</tbody></table>