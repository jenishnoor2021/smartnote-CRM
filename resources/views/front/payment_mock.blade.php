<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartNote - Payment Checkout (Razorpay)</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }
        body { background: #f1f5f9; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .checkout-box { background: #ffffff; width: 100%; max-width: 480px; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid #e2e8f0; }
        .checkout-header { background: #0c2340; color: #fff; padding: 24px; text-align: center; position: relative; }
        .rzp-badge { position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.15); color: #93c5fd; font-size: 11px; padding: 4px 8px; border-radius: 20px; font-weight: 600; letter-spacing: 0.5px; }
        .brand-logo { width: 52px; height: 52px; background: #2563eb; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; color: #fff; margin-bottom: 10px; box-shadow: 0 4px 12px rgba(37,99,235,0.4); }
        .checkout-title { font-size: 20px; font-weight: 700; }
        .order-pill { display: inline-block; background: rgba(255,255,255,0.1); padding: 4px 12px; border-radius: 20px; font-size: 13px; margin-top: 6px; color: #cbd5e1; }
        .checkout-body { padding: 24px; }
        .amount-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .amount-label { color: #64748b; font-size: 13px; }
        .amount-value { font-size: 24px; font-weight: 700; color: #0f172a; }
        .info-group { margin-bottom: 20px; }
        .info-row { display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px; color: #475569; }
        .info-row span:last-child { font-weight: 600; color: #1e293b; }
        .method-card { border: 2px solid #2563eb; border-radius: 12px; padding: 14px; display: flex; align-items: center; gap: 12px; background: #eff6ff; margin-bottom: 20px; }
        .method-icon { width: 36px; height: 36px; border-radius: 8px; background: #2563eb; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .btn-pay { width: 100%; background: #2563eb; color: #fff; border: none; padding: 15px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; box-shadow: 0 4px 14px rgba(37,99,235,0.35); }
        .btn-pay:hover { background: #1d4ed8; }
        .security-badge { text-align: center; margin-top: 16px; font-size: 12px; color: #94a3b8; display: flex; align-items: center; justify-content: center; gap: 6px; }
        .demo-notice { background: #fef3c7; border: 1px dashed #f59e0b; color: #92400e; padding: 10px; border-radius: 8px; font-size: 12px; margin-bottom: 18px; text-align: center; line-height: 1.4; }
    </style>
</head>
<body>

<div class="checkout-box">
    <div class="checkout-header">
        <span class="rzp-badge"><i class="fa-solid fa-bolt"></i> Razorpay</span>
        <div class="brand-logo">
            <i class="fa-solid fa-book-open"></i>
        </div>
        <div class="checkout-title">SmartNote Publications</div>
        <div class="order-pill">Order #{{ $order->order_no }}</div>
    </div>

    <div class="checkout-body">
        @if(empty(config('services.razorpay.key_id')))
        <div class="demo-notice">
            <i class="fa-solid fa-flask"></i> <strong>Simulation / Demo Mode:</strong><br>
            Keys not detected in <code>.env</code> yet. You can click <strong>Pay Now</strong> below to complete simulated payment and verify the full workflow!
        </div>
        @endif

        <div class="amount-box">
            <div>
                <div class="amount-label">Total Payable</div>
                <div style="font-size: 11px; color: #94a3b8;">Includes all taxes & delivery</div>
            </div>
            <div class="amount-value">₹{{ number_format($order->total_amount, 2) }}</div>
        </div>

        <div class="info-group">
            <div class="info-row">
                <span>Customer Name</span>
                <span>{{ $order->customer_name }}</span>
            </div>
            <div class="info-row">
                <span>Mobile</span>
                <span>{{ $order->customer_phone }}</span>
            </div>
            @if($order->customer_email)
            <div class="info-row">
                <span>Email</span>
                <span>{{ $order->customer_email }}</span>
            </div>
            @endif
            @if($order->discount_amount > 0)
            <div class="info-row" style="color: #16a34a;">
                <span>Coupon Applied ({{ $order->coupon_code }})</span>
                <span style="color: #16a34a;">-₹{{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif
        </div>

        <div class="method-card">
            <div class="method-icon">
                <i class="fa-solid fa-credit-card"></i>
            </div>
            <div style="flex: 1;">
                <div style="font-weight: 600; font-size: 14px; color: #1e293b;">UPI / Cards / NetBanking</div>
                <div style="font-size: 12px; color: #64748b;">Instant Confirmation via Razorpay</div>
            </div>
            <i class="fa-solid fa-circle-check" style="color: #2563eb; font-size: 20px;"></i>
        </div>

        <form action="{{ route('front.payment_callback') }}" method="GET" id="payForm">
            <input type="hidden" name="order_no" value="{{ $order->order_no }}">
            <input type="hidden" name="razorpay_payment_id" value="pay_demo_{{ strtoupper(\Illuminate\Support\Str::random(10)) }}">
            <input type="hidden" name="razorpay_payment_link_id" value="{{ $order->razorpay_payment_id ?? 'plink_demo_' . strtolower(\Illuminate\Support\Str::random(8)) }}">
            <input type="hidden" name="razorpay_payment_link_status" value="paid">

            <button type="submit" class="btn-pay" id="payBtn">
                <i class="fa-solid fa-lock"></i> Pay ₹{{ number_format($order->total_amount, 2) }}
            </button>
        </form>

        <div class="security-badge">
            <i class="fa-solid fa-shield-halved text-success"></i> 256-bit SSL Encrypted & Secured Payment
        </div>
    </div>
</div>

<script>
    document.getElementById('payForm').addEventListener('submit', function() {
        var btn = document.getElementById('payBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing Secure Payment...';
    });
</script>

</body>
</html>

