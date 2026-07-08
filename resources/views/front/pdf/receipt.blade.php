<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
            font-size: 12pt;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .receipt-info {
            margin-bottom: 30px;
        }
        .payment-details {
            background: #f5f5f5;
            padding: 20px;
            border: 1px solid #ddd;
            margin: 20px 0;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
            font-size: 10pt;
            color: #666;
        }
        h1 {
            color: #333;
            font-size: 18pt;
            margin-bottom: 10px;
        }
        h2 {
            color: #555;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            font-size: 14pt;
            margin-top: 20px;
        }
        p {
            margin-bottom: 10px;
        }
        strong {
            font-weight: bold;
        }
        .success-badge {
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Payment Receipt</h1>
        <p><strong>Institute for Living a Longer Life</strong></p>
    </div>

    <div class="receipt-info">
        <h2>Receipt Information</h2>
        <p><strong>Receipt Number:</strong> {{ $payment->transaction_id }}</p>
        <p><strong>Date:</strong> {{ $receiptDate }}</p>
        <p><strong>Status:</strong> <span class="success-badge">{{ ucfirst($payment->status) }}</span></p>
    </div>

    <div class="payment-details">
        <h2>Payment Details</h2>
        <p><strong>Description:</strong> {{ $payment->description ?? 'Membership Payment' }}</p>
        <p><strong>Amount:</strong> ${{ $payment->amount }}</p>
        <p><strong>Payment Method:</strong> {{ $cardDetails->brand ?? 'Card' }} •••• {{ $cardDetails->last4 ?? '****' }}</p>
        <p><strong>Payment For:</strong> {{ $payment->payment_for ?? 'Membership' }}</p>
    </div>

    <div class="payment-details">
        <h2>Billing Information</h2>
        <p><strong>Name:</strong> {{ $user->first_name . ' ' . $user->last_name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        @if ($user->phone)
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
        @endif
    </div>

    <div class="footer">
        <p><strong>Generated on:</strong> {{ $generatedAt }}</p>
        <p><em>This is an official receipt from Institute for Living a Longer Life</em></p>
        <p><em>Thank you for your payment!</em></p>
    </div>
</body>
</html>
