<meta charset="UTF-8">
    <title>New Order - Your Product Sold</title>



<table width="100%" cellpadding="0" cellspacing="0" style="padding:20px; background:#f4f6f8;">
<tbody><tr>
<td align="center">

    <!-- Container -->
    <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

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

                <h3 style="margin-top:0;">Hello {{ $collaboratorName }},</h3>

                <p>
                    Good news! 🎉 One of your products has been ordered.
                </p>

                <!-- Order Info -->
                <h3>Order Info</h3>
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
                </tbody></table>

                <!-- Collaborator Products Only -->
                <h3>Your Products in this Order</h3>
                
                        @forelse($orderItems as $item)
                            @if(in_array($item->product_id, $collaboratorProductIds))
                                
                            @endif
                        @empty
                            
                        @endforelse
                    <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse; border:1px solid #ddd;">
                    <thead>
                        <tr style="background:#f2f2f2;">
                            <th align="left" style="border:1px solid #ddd;">Product</th>
                            <th align="center" style="border:1px solid #ddd;">Qty</th>
                            <th align="right" style="border:1px solid #ddd;">Price</th>
                            <th align="right" style="border:1px solid #ddd;">Total</th>
                        </tr>
                    </thead>
                    <tbody><tr>
                                    <td style="border:1px solid #ddd;">{{ $item->product_name }}</td>
                                    <td align="center" style="border:1px solid #ddd;">{{ $item->quantity }}</td>
                                    <td align="right" style="border:1px solid #ddd;">${{ number_format($item->price, 2) }}</td>
                                    <td align="right" style="border:1px solid #ddd;">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr><tr>
                                <td colspan="4" class="p-4 text-center text-gray-500">No items found for this order.</td>
                            </tr></tbody>
                </table>

                <!-- Earnings (Optional) -->
                <table width="100%" cellpadding="6" cellspacing="0" style="margin-top:15px;">
                    <tbody><tr>
                        <td align="right"><strong>Your Earnings:</strong></td>
                        <td align="right">
                            <strong>${{ number_format($order->subtotal, 2) }}</strong>
                        </td>
                    </tr>
                </tbody></table>

                <h3>Next Steps</h3>
                <p>
                    Please prepare your product/service for fulfillment. You may be contacted if further action is required.
                </p>

                <!-- CTA Button -->
                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
                    <tbody><tr>
                        <td align="center">
                            <a href="{{ url('/collaborator/orders') }}" style="background:#2c7be5; color:#fff; padding:12px 20px; text-decoration:none; border-radius:5px; display:inline-block;">
                               View Order
                            </a>
                        </td>
                    </tr>
                </tbody></table>

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background:#f2f2f2; padding:15px; text-align:center; font-size:12px; color:#777;">
                {{ config('app.name') }} • Collaborator Notification
            </td>
        </tr>

    </tbody></table>

</td>
</tr>
</tbody></table>