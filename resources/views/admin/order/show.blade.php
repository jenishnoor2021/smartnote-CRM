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
            <a href="{{ route('admin.order.pdf', ['id' => $order->id, 'action' => 'view']) }}" target="_blank" class="btn btn-default btn-sm" title="Print / Preview Official Order Slip">
                <i class="icon-printer position-left"></i> Print Slip
            </a>
            <a href="{{ route('admin.order.pdf', ['id' => $order->id, 'action' => 'download']) }}" class="btn bg-danger btn-sm" title="Download Official Order PDF">
                <i class="icon-file-pdf position-left"></i> Download Order PDF
            </a>
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

                    @php
                        $canEditOrderItems = ($order->order_status === 'pending' && $order->payment_status !== 'paid');
                    @endphp

                    <!-- Items Header & Quick Edit Toggle Button -->
                    <div class="row" style="margin-bottom: 12px;">
                        <div class="col-xs-7">
                            <h6 class="text-semibold" style="margin: 0; padding-top: 5px;">
                                <i class="icon-books position-left"></i> Products in this Order
                            </h6>
                        </div>
                        <div class="col-xs-5 text-right">
                            @if($canEditOrderItems)
                                <button type="button" class="btn btn-xs btn-primary text-semibold" id="btnToggleEditItems" onclick="enableOrderEditMode()">
                                    <i class="icon-pencil7 position-left"></i> Edit Products / Qty
                                </button>
                                <button type="button" class="btn btn-xs btn-default text-semibold" id="btnCancelEditItems" style="display: none;" onclick="cancelOrderEditMode()">
                                    <i class="icon-cross2 position-left"></i> Cancel Edit
                                </button>
                            @else
                                @if($order->payment_status === 'paid')
                                    <span class="label label-success" title="Paid orders cannot be edited">
                                        <i class="icon-lock2 position-left"></i> Paid (Locked)
                                    </span>
                                @else
                                    <span class="label label-default" title="Orders that are {{ ucfirst($order->order_status) }} cannot be edited">
                                        <i class="icon-lock2 position-left"></i> {{ ucfirst($order->order_status) }} (Locked)
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- VIEW MODE: Standard Read-only Items Table -->
                    <div id="orderItemsViewContainer" class="table-responsive">
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
                                        @if($item->product && ($item->product->category || $item->product->subcategory))
                                            <div style="margin-top: 3px;">
                                                @if($item->product->category)
                                                    <span class="label label-default" style="font-size: 9.5px; padding: 1px 5px;">{{ $item->product->category->category_name }}</span>
                                                @endif
                                                @if($item->product->subcategory)
                                                    <span class="label label-info" style="font-size: 9.5px; padding: 1px 5px;">{{ $item->product->subcategory->subcategory_name }}</span>
                                                @endif
                                            </div>
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

                    @if($canEditOrderItems)
                    <!-- EDIT MODE: Interactive Option 1 Panel (Category/Subcategory Selector + Editable Table) -->
                    <div id="orderItemsEditContainer" style="display: none;">
                        
                        <!-- Top Selector Box -->
                        <div class="well well-sm" style="background-color: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h6 class="text-semibold text-primary" style="margin-top: 0; margin-bottom: 12px;">
                                        <i class="icon-filter3 position-left"></i> Add Product by Category &amp; Sub Category
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-10">
                                        <label class="text-semibold text-size-small"><span class="text-danger">*</span> Category:</label>
                                        <select id="edit_sel_category" class="form-control" onchange="onOrderCategoryChange()">
                                            <option value="">-- Select Category --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-10">
                                        <label class="text-semibold text-size-small"><span class="text-danger">*</span> Sub Category:</label>
                                        <select id="edit_sel_subcategory" class="form-control" disabled onchange="onOrderSubcategoryChange()">
                                            <option value="">-- Select Category First --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-10">
                                        <label class="text-semibold text-size-small"><span class="text-danger">*</span> Product / Book:</label>
                                        <select id="edit_sel_product" class="form-control" disabled onchange="onOrderProductSelectChange()">
                                            <option value="">-- Select Sub Category First --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 6px;">
                                <div class="col-xs-6 col-sm-4">
                                    <div class="form-group mb-0">
                                        <label class="text-semibold text-size-small">Price (₹):</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">₹</span>
                                            <input type="number" id="edit_sel_price" class="form-control text-semibold" step="0.01" min="0" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group mb-0">
                                        <label class="text-semibold text-size-small">Quantity:</label>
                                        <input type="number" id="edit_sel_qty" class="form-control text-semibold" min="1" value="1">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-5" style="margin-top: 25px;">
                                    <button type="button" class="btn btn-primary btn-block text-semibold" onclick="addProductToOrderTable()">
                                        <i class="icon-plus22 position-left"></i> Add to Order
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Editable Products Table -->
                        <form id="orderItemsEditForm">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="orderEditTable">
                                    <thead>
                                        <tr class="bg-slate-600">
                                            <th width="42%">Product Details</th>
                                            <th width="20%">Price (₹)</th>
                                            <th width="15%">Qty</th>
                                            <th width="18%">Subtotal (₹)</th>
                                            <th width="5%" class="text-center"><i class="icon-trash"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderEditRowsContainer">
                                        <!-- Dynamic Editable Rows -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right text-semibold">Subtotal:</th>
                                            <th colspan="2" class="text-right text-bold">
                                                ₹<span id="editSubtotalDisplay">{{ number_format($order->subtotal, 2) }}</span>
                                            </th>
                                        </tr>
                                        @if($order->coupon_id && $order->coupon)
                                        <tr class="text-success" id="editCouponRow">
                                            <th colspan="3" class="text-right text-semibold">
                                                <i class="icon-price-tag2 position-left"></i> Coupon Discount ({{ $order->coupon_code }}):
                                            </th>
                                            <th colspan="2" class="text-right text-bold">
                                                -₹<span id="editDiscountDisplay">{{ number_format($order->discount_amount, 2) }}</span>
                                            </th>
                                        </tr>
                                        @endif
                                        <tr class="bg-slate-100">
                                            <th colspan="3" class="text-right text-semibold">Grand Total:</th>
                                            <th colspan="2" class="text-primary text-bold" style="font-size: 16px;">
                                                ₹<span id="editGrandTotalDisplay">{{ number_format($order->total_amount, 2) }}</span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="alert alert-info" style="margin-top: 15px; padding: 10px 15px;">
                                <i class="icon-info22 position-left"></i> 
                                <strong>Notice:</strong> Saving changes will update the order totals. If a Razorpay payment link was previously generated, it will be reset so you can send a new link with the updated amount.
                            </div>

                            <div class="text-right" style="margin-top: 15px;">
                                <button type="button" class="btn btn-default" onclick="cancelOrderEditMode()">
                                    <i class="icon-cross2 position-left"></i> Cancel
                                </button>
                                <button type="button" class="btn btn-success btn-labeled btn-labeled-right" id="btnSaveOrderItems" onclick="saveOrderItems()">
                                    <b><i class="icon-check"></i></b> Save Changes &amp; Recalculate
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

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

@if($canEditOrderItems)
    var allOrderSubcategories = @json($subcategories ?? []);
    var allOrderProducts = @json($products ?? []);
    var orderCoupon = @json($order->coupon ?? null);
    var orderRowCounter = 0;
    var initialOrderItems = [
        @if($order->items && $order->items->count() > 0)
            @foreach($order->items as $item)
            {
                product_id: {{ intval($item->product_id ?? 0) }},
                product_name: @json($item->product ? $item->product->product_name : ($item->product_name ?? 'Product')),
                category_name: @json(($item->product && $item->product->category) ? $item->product->category->category_name : ''),
                subcategory_name: @json(($item->product && $item->product->subcategory) ? $item->product->subcategory->subcategory_name : ''),
                price: {{ floatval($item->price ?? 0) }},
                quantity: {{ intval($item->quantity ?? 1) }}
            },
            @endforeach
        @endif
    ];

    function enableOrderEditMode() {
        $('#orderItemsViewContainer').hide();
        $('#orderItemsEditContainer').slideDown(250);
        $('#btnToggleEditItems').hide();
        $('#btnCancelEditItems').show();

        // Populate initial rows only if empty
        if($('#orderEditRowsContainer tr.product-row-edit').length === 0) {
            initOrderEditRows();
        }
    }

    function cancelOrderEditMode() {
        $('#orderItemsEditContainer').hide();
        $('#orderItemsViewContainer').show();
        $('#btnToggleEditItems').show();
        $('#btnCancelEditItems').hide();
        initOrderEditRows();
    }

    function initOrderEditRows() {
        $('#orderEditRowsContainer').empty();
        orderRowCounter = 0;
        if (typeof initialOrderItems !== 'undefined' && initialOrderItems.length > 0) {
            $.each(initialOrderItems, function(index, item) {
                appendOrderEditRow(
                    item.product_id,
                    item.product_name,
                    item.category_name,
                    item.subcategory_name,
                    item.price,
                    item.quantity
                );
            });
        }
    }

    function onOrderCategoryChange() {
        var catId = $('#edit_sel_category').val();
        var $subCatSelect = $('#edit_sel_subcategory');
        var $prodSelect = $('#edit_sel_product');

        $subCatSelect.empty().append('<option value="">-- Select Sub Category --</option>');
        $prodSelect.empty().append('<option value="">-- Select Sub Category First --</option>').prop('disabled', true);
        $('#edit_sel_price').val('');
        $('#edit_sel_qty').val(1);

        if(!catId) {
            $subCatSelect.empty().append('<option value="">-- Select Category First --</option>').prop('disabled', true);
            return;
        }

        var filteredSubcats = allOrderSubcategories.filter(function(sub) {
            return sub.category_id == catId;
        });

        if(filteredSubcats.length > 0) {
            $.each(filteredSubcats, function(index, sub) {
                $subCatSelect.append('<option value="' + sub.id + '">' + sub.subcategory_name + '</option>');
            });
            $subCatSelect.prop('disabled', false);
        } else {
            $subCatSelect.append('<option value="">-- No Subcategories Found --</option>').prop('disabled', true);
        }
    }

    function onOrderSubcategoryChange() {
        var catId = $('#edit_sel_category').val();
        var subId = $('#edit_sel_subcategory').val();
        var $prodSelect = $('#edit_sel_product');

        $prodSelect.empty().append('<option value="">-- Select Product --</option>');
        $('#edit_sel_price').val('');
        $('#edit_sel_qty').val(1);

        if(!subId) {
            $prodSelect.empty().append('<option value="">-- Select Sub Category First --</option>').prop('disabled', true);
            return;
        }

        var filteredProducts = allOrderProducts.filter(function(prod) {
            return prod.category_id == catId && prod.subcategory_id == subId;
        });

        if(filteredProducts.length > 0) {
            $.each(filteredProducts, function(index, prod) {
                var priceDisplay = prod.selling_price ? parseFloat(prod.selling_price).toFixed(2) : '0.00';
                $prodSelect.append('<option value="' + prod.id + '" data-price="' + prod.selling_price + '">' + prod.product_name + ' (₹' + priceDisplay + ')</option>');
            });
            $prodSelect.prop('disabled', false);
        } else {
            $prodSelect.append('<option value="">-- No Products Found in this Subcategory --</option>').prop('disabled', true);
        }
    }

    function onOrderProductSelectChange() {
        var selectedOption = $('#edit_sel_product').find('option:selected');
        var price = selectedOption.data('price') || 0;
        $('#edit_sel_price').val(parseFloat(price).toFixed(2));
        if(!$('#edit_sel_qty').val() || $('#edit_sel_qty').val() < 1) {
            $('#edit_sel_qty').val(1);
        }
    }

    function addProductToOrderTable() {
        var prodId = $('#edit_sel_product').val();
        if(!prodId) {
            swal("Required", "Please select a Category, Sub Category, and Product first.", "warning");
            return;
        }

        var price = parseFloat($('#edit_sel_price').val()) || 0;
        var qty = parseInt($('#edit_sel_qty').val()) || 1;
        if(qty < 1) qty = 1;

        // Check if already in table
        var existingRow = $('input.order-row-prod-id[value="' + prodId + '"]').closest('tr.product-row-edit');
        if(existingRow.length > 0) {
            var currentQtyInput = existingRow.find('.order-row-qty');
            var newQty = (parseInt(currentQtyInput.val()) || 0) + qty;
            currentQtyInput.val(newQty);
            calculateOrderRow(existingRow);

            $('#edit_sel_product').val('');
            $('#edit_sel_price').val('');
            $('#edit_sel_qty').val(1);

            swal("Quantity Updated", "Product is already in the order. Quantity increased to " + newQty + ".", "info");
            return;
        }

        var selectedProduct = allOrderProducts.find(function(p) { return p.id == prodId; });
        var productName = selectedProduct ? selectedProduct.product_name : $('#edit_sel_product option:selected').text();
        var catName = $('#edit_sel_category option:selected').text();
        var subcatName = $('#edit_sel_subcategory option:selected').text();

        appendOrderEditRow(prodId, productName, catName, subcatName, price, qty);

        $('#edit_sel_product').val('');
        $('#edit_sel_price').val('');
        $('#edit_sel_qty').val(1);
    }

    function appendOrderEditRow(prodId, productName, catName, subcatName, price, qty) {
        var rowId = 'order_edit_row_' + orderRowCounter;
        var subtotal = (price * qty).toFixed(2);

        var html = '<tr id="' + rowId + '" class="product-row-edit">' +
            '<td>' +
                '<div class="text-semibold text-primary" style="font-size: 13px;">' + productName + '</div>' +
                '<div style="margin-top: 3px;">' +
                    (catName ? '<span class="label label-default" style="margin-right: 4px; font-size: 9.5px;">' + catName + '</span>' : '') +
                    (subcatName ? '<span class="label label-info" style="font-size: 9.5px;">' + subcatName + '</span>' : '') +
                '</div>' +
                '<input type="hidden" class="order-row-prod-id" name="products[' + orderRowCounter + '][product_id]" value="' + prodId + '">' +
            '</td>' +
            '<td>' +
                '<div class="input-group input-group-sm">' +
                    '<span class="input-group-addon">₹</span>' +
                    '<input type="number" step="0.01" min="0" name="products[' + orderRowCounter + '][price]" class="form-control order-row-price" required value="' + parseFloat(price).toFixed(2) + '" oninput="calculateOrderRow(this)">' +
                '</div>' +
            '</td>' +
            '<td>' +
                '<input type="number" min="1" name="products[' + orderRowCounter + '][quantity]" class="form-control input-sm order-row-qty" required value="' + qty + '" oninput="calculateOrderRow(this)">' +
            '</td>' +
            '<td>' +
                '<strong class="order-row-subtotal-text">₹' + subtotal + '</strong>' +
                '<input type="hidden" class="order-row-subtotal-val" value="' + subtotal + '">' +
            '</td>' +
            '<td class="text-center">' +
                '<button type="button" class="btn btn-xs btn-danger" onclick="removeOrderEditRow(\'' + rowId + '\')" title="Remove"><i class="icon-trash"></i></button>' +
            '</td>' +
        '</tr>';

        $('#orderEditRowsContainer').append(html);
        orderRowCounter++;
        calculateOrderTotals();
    }

    function calculateOrderRow(element) {
        var row = $(element).closest('tr.product-row-edit');
        var price = parseFloat(row.find('.order-row-price').val()) || 0;
        var qty = parseInt(row.find('.order-row-qty').val()) || 0;
        var subtotal = price * qty;

        row.find('.order-row-subtotal-text').text('₹' + subtotal.toFixed(2));
        row.find('.order-row-subtotal-val').val(subtotal);

        calculateOrderTotals();
    }

    function calculateOrderTotals() {
        var subtotal = 0;
        $('.order-row-subtotal-val').each(function() {
            subtotal += parseFloat($(this).val()) || 0;
        });

        $('#editSubtotalDisplay').text(subtotal.toFixed(2));

        var discount = 0;
        if(orderCoupon) {
            if(orderCoupon.min_order_amount > 0 && subtotal < orderCoupon.min_order_amount) {
                discount = 0;
            } else if(orderCoupon.discount_type === 'percentage') {
                discount = (subtotal * orderCoupon.discount_value) / 100;
                if(orderCoupon.max_discount_amount > 0 && discount > orderCoupon.max_discount_amount) {
                    discount = orderCoupon.max_discount_amount;
                }
            } else {
                discount = Math.min(subtotal, orderCoupon.discount_value);
            }
        }

        $('#editDiscountDisplay').text(discount.toFixed(2));
        var grandTotal = Math.max(0, subtotal - discount);
        $('#editGrandTotalDisplay').text(grandTotal.toFixed(2));
    }

    function removeOrderEditRow(rowId) {
        if($('tr.product-row-edit').length <= 1) {
            swal("Warning", "An order must contain at least one product.", "warning");
            return;
        }
        $('#' + rowId).remove();
        calculateOrderTotals();
    }

    function saveOrderItems() {
        if($('tr.product-row-edit').length === 0) {
            swal("Required", "An order must contain at least one product.", "warning");
            return;
        }

        var btn = $('#btnSaveOrderItems');
        var originalHtml = btn.html();
        btn.prop('disabled', true).html('<i class="icon-spinner2 spinner position-left"></i> Saving...');

        var formData = $('#orderItemsEditForm').serialize();

        $.ajax({
            url: "{{ route('admin.order.update_items', $order->id) }}",
            type: "POST",
            data: formData,
            success: function(response) {
                btn.prop('disabled', false).html(originalHtml);
                if(response.status) {
                    swal({
                        title: "Updated Successfully!",
                        text: response.message,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html(originalHtml);
                var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : "Error saving order items.";
                swal("Failed", msg, "error");
            }
        });
    }
@else
    function enableOrderEditMode() {
        swal("Locked", "This order cannot be edited because it is confirmed, processing, or paid.", "warning");
    }
@endif
</script>
@endsection
