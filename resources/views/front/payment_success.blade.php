<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - SmartNotes</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #f8fafc; color: #1e293b; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 25px; }
        .receipt-card { background: #ffffff; width: 100%; max-width: 560px; border-radius: 20px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04); overflow: hidden; border: 1px solid #e2e8f0; }
        .success-banner { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; text-align: center; padding: 36px 20px 30px; position: relative; }
        .check-circle { width: 72px; height: 72px; background: rgba(255,255,255,0.2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; border: 3px solid rgba(255,255,255,0.4); animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .check-circle i { font-size: 36px; color: #ffffff; }
        @keyframes popIn {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .success-title { font-size: 24px; font-weight: 800; margin-bottom: 6px; }
        .success-subtitle { font-size: 14px; opacity: 0.9; }
        .receipt-content { padding: 28px; }
        .order-badge-row { display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px dashed #cbd5e1; margin-bottom: 20px; }
        .badge-ord { font-size: 14px; font-weight: 700; color: #0284c7; background: #e0f2fe; padding: 5px 12px; border-radius: 8px; }
        .badge-date { font-size: 13px; color: #64748b; }
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .detail-item { background: #f8fafc; padding: 12px 14px; border-radius: 10px; border: 1px solid #f1f5f9; }
        .detail-label { font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; font-weight: 600; }
        .detail-value { font-size: 14px; font-weight: 700; color: #0f172a; word-break: break-all; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th { text-align: left; font-size: 12px; color: #64748b; padding: 8px 0; border-bottom: 1px solid #e2e8f0; }
        .items-table td { padding: 12px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .total-box { background: #f1f5f9; border-radius: 12px; padding: 16px; margin-bottom: 24px; }
        .total-row { display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 6px; color: #475569; }
        .total-row.grand { font-size: 18px; font-weight: 800; color: #0f172a; margin-top: 8px; padding-top: 8px; border-top: 1px solid #cbd5e1; }
        .shipping-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 12px 14px; font-size: 13px; color: #1e3a8a; margin-bottom: 24px; display: flex; gap: 10px; align-items: flex-start; }
        .btn-group { display: flex; gap: 12px; }
        .btn { flex: 1; padding: 12px; border-radius: 10px; font-size: 14px; font-weight: 700; text-align: center; text-decoration: none; cursor: pointer; border: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; }
        .btn-primary { background: #0284c7; color: #fff; }
        .btn-primary:hover { background: #0369a1; }
        .btn-outline { background: #fff; color: #475569; border: 1px solid #cbd5e1; }
        .btn-outline:hover { background: #f8fafc; }
        @media print {
            body { background: #fff; padding: 0; }
            .receipt-card { box-shadow: none; border: none; max-width: 100%; }
            .btn-group { display: none; }
        }
    </style>
</head>
<body>

<div class="receipt-card">
    <div class="success-banner">
        <div class="check-circle">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1 class="success-title">{{ $order->payment_status === 'paid' ? 'Payment Successful!' : 'Order Placed Successfully!' }}</h1>
        <p class="success-subtitle">Thank you {{ $order->customer_name }}, your order has been received and registered.</p>
    </div>

    <div class="receipt-content">
        <div class="order-badge-row">
            <span class="badge-ord">Order #{{ $order->order_no }}</span>
            <span class="badge-date">{{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : date('d M Y, h:i A') }}</span>
        </div>

        <div class="details-grid">
            <div class="detail-item">
                <div class="detail-label">Payment Status</div>
                @if($order->payment_status === 'paid')
                    <div class="detail-value text-success" style="color: #10b981;">
                        <i class="fa-solid fa-circle-check"></i> PAID (ONLINE)
                    </div>
                @elseif($order->payment_status === 'cod')
                    <div class="detail-value text-warning" style="color: #d97706;">
                        <i class="fa-solid fa-truck"></i> CASH ON DELIVERY
                    </div>
                @else
                    <div class="detail-value text-warning" style="color: #d97706;">
                        <i class="fa-solid fa-clock"></i> PENDING VERIFICATION
                    </div>
                @endif
            </div>
            <div class="detail-item">
                <div class="detail-label">{{ $order->payment_status === 'paid' ? 'Payment Reference' : 'Payment Mode' }}</div>
                <div class="detail-value" style="font-size: 13px;">
                    @if($order->payment_status === 'paid')
                        {{ $order->razorpay_payment_id ?? 'Verified Online' }}
                    @elseif($order->payment_status === 'cod')
                        Cash on Delivery
                    @else
                        Razorpay Link (After Phone Call)
                    @endif
                </div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Customer Mobile</div>
                <div class="detail-value">{{ $order->customer_phone }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">{{ $order->payment_status === 'paid' ? 'Amount Paid' : 'Total Amount' }}</div>
                <div class="detail-value" style="color: #0284c7;">₹{{ number_format($order->total_amount, 2) }}</div>
            </div>
        </div>

        @if($order->payment_status !== 'paid')
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 16px; margin-bottom: 22px; display: flex; gap: 12px; align-items: flex-start;">
            <i class="fa-solid fa-phone-volume text-success" style="font-size: 20px; margin-top: 3px;"></i>
            <div style="font-size: 13px; color: #166534; line-height: 1.55;">
                <strong>Next Steps (Order Verification & Payment):</strong><br>
                Your order has been registered securely. Our sales and customer support team will contact you shortly to verify your order details and delivery address. Following confirmation, an official <strong>Razorpay Payment Link</strong> will be sent to your Mobile / WhatsApp so you can complete your payment conveniently.
            </div>
        </div>
        @endif

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right; font-weight: 600;">₹{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="total-box">
            <div class="total-row">
                <span>Subtotal</span>
                <span>₹{{ number_format($order->subtotal, 2) }}</span>
            </div>
            @if($order->discount_amount > 0)
            <div class="total-row" style="color: #16a34a;">
                <span>Discount Coupon ({{ $order->coupon_code }})</span>
                <span>-₹{{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="total-row grand">
                <span>{{ $order->payment_status === 'paid' ? 'Total Amount Paid' : 'Total Payable Amount' }}</span>
                <span>₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <!-- Shipping Destination -->
        <div class="shipping-box">
            <i class="fa-solid fa-location-dot" style="font-size: 18px; margin-top: 2px;"></i>
            <div>
                <strong>Shipping Address:</strong><br>
                {{ $order->shipping_address ?? 'Address on file' }}
                @if($order->city), {{ $order->city }}@endif
                @if($order->pincode) - {{ $order->pincode }}@endif
            </div>
        </div>

        <div class="btn-group">
            <a href="{{ route('front.order.pdf', ['order_no' => $order->order_no, 'action' => 'view']) }}" target="_blank" class="btn btn-outline">
                <i class="fa-solid fa-print"></i> Print Receipt
            </a>
            <a href="{{ route('front.order.pdf', ['order_no' => $order->order_no, 'action' => 'download']) }}" class="btn btn-outline" style="border-color: #0284c7; color: #0284c7;">
                <i class="fa-solid fa-file-pdf"></i> Download Order PDF
            </a>
            <a href="{{ route('front.home') }}" class="btn btn-primary">
                <i class="fa-solid fa-arrow-left"></i> Back to Store
            </a>
        </div>
    </div>
</div>

</body>
</html>

