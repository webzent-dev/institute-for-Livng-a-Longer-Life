<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f8;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        
        .email-container {
              max-width: 650px;
            max-height: 572px;
            margin: 7px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-y: scroll;
        }
        .header {
            background: #4CAF50;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .order-table th,
        .order-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .order-table th {
            background: #f2f2f2;
            font-weight: bold;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .summary-table td {
            padding: 5px;
            text-align: right;
        }
        .address-block {
            margin: 15px 0;
            line-height: 1.6;
        }
        .footer {
            background: #f2f2f2;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 0;
            }
            .header, .content, .footer {
                padding: 15px;
            }
            .order-table th,
            .order-table td {
                padding: 6px;
                font-size: 14px;
            }
        }
    </style>


    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <a href="{{ config('app.url') }}">
                <img src="https://bikewrapt.com/instituteoflivinglonger/public/assets/logo.png" alt="Company Logo" style="max-width:140px; height:auto; display:block; margin:0 auto 10px;">
            </a>
            <h2 style="margin:0; color:#ffffff;">Order Confirmation</h2>
        </div>
        
        <!-- Content -->
        <div class="content">
            <h3 style="margin-top:0;">Hello {{ ucfirst($order->first_name) }},</h3>
            <p>Your order has been confirmed.</p>
            <!-- Order Info -->
            <table class="order-table">
                <tbody><tr>
                    <td><strong>Order ID:</strong></td>
                    <td>{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <td><strong>Order Date:</strong></td>
                    <td>{{ $order->created_at->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Status:</strong></td>
                    <td>{{ ucfirst($order->status) }}</td>
                </tr>
                <tr>
                    <td><strong>Total Amount:</strong></td>
                    <td>${{ number_format($order->total, 2) }}</td>
                </tr>
            </tbody></table>

            <!-- Order Details -->
            <h3>Order Details</h3>
            
                    @foreach($orderItems as $item)
                    
                    @endforeach
                <table class="order-table">
                <thead>
                    <tr style="background:#f2f2f2;">
                        <th align="left" style="border:1px solid #ddd;">Product</th>
                        <th align="center" style="border:1px solid #ddd;">Quantity</th>
                        <th align="right" style="border:1px solid #ddd;">Price</th>
                    </tr>
                </thead>
                <tbody><tr>
                        <td style="border:1px solid #ddd;">{{ $item->product_name }}</td>
                        <td align="center" style="border:1px solid #ddd;">{{ $item->quantity }}</td>
                        <td align="right" style="border:1px solid #ddd;">${{ number_format($item->price, 2) }}</td>
                    </tr></tbody>
            </table>

            <!--Order Summary in right side-->
            <h3 style="margin-top:20px;">Order Summary</h3>
            <table class="summary-table">
                <tbody><tr>
                    <td align="right"><strong>Subtotal:</strong></td>
                    <td align="right">${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td align="right"><strong>Shipping Method:</strong></td>
                    <td align="right">{{ ucfirst($order->shipping_method) }}</td>
                </tr>
                <tr>
                    <td align="right"><strong>Shipping Cost:</strong></td>
                    <td align="right">${{ number_format($order->shipping_cost, 2) }}</td>
                </tr>
                <tr>
                    <td align="right"><strong>Payment Method:</strong></td>
                    <td align="right">{{ ucfirst($order->payment_method) }}</td>
                </tr>
                <tr>
                    <td align="right"><strong>Total:</strong></td>
                    <td align="right"><strong>${{ number_format($order->total, 2) }}</strong></td>
                </tr>
            </tbody></table>

            @php 
                $shipping_address = json_decode($order->shipping_address);
            @endphp

            @if(!empty($shipping_address))
            <h3 style="margin-top:20px;">Shipping Address</h3>
            <p style="line-height:1.6;">
                {{ $shipping_address->address_line_1 }}<br>
                {{ $shipping_address->city }}, {{ $shipping_address->state }} {{ $shipping_address->zip_code }}<br>
                {{ $shipping_address->country }}
            </p>
            @endif

            @php
                $billing_address = json_decode($order->billing_address);
            @endphp

            @if(!empty($billing_address))
            <h3>Billing Address</h3>
            <p style="line-height:1.6;">
                {{ $billing_address->address_line_1 }}<br>
                {{ $billing_address->city }}, {{ $billing_address->state }} {{ $billing_address->zip_code }}<br>
                {{ $billing_address->country }}
            </p>
            @endif

            <h3>What happens next?</h3>
            <p>
                We will process your order and notify you once it has been shipped.
            </p>

            <h3>Questions?</h3>
            <p>
                Contact our support team if you need help.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            Thank you,<br>
            <strong>{{ config('app.name') }}</strong>
        </div>
    </div>