@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Order Details') }}: {{ $order->order_no }}</span>
                <span class="label {{ $order->order_status == 'delivered' ? 'label-success' : ($order->order_status == 'cancelled' ? 'label-danger' : 'label-primary') }}" style="font-size: 13px; margin-left: 10px;">
                    {{ strtoupper($order->order_status) }}
                </span>
            </h4>
        </div>
        <div class="heading-elements">
            <button type="button" class="btn btn-default btn-sm" onclick="window.print();">
                <i class="icon-printer position-left"></i> Print Slip
            </button>
            <a href="{{ route('admin.order.index') }}" class="btn btn-default btn-sm">
                <i class="icon-arrow-left52 position-left"></i> Back to Orders
            </a>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.order.index') }}">{{ __('Orders') }}</a></li>
            <li class="active">{{ $order->order_no }}</li>
        </ul>
    </div>
</div>

<div class="content">

    @if(session('success'))
        <div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Main Order Details / Slip -->
        <div class="col-md-8">
            <div class="panel panel-flat">
                <div class="panel-heading bg-slate-700">
                    <div class="row">
                        <div class="col-xs-6">
                            <h5 class="panel-title"><strong>Order #{{ $order->order_no }}</strong></h5>
                        </div>
                        <div class="col-xs-6 text-right">
                            <span class="text-muted" style="color: #cbd5e1;">Placed: {{ $order->created_at ? $order->created_at->format('d-m-Y h:i A') : '' }}</span>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-sm-6">
                            <h6 class="text-semibold" style="margin-top: 0; color: #1e293b;">
                                <i class="icon-user position-left text-muted"></i> Customer Info:
                            </h6>
                            <p style="margin-bottom: 5px;">
                                <strong style="font-size: 15px;">{{ $order->customer_name }}</strong><br>
                                <span style="font-size: 14px;">
                                    <i class="icon-phone2 position-left text-success"></i> <a href="tel:{{ $order->customer_phone }}" class="text-semibold">{{ $order->customer_phone }}</a>
                                    <a href="tel:{{ $order->customer_phone }}" class="btn btn-xs btn-success" style="margin-left: 8px;">
                                        <i class="icon-phone2 position-left"></i> Call Customer
                                    </a>
                                </span><br>
                                @if($order->customer_email)
                                    <i class="icon-mail5 position-left text-muted"></i> {{ $order->customer_email }}<br>
                                @endif
                            </p>
                        </div>
                        <div class="col-sm-6 text-right">
                            <h6 class="text-semibold" style="margin-top: 0; color: #1e293b;">
                                <i class="icon-truck position-left text-muted"></i> Shipping Address:
                            </h6>
                            <p style="margin-bottom: 5px;">
                                {{ $order->shipping_address ?? 'Not specified' }}<br>
                                @if($order->city){{ $order->city }}@endif
                                @if($order->state), {{ $order->state }}@endif
                                @if($order->pincode) - {{ $order->pincode }}@endif
                            </p>
                            @if($order->inquiry)
                                <div class="text-muted text-size-small">
                                    Converted from: <a href="{{ route('admin.inquiry.show', $order->inquiry_id) }}">Inquiry #{{ $order->inquiry->inquiry_no }}</a>
                                </div>
                            @elseif($order->order_source === 'website')
                                <div>
                                    <span class="label label-info">WEBSITE DIRECT ORDER</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="bg-slate-600">
                                    <th>Product Details</th>
                                    <th width="15%" class="text-right">Price</th>
                                    <th width="12%" class="text-center">Quantity</th>
                                    <th width="20%" class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product_name }}</strong>
                                        @if($item->product && $item->product->product_code)
                                            <div class="text-muted text-size-mini">Code: {{ $item->product->product_code }}</div>
                                        @endif
                                    </td>
                                    <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right"><strong>₹{{ number_format($item->subtotal, 2) }}</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <th class="text-right">₹{{ number_format($order->subtotal, 2) }}</th>
                                </tr>
                                @if($order->discount_amount > 0)
                                <tr class="text-success">
                                    <th colspan="3" class="text-right">
                                        <i class="icon-price-tag2 position-left"></i> Coupon Discount ({{ $order->coupon_code }}):
                                    </th>
                                    <th class="text-right">-₹{{ number_format($order->discount_amount, 2) }}</th>
                                </tr>
                                @endif
                                <tr style="font-size: 16px;" class="bg-slate-100">
                                    <th colspan="3" class="text-right"><strong>Grand Total:</strong></th>
                                    <th class="text-right text-primary"><strong>₹{{ number_format($order->total_amount, 2) }}</strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                        <div class="well well-sm" style="margin-top: 20px; background-color: #f8fafc;">
                            <strong><i class="icon-file-text2 position-left"></i> Order Notes / Delivery Instructions:</strong>
                            <p style="margin-top: 5px; margin-bottom: 0;">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar: Order Management / Status Update -->
        <div class="col-md-4">

            <!-- Razorpay Payment Link Card -->
            <div class="panel panel-flat border-left-lg {{ $order->payment_status === 'paid' ? 'border-left-success' : ($order->payment_link ? 'border-left-info' : 'border-left-primary') }}">
                <div class="panel-heading {{ $order->payment_status === 'paid' ? 'bg-success-600' : ($order->payment_link ? 'bg-info-600' : 'bg-slate-700') }}">
                    <h6 class="panel-title">
                        <i class="icon-credit-card position-left"></i> Razorpay Payment Link
                        <span class="pull-right">
                            @if($order->payment_status === 'paid')
                                <span class="label label-success" style="border: 1px solid #fff; font-size: 11px;">PAID</span>
                            @elseif($order->payment_status === 'link_sent')
                                <span class="label label-info" style="border: 1px solid #fff; font-size: 11px;">LINK SENT</span>
                            @else
                                <span class="label label-warning" style="border: 1px solid #fff; font-size: 11px;">PENDING</span>
                            @endif
                        </span>
                    </h6>
                </div>
                <div class="panel-body">
                    @if($order->payment_status === 'paid')
                        <div class="text-center" style="padding: 15px 10px;">
                            <div style="font-size: 44px; color: #10b981; line-height: 1;">
                                <i class="icon-checkmark-circle"></i>
                            </div>
                            <h5 class="text-semibold text-success" style="margin-top: 10px; margin-bottom: 5px;">Payment Received!</h5>
                            <div style="font-size: 20px; font-weight: bold; color: #0f172a;">₹{{ number_format($order->total_amount, 2) }}</div>
                            <div class="text-muted text-size-mini" style="margin-top: 6px;">
                                Payment ID: <strong>{{ $order->razorpay_payment_id ?? 'Confirmed Online' }}</strong>
                            </div>
                            <div class="text-muted text-size-mini">
                                Method: ONLINE (RAZORPAY LINK)
                            </div>
                        </div>
                    @else
                        <!-- Amount to collect -->
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px; margin-bottom: 15px;">
                            <div class="text-muted text-size-mini">Amount to Collect:</div>
                            <div style="font-size: 22px; font-weight: 700; color: #1e293b;">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </div>
                            @if($order->discount_amount > 0)
                                <div class="text-success text-size-mini">
                                    <i class="icon-checkmark3 position-left"></i> Coupon Discount: -₹{{ number_format($order->discount_amount, 2) }}
                                </div>
                            @endif
                        </div>

                        @if($order->payment_link)
                            <!-- Link Already Generated -->
                            <div class="form-group" style="margin-bottom: 12px;">
                                <label class="text-semibold text-size-mini text-muted">PAYMENT LINK (SHARE WITH CUSTOMER):</label>
                                <div class="input-group">
                                    <input type="text" id="razorpayLinkInput" class="form-control input-sm" value="{{ $order->payment_link }}" readonly style="background: #fff; font-weight: 600;">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default btn-sm" onclick="copyPaymentLink()" title="Copy to clipboard">
                                            <i class="icon-copy" id="copyIcon"></i> <span id="copyText">Copy</span>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                                if(strlen($cleanPhone) === 10) $cleanPhone = '91' . $cleanPhone;
                                $waText = "Hello {$order->customer_name},\n\nThank you for choosing SmartNote! Your order #{$order->order_no} is confirmed.\n\nTotal Payable Amount: Rs. " . number_format($order->total_amount, 2) . "\n\nPlease complete your secure payment using this link:\n{$order->payment_link}\n\nOnce paid, your order will be dispatched promptly!\nThank you,\nSmartNote Team";
                            @endphp

                            <!-- WhatsApp Share Button -->
                            <div style="margin-bottom: 10px;">
                                <a href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text={{ rawurlencode($waText) }}" target="_blank" class="btn btn-success btn-block" style="background-color: #25D366; border-color: #25D366; font-weight: 600;">
                                    <i class="icon-bubble position-left"></i> Share on WhatsApp
                                </a>
                            </div>

                            <div class="row" style="margin-left: -5px; margin-right: -5px; margin-bottom: 10px;">
                                <div class="col-xs-6" style="padding-left: 5px; padding-right: 5px;">
                                    <button type="button" class="btn btn-info btn-block btn-sm" onclick="checkRazorpayStatus()" id="checkStatusBtn">
                                        <i class="icon-sync position-left"></i> Check Status
                                    </button>
                                </div>
                                <div class="col-xs-6" style="padding-left: 5px; padding-right: 5px;">
                                    <button type="button" class="btn btn-default btn-block btn-sm" onclick="generatePaymentLink(true)">
                                        <i class="icon-reload-alt position-left"></i> Regenerate
                                    </button>
                                </div>
                            </div>

                            <div class="text-center text-muted text-size-mini">
                                Link ID: <code>{{ $order->razorpay_payment_id ?? 'N/A' }}</code>
                            </div>
                        @else
                            <!-- Link Not Generated Yet -->
                            <div style="margin-bottom: 12px;">
                                <div class="checkbox" style="margin-top: 0; margin-bottom: 5px;">
                                    <label>
                                        <input type="checkbox" id="notify_sms" class="styled" checked>
                                        <strong>Notify via SMS</strong> ({{ $order->customer_phone }})
                                    </label>
                                </div>
                                <div class="checkbox" style="margin-top: 0; margin-bottom: 10px;">
                                    <label>
                                        <input type="checkbox" id="notify_email" class="styled" {{ $order->customer_email ? 'checked' : 'disabled' }}>
                                        <strong>Notify via Email</strong> {{ $order->customer_email ? '(' . $order->customer_email . ')' : '(No email)' }}
                                    </label>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary btn-block btn-lg" onclick="generatePaymentLink(false)" id="generateLinkBtn" style="font-weight: 600;">
                                <i class="icon-link position-left"></i> Generate Razorpay Link
                            </button>

                            <div class="text-muted text-size-mini text-center" style="margin-top: 8px;">
                                Creates a Standard Payment Link via Razorpay API.
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Discount Coupon Card (Seller can apply discount for customer here) -->
            <div class="panel panel-flat border-left-lg border-left-warning">
                <div class="panel-heading bg-slate-700">
                    <h6 class="panel-title">
                        <i class="icon-price-tag2 position-left"></i> Discount Coupon
                    </h6>
                </div>
                <div class="panel-body">
                    @if($order->coupon_id)
                        <div class="alert alert-success alert-styled-left alert-arrow-left" style="margin-bottom: 12px; padding: 10px 15px;">
                            <div class="text-semibold"><i class="icon-checkmark4 position-left"></i> Coupon: {{ $order->coupon_code }}</div>
                            <div style="margin-top: 3px;">Discount Given: <strong>₹{{ number_format($order->discount_amount, 2) }}</strong></div>
                        </div>
                        <button type="button" class="btn btn-xs btn-danger btn-block" onclick="removeOrderCoupon()">
                            <i class="icon-cross2 position-left"></i> Remove Coupon Discount
                        </button>
                    @else
                        <div class="form-group" style="margin-bottom: 8px;">
                            <label class="text-semibold">Enter Coupon Code (from Admin):</label>
                            <div class="input-group">
                                <input type="text" id="orderCouponInput" class="form-control text-uppercase" placeholder="e.g. SAVE10" style="font-weight: bold; letter-spacing: 1px;">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" onclick="applyOrderCoupon()">Apply</button>
                                </span>
                            </div>
                            <span class="help-block text-muted text-size-mini">Customer asks for discount -> Ask Admin for Coupon -> Enter code here.</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Manage Order Card -->
            <div class="panel panel-flat">
                <div class="panel-heading bg-primary">
                    <h6 class="panel-title"><i class="icon-cog5 position-left"></i> Manage Order Confirmation</h6>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.order.update_status', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label class="text-semibold">Order Status:</label>
                            <select name="order_status" class="form-control">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending (Not confirmed yet)</option>
                                <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Confirmed (Customer agreed)</option>
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing / Packing</option>
                                <option value="dispatched" {{ $order->order_status == 'dispatched' ? 'selected' : '' }}>Dispatched / Shipped</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Payment Status:</label>
                            <select name="payment_status" class="form-control">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="link_sent" {{ $order->payment_status == 'link_sent' ? 'selected' : '' }}>Payment Link Sent</option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Payment Method:</label>
                            <input type="text" class="form-control" value="{{ $order->payment_method === 'razorpay_link' ? 'ONLINE (RAZORPAY LINK)' : strtoupper($order->payment_method ?? 'ONLINE') }}" readonly>
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Assign / Handled By Seller:</label>
                            @if(Auth::user()->isSuperAdmin())
                                <select name="seller_id" class="form-control">
                                    <option value="">-- Unassigned (Direct / No Seller) --</option>
                                    @foreach($sellers as $seller)
                                        <option value="{{ $seller->id }}" {{ $order->seller_id == $seller->id ? 'selected' : '' }}>
                                            {{ $seller->name }} ({{ $seller->username }})
                                        </option>
                                    @endforeach
                                </select>
                                <span class="help-block text-muted text-size-mini">Assign this website order to a seller so they can call customer & confirm.</span>
                            @else
                                <input type="text" class="form-control" value="{{ $order->seller->name ?? 'Unassigned' }}" readonly>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Internal Notes / Delivery Remarks:</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Customer confirmation notes, tracking details, etc.">{{ $order->notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg">
                            <i class="icon-check position-left"></i> Save & Update Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
<script type="text/javascript">
    function applyOrderCoupon() {
        var code = $('#orderCouponInput').val().trim();
        if(!code) {
            swal("Notice", "Please enter a coupon code provided by Admin.", "info");
            return;
        }

        $.ajax({
            url: "{{ route('admin.order.apply_coupon', $order->id) }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                coupon_code: code
            },
            success: function(response) {
                if(response.status) {
                    swal({
                        title: "Discount Applied!",
                        text: response.message,
                        type: "success",
                        closeOnConfirm: true
                    }, function() {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                var msg = "Failed to apply coupon";
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                swal({
                    title: "Cannot Apply Coupon",
                    text: msg,
                    type: "error",
                    closeOnConfirm: true
                });
            }
        });
    }

    function removeOrderCoupon() {
        swal({
            title: "Remove coupon discount?",
            text: "This will remove the discount and restore original order total.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#EF5350",
            confirmButtonText: "Yes, Remove!",
            cancelButtonText: "Cancel",
            closeOnConfirm: false
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "{{ route('admin.order.remove_coupon', $order->id) }}",
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if(response.status) {
                            swal({
                                title: "Removed!",
                                text: response.message,
                                type: "success",
                                closeOnConfirm: true
                            }, function() {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        var msg = "Failed to remove coupon";
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        swal({
                            title: "Error",
                            text: msg,
                            type: "error",
                            closeOnConfirm: true
                        });
                    }
                });
            }
        });
    }

    function generatePaymentLink(isRegen, allowMock) {
        var notifySms = $('#notify_sms').length ? ($('#notify_sms').is(':checked') ? 1 : 0) : 1;
        var notifyEmail = $('#notify_email').length ? ($('#notify_email').is(':checked') ? 1 : 0) : 1;
        var btn = $('#generateLinkBtn');
        var originalText = btn.html();

        btn.prop('disabled', true).html('<i class="icon-spinner2 spinner position-left"></i> Connecting to Razorpay...');

        $.ajax({
            url: "{{ route('admin.order.generate_payment_link', $order->id) }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                notify_sms: notifySms,
                notify_email: notifyEmail,
                allow_mock: allowMock ? 1 : 0
            },
            success: function(response) {
                btn.prop('disabled', false).html(originalText);
                if (response.status) {
                    swal({
                        title: "Payment Link Generated!",
                        text: response.message + "\n\nLink: " + response.payment_link,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html(originalText);
                var res = xhr.responseJSON || {};

                if (res.missing_keys) {
                    swal({
                        title: "Razorpay Keys Missing in .env",
                        text: "RAZORPAY_KEY_ID & RAZORPAY_KEY_SECRET are not set in .env yet.\n\nWould you like to generate a simulated demo link to test the workflow right now?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#2196F3",
                        confirmButtonText: "Yes, Generate Demo Link",
                        cancelButtonText: "I will add keys to .env",
                        closeOnConfirm: false
                    }, function(isConfirm) {
                        if (isConfirm) {
                            generatePaymentLink(isRegen, true);
                        }
                    });
                    return;
                }

                var msg = res.message || "Failed to generate Razorpay Payment Link.";
                swal("Razorpay Error", msg, "error");
            }
        });
    }

    function checkRazorpayStatus() {
        var btn = $('#checkStatusBtn');
        var origHtml = btn.html();
        btn.prop('disabled', true).html('<i class="icon-spinner2 spinner"></i> Checking...');

        $.ajax({
            url: "{{ route('admin.order.check_payment_status', $order->id) }}",
            type: "GET",
            success: function(response) {
                btn.prop('disabled', false).html(origHtml);
                if (response.is_paid) {
                    swal({
                        title: "Payment Received!",
                        text: response.message,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {
                    swal({
                        title: "Status: " + (response.payment_status ? response.payment_status.toUpperCase() : 'PENDING'),
                        text: response.message,
                        type: "info"
                    });
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html(origHtml);
                var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : "Unable to verify payment status.";
                swal("Status Check Failed", msg, "error");
            }
        });
    }

    function copyPaymentLink() {
        var input = document.getElementById("razorpayLinkInput");
        if (!input) return;

        input.select();
        input.setSelectionRange(0, 99999); // Mobile support

        if (navigator.clipboard) {
            navigator.clipboard.writeText(input.value).then(function() {
                showCopiedFeedback();
            });
        } else {
            document.execCommand("copy");
            showCopiedFeedback();
        }
    }

    function showCopiedFeedback() {
        $('#copyIcon').removeClass('icon-copy').addClass('icon-checkmark3 text-success');
        $('#copyText').text('Copied!');
        setTimeout(function() {
            $('#copyIcon').removeClass('icon-checkmark3 text-success').addClass('icon-copy');
            $('#copyText').text('Copy');
        }, 2000);
    }
</script>
@endsection
