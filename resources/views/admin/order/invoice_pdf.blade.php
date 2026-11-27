<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Order - {{ $order->order_no }}</title>
    <style>
        @page {
            margin: 25px 30px;
        }
        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.45;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            margin-bottom: 12px;
            border-bottom: 2px solid #084b87;
            padding-bottom: 10px;
        }
        .header-logo {
            max-height: 55px;
            max-width: 180px;
        }
        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #084b87;
            letter-spacing: 0.5px;
            margin: 0 0 2px 0;
        }
        .company-tagline {
            font-size: 9.5px;
            color: #64748b;
            margin: 0 0 4px 0;
            font-weight: 600;
        }
        .company-meta {
            font-size: 9px;
            color: #475569;
            line-height: 1.35;
        }
        .invoice-badge {
            background-color: #084b87;
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
            padding: 6px 14px;
            border-radius: 4px;
            display: inline-block;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .info-grid {
            margin-bottom: 15px;
        }
        .info-card {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #f8fafc;
            padding: 8px 12px;
            vertical-align: top;
        }
        .info-card-title {
            font-size: 10.5px;
            font-weight: bold;
            color: #084b87;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }
        .info-row {
            margin-bottom: 3px;
            font-size: 10px;
        }
        .info-label {
            color: #64748b;
            font-weight: 600;
            width: 90px;
            display: inline-block;
        }
        .info-val {
            color: #0f172a;
            font-weight: bold;
        }
        /* Items Table */
        .items-table {
            margin-bottom: 12px;
        }
        .items-table th {
            background-color: #084b87;
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 7px 8px;
            text-align: left;
            border: 1px solid #084b87;
        }
        .items-table td {
            padding: 7px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
            vertical-align: middle;
        }
        .items-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        /* Summary Box */
        .summary-table {
            width: 100%;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        .summary-box {
            width: 250px;
            float: right;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            overflow: hidden;
        }
        .summary-box td {
            padding: 5px 10px;
            font-size: 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .summary-box .grand-total td {
            background-color: #084b87;
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
            border-bottom: none;
            padding: 7px 10px;
        }
        /* Notes & Terms */
        .terms-box {
            border: 1px dashed #cbd5e1;
            background: #fafafa;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 9px;
            color: #475569;
            margin-bottom: 25px;
            line-height: 1.45;
        }
        .terms-title {
            font-size: 9.5px;
            font-weight: bold;
            color: #084b87;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        /* Signatures */
        .sig-table {
            margin-top: 15px;
        }
        .sig-box {
            text-align: center;
            width: 200px;
            font-size: 9.5px;
            color: #475569;
        }
        .sig-line {
            border-top: 1px solid #64748b;
            margin-top: 35px;
            padding-top: 4px;
            font-weight: bold;
            color: #1e293b;
        }
        /* Footer */
        .doc-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8.5px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td width="55%" style="vertical-align: top;">
                @if(!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" class="header-logo" alt="SmartNotes Logo"><br>
                @endif
                <div class="company-name">{{ $settings['site_name'] ?? 'SMART NOTES PUBLICATION PVT. LTD.' }}</div>
                <div class="company-tagline">{{ $settings['site_tagline'] ?? 'School Books Publisher | Nursery to Class 8' }}</div>
                <div class="company-meta">
                    <strong>Surat Office:</strong> {{ $settings['office_surat_address'] ?? '222 to 224, Prime Shoppers, Vesu, Surat - 395007' }}<br>
                    <strong>Contact:</strong> {{ $settings['phone_primary'] ?? '+91 99798-65666' }} | <strong>WhatsApp:</strong> +{{ $settings['whatsapp_number'] ?? '919979865666' }}<br>
                    <strong>Email:</strong> {{ $settings['email_primary'] ?? 'smartnotespublication@gmail.com' }} | <strong>Web:</strong> smartnote.invent-infotech.com
                </div>
            </td>
            <td width="45%" style="vertical-align: top; text-align: right;">
                <div class="invoice-badge">Official Order Invoice</div>
                <div style="margin-top: 8px; font-size: 10px;">
                    <div style="font-size: 13px; font-weight: bold; color: #084b87;">Order # {{ $order->order_no }}</div>
                    <div style="color: #64748b; margin-top: 2px;">Date: <strong>{{ $order->created_at ? $order->created_at->format('d M Y') : date('d M Y') }}</strong></div>
                    <div style="margin-top: 4px;">
                        Order Status: <span style="font-weight: bold; color: #084b87; text-transform: uppercase;">{{ $order->order_status }}</span>
                    </div>
                    <div style="margin-top: 3px;">
                        Payment Status: 
                        @if($order->payment_status === 'paid')
                            <span style="font-weight: bold; color: #059669; text-transform: uppercase;">PAID (ONLINE)</span>
                        @elseif($order->payment_status === 'cod')
                            <span style="font-weight: bold; color: #d97706; text-transform: uppercase;">CASH ON DELIVERY</span>
                        @else
                            <span style="font-weight: bold; color: #d97706; text-transform: uppercase;">PENDING</span>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Info Grid: Customer Details & Order Meta -->
    <table class="info-grid">
        <tr>
            <td width="50%" style="padding-right: 6px;">
                <div class="info-card">
                    <div class="info-card-title">Invoice To (Customer & Shipping Details)</div>
                    <div class="info-row"><span class="info-label">Customer:</span> <span class="info-val" style="font-size: 11px;">{{ $order->customer_name }}</span></div>
                    <div class="info-row"><span class="info-label">Mobile:</span> <span class="info-val">{{ $order->customer_phone }}</span></div>
                    @if($order->customer_email)
                        <div class="info-row"><span class="info-label">Email:</span> <span class="info-val">{{ $order->customer_email }}</span></div>
                    @endif
                    <div class="info-row">
                        <span class="info-label">Address:</span> 
                        <span class="info-val">{{ $order->shipping_address ?? 'On record' }}{{ $order->city ? ', ' . $order->city : '' }}{{ $order->state ? ', ' . $order->state : '' }}{{ $order->pincode ? ' - ' . $order->pincode : '' }}</span>
                    </div>
                </div>
            </td>
            <td width="50%" style="padding-left: 6px;">
                <div class="info-card">
                    <div class="info-card-title">Order & Payment Information</div>
                    <div class="info-row"><span class="info-label">Order Ref:</span> <span class="info-val">{{ $order->order_no }}</span></div>
                    <div class="info-row"><span class="info-label">Order Date:</span> <span class="info-val">{{ $order->created_at ? $order->created_at->format('d-m-Y, h:i A') : date('d-m-Y') }}</span></div>
                    <div class="info-row">
                        <span class="info-label">Payment Mode:</span> 
                        <span class="info-val">
                            @if($order->payment_status === 'paid')
                                Razorpay Online {{ $order->razorpay_payment_id ? '(' . $order->razorpay_payment_id . ')' : '' }}
                            @elseif($order->payment_status === 'cod')
                                Cash on Delivery (COD)
                            @else
                                Razorpay Payment Link (Pending)
                            @endif
                        </span>
                    </div>
                    <div class="info-row"><span class="info-label">Sales Exec:</span> <span class="info-val">{{ $order->seller->name ?? 'Sales Representative' }}</span></div>
                    <div class="info-row"><span class="info-label">Source:</span> <span class="info-val">{{ strtoupper($order->order_source ?: 'Website Storefront') }}</span></div>
                    @if($order->inquiry)
                        <div class="info-row"><span class="info-label">Inquiry Ref:</span> <span class="info-val">{{ $order->inquiry->inquiry_no }}</span></div>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <!-- Order Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="48%">Book Title / Publication Description</th>
                <th width="15%" class="text-center">Standard / Medium</th>
                <th width="12%" class="text-right">Unit Price</th>
                <th width="8%" class="text-center">Qty</th>
                <th width="12%" class="text-right">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($order->items as $idx => $item)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>
                    <strong>{{ $item->product_name }}</strong>
                    @if($item->product && $item->product->product_code)
                        <div style="font-size: 8.5px; color: #64748b;">Code: {{ $item->product->product_code }}</div>
                    @endif
                </td>
                <td class="text-center">
                    {{ $item->product->standard_class ?? 'School Book' }}
                    @if($item->product && $item->product->medium)
                        <br><span style="font-size: 8.5px; color: #64748b;">({{ $item->product->medium }})</span>
                    @endif
                </td>
                <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                <td class="text-center"><strong>{{ $item->quantity }}</strong></td>
                <td class="text-right"><strong>₹{{ number_format($item->subtotal, 2) }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 15px; color: #64748b;">No items listed in this order.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Totals Table -->
    <table class="summary-table">
        <tr>
            <td width="55%" style="vertical-align: top; padding-right: 15px;">
                @if($order->notes)
                    <div style="font-size: 9.5px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; padding: 6px 10px; margin-bottom: 10px;">
                        <strong>Order Notes:</strong> {{ $order->notes }}
                    </div>
                @endif
                <div style="font-size: 9px; color: #64748b;">
                    Total Items Count: <strong>{{ $order->items->sum('quantity') }} unit(s)</strong> across <strong>{{ $order->items->count() }}</strong> book title(s).
                </div>
                @if($order->payment_status === 'paid')
                    <div style="margin-top: 8px; font-size: 9.5px; color: #059669; font-weight: bold;">
                        &#10003; PAYMENT CONFIRMED (ONLINE) - Amount Paid: ₹{{ number_format($order->total_amount, 2) }}
                        @if($order->razorpay_payment_id)
                            <br><span style="font-size: 8.5px; color: #475569; font-weight: normal;">Payment Txn ID: {{ $order->razorpay_payment_id }}</span>
                        @endif
                    </div>
                @endif
            </td>
            <td width="45%" style="vertical-align: top;">
                <table class="summary-box">
                    <tr>
                        <td width="55%"><strong>Subtotal:</strong></td>
                        <td width="45%" class="text-right">₹{{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    @if($order->discount_amount > 0)
                    <tr style="color: #16a34a;">
                        <td><strong>Coupon Discount ({{ $order->coupon_code }}):</strong></td>
                        <td class="text-right">-₹{{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Delivery / Shipping:</strong></td>
                        <td class="text-right" style="color: #059669;"><strong>FREE DELIVERY</strong></td>
                    </tr>
                    <tr class="grand-total">
                        <td>Total Amount:</td>
                        <td class="text-right">₹{{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <!-- Terms & Instructions -->
    <div class="terms-box">
        <div class="terms-title">Terms, Conditions &amp; Delivery Information:</div>
        <ol style="margin: 0; padding-left: 15px;">
            <li><strong>Order Dispatch:</strong> All orders are verified and dispatched directly from our central publishing warehouse in Ahmedabad / Surat.</li>
            <li><strong>Payment Confirmation:</strong> @if($order->payment_status === 'paid')Payment confirmed online via Razorpay Gateway.@elseif($order->payment_status === 'cod')Payment to be collected as Cash on Delivery upon shipment arrival.@else Payment to be verified and settled as per agreed payment method (Razorpay Payment Link).@endif</li>
            <li><strong>Packaging &amp; Delivery:</strong> Educational books are packaged securely with moisture-resistant bulk packaging. Standard delivery time is 2-5 business days.</li>
            <li><strong>Customer Support:</strong> For queries regarding delivery, dispatch tracking, or bulk school orders, contact {{ $settings['phone_primary'] ?? '+91 99798-65666' }} or email {{ $settings['email_primary'] ?? 'smartnotespublication@gmail.com' }}.</li>
        </ol>
    </div>

    <!-- Signatures Section -->
    <table class="sig-table">
        <tr>
            <td width="50%" style="vertical-align: bottom;">
                <div class="sig-box">
                    <div style="font-size: 10px; font-weight: bold; color: #084b87;">
                        {{ $order->seller->name ?? 'Sales / Dispatch Representative' }}
                    </div>
                    <div class="sig-line">Prepared &amp; Verified By</div>
                </div>
            </td>
            <td width="50%" style="vertical-align: bottom; text-align: right;">
                <div class="sig-box" style="margin-left: auto;">
                    <div style="font-size: 10px; font-weight: bold; color: #084b87;">
                        For, SMART NOTES PUBLICATION PVT. LTD.
                    </div>
                    <div class="sig-line">Authorized Signatory / Publisher Stamp</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Document Footer -->
    <div class="doc-footer">
        This is a computer-generated official tax invoice / order slip from SmartNotes CRM. Generated on {{ date('d-m-Y H:i:s') }}. For inquiries: {{ $settings['phone_primary'] ?? '+91 99798-65666' }}.
    </div>

</body>
</html>
