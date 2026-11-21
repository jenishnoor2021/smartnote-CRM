@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Inquiry') }}: {{ $inquiry->inquiry_no }}</span>
                <span class="label {{ $inquiry->status == 'confirmed' ? 'label-success' : ($inquiry->status == 'converted' ? 'bg-purple' : ($inquiry->status == 'cancelled' ? 'label-danger' : 'label-warning')) }}" style="font-size: 13px; margin-left: 10px;">
                    {{ strtoupper($inquiry->status) }}
                </span>
            </h4>
        </div>
        <div class="heading-elements">
            <a href="{{ route('admin.inquiry.quotation.pdf', $inquiry->id) }}" class="btn bg-danger btn-sm" title="Download Official PDF Quotation to send to customer">
                <i class="icon-file-pdf position-left"></i> Download PDF Quotation
            </a>
            <a href="{{ route('admin.inquiry.quotation.pdf', ['id' => $inquiry->id, 'action' => 'view']) }}" target="_blank" class="btn btn-default btn-sm" title="Preview PDF Quotation">
                <i class="icon-eye position-left"></i> Preview PDF
            </a>
            @if($inquiry->status !== 'converted')
                <a href="{{ route('admin.inquiry.edit', $inquiry->id) }}" class="btn btn-default btn-sm">
                    <i class="icon-pencil7 position-left"></i> Edit Inquiry
                </a>
            @else
                <a href="{{ route('admin.order.show', $inquiry->order->id ?? 0) }}" class="btn btn-success btn-sm">
                    <i class="icon-file-check position-left"></i> View Order #{{ $inquiry->order->order_no ?? '' }}
                </a>
            @endif
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.inquiry.index') }}">{{ __('Inquiries') }}</a></li>
            <li class="active">{{ $inquiry->inquiry_no }}</li>
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
    @if(session('error'))
        <div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {{ session('error') }}
        </div>
    @endif

    <!-- Alert: Other Inquiries from same customer (Merge Feature) -->
    @if($otherInquiries->count() > 0 && $inquiry->status !== 'converted' && $inquiry->status !== 'cancelled')
        <div class="alert alert-warning alert-styled-left alert-bordered" style="background-color: #fff9e6; border-color: #f59e0b; color: #92400e;">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            <h6 class="text-semibold" style="margin-top: 0; color: #b45309;">
                <i class="icon-stack2 position-left"></i> Customer has {{ $otherInquiries->count() }} other pending inquiry(s) from this phone number!
            </h6>
            <p>If customer wants to combine their separate inquiries into one single order, you can merge them below:</p>
            
            <form action="{{ route('admin.inquiry.merge', $inquiry->id) }}" method="POST" id="mergeForm" style="margin-top: 10px;">
                @csrf
                <div class="table-responsive bg-white" style="border: 1px solid #ffd591; border-radius: 4px; margin-bottom: 10px;">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="bg-slate-500">
                                <th width="5%" class="text-center">Select</th>
                                <th width="20%">Inquiry No</th>
                                <th width="15%">Date</th>
                                <th width="45%">Products</th>
                                <th width="15%">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($otherInquiries as $other)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="merge_inquiry_ids[]" value="{{ $other->id }}" class="styled" checked>
                                    </td>
                                    <td><strong>{{ $other->inquiry_no }}</strong></td>
                                    <td>{{ $other->created_at ? $other->created_at->format('d-m-Y') : '' }}</td>
                                    <td>
                                        @foreach($other->items as $oi)
                                            <span class="label label-default">{{ $oi->product_name }} (x{{ $oi->quantity }})</span>
                                        @endforeach
                                    </td>
                                    <td>₹{{ number_format($other->total_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Merge selected inquiries into {{ $inquiry->inquiry_no }}? All items will be combined.');">
                    <i class="icon-git-merge position-left"></i> Merge Inquiries into this Inquiry
                </button>
            </form>
        </div>
    @endif

    <div class="row">

        <!-- Left Column: Customer & Status & Conversion -->
        <div class="col-md-5">

            <!-- Customer Details Card -->
            <div class="panel panel-flat">
                <div class="panel-heading bg-slate-700">
                    <h6 class="panel-title"><i class="icon-user position-left"></i> Customer & Calling Info</h6>
                </div>
                <div class="panel-body">
                    <table class="table table-borderless table-striped">
                        <tr>
                            <td width="35%"><strong>Customer Name:</strong></td>
                            <td><strong style="font-size: 15px;">{{ $inquiry->customer_name }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Mobile / Phone:</strong></td>
                            <td>
                                <a href="tel:{{ $inquiry->customer_phone }}" class="btn btn-xs btn-success" style="font-size: 13px;">
                                    <i class="icon-phone2 position-left"></i> Call: {{ $inquiry->customer_phone }}
                                </a>
                            </td>
                        </tr>
                        @if($inquiry->customer_email)
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $inquiry->customer_email }}</td>
                        </tr>
                        @endif
                        @if($inquiry->address || $inquiry->city)
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>
                                {{ $inquiry->address }}
                                @if($inquiry->city)<br>{{ $inquiry->city }}@endif
                                @if($inquiry->pincode) - {{ $inquiry->pincode }}@endif
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Assigned Seller:</strong></td>
                            <td>
                                @if($inquiry->assignedSeller)
                                    <span class="label label-info"><i class="icon-user position-left"></i>{{ $inquiry->assignedSeller->name }}</span>
                                @else
                                    <span class="label label-warning">Unassigned</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created Date:</strong></td>
                            <td>{{ $inquiry->created_at ? $inquiry->created_at->format('d-m-Y h:i A') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Inquiry Status Control Card -->
            <div class="panel panel-flat">
                <div class="panel-heading bg-indigo-600">
                    <h6 class="panel-title"><i class="icon-cog5 position-left"></i> Manage Inquiry Status</h6>
                </div>
                <div class="panel-body">
                    @if($inquiry->status === 'converted')
                        <div class="alert alert-success alert-styled-left">
                            <i class="icon-checkmark4 position-left"></i>
                            This inquiry has been <strong>Converted to Order</strong> (#{{ $inquiry->order->order_no ?? '' }}).
                        </div>
                    @else
                        <div class="form-group">
                            <label class="text-semibold">Update Status:</label>
                            <select id="quickStatusSelect" class="form-control" onchange="onStatusSelectChange(this)">
                                <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending (Not Called)</option>
                                <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>Contacted / Discussion in Progress</option>
                                <option value="confirmed" {{ $inquiry->status == 'confirmed' ? 'selected' : '' }}>Confirmed by Customer</option>
                                <option value="cancelled" {{ $inquiry->status == 'cancelled' ? 'selected' : '' }}>Cancelled by Customer</option>
                            </select>
                        </div>

                        <!-- Cancel Reason Input (Shown if Cancelled) -->
                        <div id="cancelReasonBox" style="display: {{ $inquiry->status == 'cancelled' ? 'block' : 'none' }}; margin-bottom: 15px;">
                            <label class="text-semibold text-danger"><span class="text-danger">*</span> Reason for Cancellation:</label>
                            <textarea id="cancelReasonText" class="form-control" rows="2" placeholder="Why did the customer cancel? (e.g. Price too high, Bought elsewhere)">{{ $inquiry->cancel_reason }}</textarea>
                        </div>

                        <button type="button" class="btn btn-primary btn-sm btn-block" onclick="saveInquiryStatus()">
                            <i class="icon-check position-left"></i> Save Status Change
                        </button>
                    @endif
                </div>
            </div>

            <!-- Convert to Order & Apply Coupon Card -->
            @if($inquiry->status !== 'converted')
            <div class="panel panel-flat border-left-lg border-left-success">
                <div class="panel-heading bg-success">
                    <h6 class="panel-title"><i class="icon-cart-check position-left"></i> Confirm & Convert to Order</h6>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.inquiry.convert_order', $inquiry->id) }}" method="POST" id="convertOrderForm">
                        @csrf
                        
                        <!-- Pricing Calculation Summary -->
                        <div class="well well-sm" style="background-color: #f7fafc;">
                            <div class="row">
                                <div class="col-xs-6 text-muted">Items Subtotal:</div>
                                <div class="col-xs-6 text-right">
                                    <strong>₹<span id="orderSubtotalDisplay">{{ number_format($inquiry->subtotal, 2) }}</span></strong>
                                    <input type="hidden" id="orderSubtotalVal" value="{{ $inquiry->subtotal }}">
                                </div>
                            </div>
                            <div class="row text-success" id="couponDiscountRow" style="display: {{ $inquiry->discount_amount > 0 ? 'block' : 'none' }}; margin-top: 5px;">
                                <div class="col-xs-6">
                                    <i class="icon-price-tag2 position-left"></i> Coupon Discount:
                                </div>
                                <div class="col-xs-6 text-right">
                                    -₹<span id="couponDiscountDisplay">{{ number_format($inquiry->discount_amount, 2) }}</span>
                                </div>
                            </div>
                            <hr style="margin: 8px 0;">
                            <div class="row" style="font-size: 16px;">
                                <div class="col-xs-6"><strong>Final Payable:</strong></div>
                                <div class="col-xs-6 text-right text-primary">
                                    <strong>₹<span id="finalTotalDisplay">{{ number_format($inquiry->total_amount, 2) }}</span></strong>
                                </div>
                            </div>
                        </div>

                        <!-- Apply Coupon Section (Seller discount flow) -->
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label class="text-semibold">
                                <i class="icon-price-tag position-left text-muted"></i> Discount Coupon Code:
                            </label>
                            <div class="input-group">
                                <input type="text" name="coupon_code" id="couponCodeInput" class="form-control text-uppercase" placeholder="Enter coupon code (from Admin)" value="{{ $inquiry->coupon_code }}" style="font-weight: bold; letter-spacing: 1px;">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" onclick="applyCouponCode()">Apply</button>
                                </span>
                            </div>
                            <div id="couponStatusMessage" style="margin-top: 4px;">
                                @if($inquiry->coupon_code)
                                    <span class="text-success"><i class="icon-checkmark-circle position-left"></i> Applied: {{ $inquiry->coupon_code }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Payment Mode:</label>
                            <select name="payment_method" class="form-control">
                                <option value="razorpay_link">Razorpay Payment Link (Online UPI / Card)</option>
                                <option value="bank_transfer">Direct Bank Transfer</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Order Note / Instructions:</label>
                            <textarea name="order_notes" class="form-control" rows="2" placeholder="e.g. Call before delivery, morning delivery only">{{ $inquiry->general_note }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-block btn-lg" onclick="return confirm('Are you sure you want to confirm and generate Order for {{ $inquiry->customer_name }}?');">
                            <i class="icon-checkmark4 position-left"></i> Convert to Order Now
                        </button>
                    </form>
                </div>
            </div>
            @endif

        </div>

        <!-- Right Column: Products & Call Notes History -->
        <div class="col-md-7">

            <!-- Products Card -->
            <div class="panel panel-flat">
                <div class="panel-heading bg-slate-700" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px;">
                    <h6 class="panel-title" style="margin: 0;"><i class="icon-books position-left"></i> Inquiry Products ({{ $inquiry->items->count() }})</h6>
                    <div>
                        <a href="{{ route('admin.inquiry.quotation.pdf', $inquiry->id) }}" class="btn btn-xs bg-danger-400 text-white" title="Download PDF Quotation">
                            <i class="icon-file-pdf position-left"></i> Download Quotation PDF
                        </a>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="bg-slate-600">
                                <th>Product Name</th>
                                <th width="15%" class="text-right">Price</th>
                                <th width="12%" class="text-center">Qty</th>
                                <th width="20%" class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inquiry->items as $item)
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
                                <th class="text-right">₹{{ number_format($inquiry->subtotal, 2) }}</th>
                            </tr>
                            @if($inquiry->discount_amount > 0)
                            <tr class="text-success">
                                <th colspan="3" class="text-right">
                                    Coupon Discount ({{ $inquiry->coupon_code }}):
                                </th>
                                <th class="text-right">-₹{{ number_format($inquiry->discount_amount, 2) }}</th>
                            </tr>
                            @endif
                            <tr style="font-size: 15px;" class="bg-slate-100">
                                <th colspan="3" class="text-right">Total Payable:</th>
                                <th class="text-right text-primary">₹{{ number_format($inquiry->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Call Notes & Discussion Timeline Card -->
            <div class="panel panel-flat">
                <div class="panel-heading bg-slate-700">
                    <h6 class="panel-title"><i class="icon-bubble-dots4 position-left"></i> Call Notes & Interaction Log</h6>
                </div>
                <div class="panel-body">
                    
                    <!-- Add Note Form -->
                    <div class="well well-sm" style="background-color: #f8fafc; border-color: #e2e8f0;">
                        <h6 class="text-semibold" style="margin-top: 0;"><i class="icon-plus-circle2 position-left"></i> Record Customer Call / Remark:</h6>
                        <div class="form-group">
                            <textarea id="newNoteText" class="form-control" rows="2" placeholder="e.g. Called customer, customer asked for 10% discount on total. Said will discuss with family."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-7">
                                <select id="noteUpdateStatus" class="form-control input-sm">
                                    <option value="">(Keep current status)</option>
                                    <option value="contacted">Mark as Contacted</option>
                                    <option value="confirmed">Mark as Confirmed</option>
                                    <option value="cancelled">Mark as Cancelled</option>
                                </select>
                            </div>
                            <div class="col-xs-5 text-right">
                                <button type="button" class="btn btn-primary btn-sm" onclick="submitCallNote()">
                                    <i class="icon-paperplane position-left"></i> Add Note
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Timeline -->
                    <div class="timeline timeline-left content-group" id="notesTimelineContainer" style="margin-top: 20px;">
                        @forelse($inquiry->notes as $note)
                            <div class="timeline-row">
                                <div class="timeline-icon bg-primary">
                                    <i class="icon-comment"></i>
                                </div>
                                <div class="panel panel-flat timeline-content" style="margin-bottom: 12px; border-left: 3px solid #2196F3;">
                                    <div class="panel-body" style="padding: 10px 15px;">
                                        <div class="text-muted text-size-mini">
                                            <strong>{{ $note->user->name ?? 'User' }}</strong> 
                                            <span class="label label-default" style="font-size: 9px; padding: 1px 4px;">{{ ucfirst($note->user->role ?? 'Admin') }}</span>
                                            <span class="pull-right">{{ $note->created_at ? $note->created_at->format('d-m-Y h:i A') : '' }}</span>
                                        </div>
                                        <div style="margin-top: 6px; font-size: 13px;">
                                            {{ $note->note }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center" id="noNotesPlaceholder">No call notes recorded yet. Add your first call update above.</p>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection

@section('script')
<script type="text/javascript">
    function onStatusSelectChange(selectElem) {
        if($(selectElem).val() === 'cancelled') {
            $('#cancelReasonBox').slideDown();
        } else {
            $('#cancelReasonBox').slideUp();
        }
    }

    function saveInquiryStatus() {
        var status = $('#quickStatusSelect').val();
        var cancelReason = $('#cancelReasonText').val();

        if(status === 'cancelled' && !cancelReason.trim()) {
            swal("Cancel Reason Required", "Please enter why the customer cancelled the inquiry.", "warning");
            return;
        }

        $.ajax({
            url: "{{ route('admin.inquiry.update_status', $inquiry->id) }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: status,
                cancel_reason: cancelReason
            },
            success: function(response) {
                if(response.status) {
                    swal({
                        title: "Updated!",
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
                var msg = "Failed to update status";
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                swal("Error", msg, "error");
            }
        });
    }

    function submitCallNote() {
        var note = $('#newNoteText').val();
        var statusUpdate = $('#noteUpdateStatus').val();

        if(!note.trim()) {
            swal("Empty Note", "Please enter some notes about your conversation with the customer.", "info");
            return;
        }

        $.ajax({
            url: "{{ route('admin.inquiry.add_note', $inquiry->id) }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                note: note,
                update_status: statusUpdate
            },
            success: function(response) {
                if(response.status) {
                    $('#newNoteText').val('');
                    $('#noNotesPlaceholder').remove();

                    var noteHtml = '<div class="timeline-row">' +
                        '<div class="timeline-icon bg-primary"><i class="icon-comment"></i></div>' +
                        '<div class="panel panel-flat timeline-content" style="margin-bottom: 12px; border-left: 3px solid #2196F3;">' +
                            '<div class="panel-body" style="padding: 10px 15px;">' +
                                '<div class="text-muted text-size-mini">' +
                                    '<strong>' + response.note.user_name + '</strong> ' +
                                    '<span class="pull-right">' + response.note.created_at + '</span>' +
                                '</div>' +
                                '<div style="margin-top: 6px; font-size: 13px;">' + response.note.note + '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';

                    $('#notesTimelineContainer').prepend(noteHtml);

                    swal({
                        title: "Recorded!",
                        text: "Call note added successfully.",
                        type: "success",
                        timer: 1200,
                        showConfirmButton: false
                    });

                    if(response.new_status && response.new_status !== '{{ $inquiry->status }}') {
                        setTimeout(function() {
                            location.reload();
                        }, 1300);
                    }
                }
            },
            error: function() {
                swal("Error", "Failed to add note", "error");
            }
        });
    }

    function applyCouponCode() {
        var code = $('#couponCodeInput').val().trim();
        var subtotal = parseFloat($('#orderSubtotalVal').val()) || 0;

        if(!code) {
            swal("Notice", "Please enter a coupon code provided by Admin.", "info");
            return;
        }

        $.ajax({
            url: "{{ route('admin.inquiry.validate_coupon') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                code: code,
                subtotal: subtotal
            },
            success: function(response) {
                if(response.status) {
                    $('#couponDiscountRow').slideDown();
                    $('#couponDiscountDisplay').text(response.discount_amount.toFixed(2));
                    $('#finalTotalDisplay').text(response.final_total.toFixed(2));
                    $('#couponStatusMessage').html(
                        '<span class="text-success text-semibold"><i class="icon-checkmark-circle position-left"></i> Coupon Applied: ' + 
                        (response.type === 'percentage' ? response.amount + '% Off' : '₹' + response.amount + ' Off') + 
                        ' (Discount: ₹' + response.discount_amount.toFixed(2) + ')</span>'
                    );

                    swal("Success!", "Coupon applied! Discount: ₹" + response.discount_amount.toFixed(2), "success");
                }
            },
            error: function(xhr) {
                var msg = "Invalid coupon code";
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('#couponStatusMessage').html('<span class="text-danger"><i class="icon-cross2 position-left"></i> ' + msg + '</span>');
                swal("Invalid Coupon", msg, "error");
            }
        });
    }
</script>
@endsection

