@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Customer Orders') }}</span>
                <small class="display-block">Manage confirmed orders converted from inquiries or website</small>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li class="active">{{ __('Orders') }}</li>
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

    <div class="panel panel-flat">

        <div class="panel-heading">
            <div class="row">
                <div class="col-md-5">
                    @if(Auth::user()->isSuperAdmin())
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-user-check position-left"></i> Bulk Assign Seller <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @forelse($sellers as $seller)
                                    <li>
                                        <a href="javascript:void(0);" onclick="bulkAssignOrdersToSeller({{ $seller->id }}, '{{ addslashes($seller->name) }}')">
                                            Assign selected to <strong>{{ $seller->name }}</strong>
                                        </a>
                                    </li>
                                @empty
                                    <li class="disabled"><a href="#">No active sellers available</a></li>
                                @endforelse
                            </ul>
                        </div>
                    @else
                        <h5 class="panel-title"><strong>My Assigned Orders</strong></h5>
                    @endif
                </div>

                <div class="col-md-7 text-right">
                    <form method="GET" action="{{ route('admin.order.index') }}" class="form-inline" style="display: inline-block;">
                        @if(Auth::user()->isSuperAdmin())
                        <select name="seller_id" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="">-- All Sellers --</option>
                            <option value="unassigned" {{ request('seller_id') == 'unassigned' ? 'selected' : '' }}>Direct / Unassigned</option>
                            @foreach($sellers as $seller)
                                <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                    {{ $seller->name }}
                                </option>
                            @endforeach
                        </select>
                        @endif

                        <select name="order_status" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="">-- Order Status --</option>
                            <option value="pending" {{ request('order_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('order_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ request('order_status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="dispatched" {{ request('order_status') == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                            <option value="delivered" {{ request('order_status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ request('order_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        <select name="payment_status" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="">-- Payment Status --</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="link_sent" {{ request('payment_status') == 'link_sent' ? 'selected' : '' }}>Link Sent</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>

                        <select name="limit" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="15" {{ request('limit', 15) == 15 ? 'selected' : '' }}>Show 15</option>
                            <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>Show 25</option>
                            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>Show 50</option>
                            <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>Show 100</option>
                        </select>

                        <input type="text" name="search" class="form-control input-sm" placeholder="Order No / Phone..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-default btn-sm"><i class="icon-search4"></i></button>

                        @if(request()->hasAny(['search', 'seller_id', 'order_status', 'payment_status', 'limit']))
                            <a href="{{ route('admin.order.index') }}" class="btn btn-link btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="bg-slate-700">
                        @if(Auth::user()->isSuperAdmin())
                        <th width="3%" class="text-center">
                            <input type="checkbox" name="select_all" id="select_all_orders" class="styled" onclick="toggleSelectAllOrders(this)">
                        </th>
                        @endif
                        <th width="8%" class="text-center">Action</th>
                        <th width="12%">Order No</th>
                        <th width="18%">Customer Details</th>
                        <th width="12%">Items</th>
                        <th width="12%">Total Amount</th>
                        <th width="14%">Seller</th>
                        <th width="10%">Payment</th>
                        <th width="10%" class="text-center">Order Status</th>
                        <th width="11%">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $ord)
                    <tr>
                        @if(Auth::user()->isSuperAdmin())
                        <td class="text-center">
                            <input type="checkbox" class="order-checkbox styled" value="{{ $ord->id }}" id="ord_{{ $ord->id }}">
                        </td>
                        @endif
                        <td class="text-center">
                            <a href="{{ route('admin.order.show', $ord->id) }}" class="btn btn-xs btn-primary">
                                <i class="icon-eye"></i> View
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.order.show', $ord->id) }}">
                                <strong class="text-primary">{{ $ord->order_no }}</strong>
                            </a>
                            @if($ord->inquiry)
                                <div>
                                    <span class="text-muted text-size-mini">Inq: #{{ $ord->inquiry->inquiry_no }}</span>
                                </div>
                            @elseif($ord->order_source === 'website')
                                <div>
                                    <span class="label label-info" style="font-size: 9px; padding: 1px 5px;">WEBSITE DIRECT</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div><strong>{{ $ord->customer_name }}</strong></div>
                            <div class="text-success"><i class="icon-phone2 position-left"></i>{{ $ord->customer_phone }}</div>
                            @if($ord->city)
                                <div class="text-muted text-size-mini">{{ $ord->city }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="label label-default">{{ $ord->items->count() }} item(s)</span>
                        </td>
                        <td>
                            <strong style="font-size: 14px;">₹{{ number_format($ord->total_amount, 2) }}</strong>
                            @if($ord->discount_amount > 0)
                                <div class="text-success text-size-mini">
                                    Coupon: -₹{{ number_format($ord->discount_amount, 2) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($ord->seller)
                                <span class="label label-info" style="font-size: 11px; padding: 4px 8px;">
                                    <i class="icon-user position-left"></i>{{ $ord->seller->name }}
                                </span>
                            @else
                                <span class="label label-warning" style="font-size: 11px; padding: 4px 8px;" title="Website Direct Order - Not assigned yet">
                                    Direct / Unassigned
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($ord->payment_status === 'paid')
                                <span class="label label-success">Paid</span>
                            @elseif($ord->payment_status === 'link_sent')
                                <span class="label label-info">Link Sent</span>
                                @if($ord->payment_link)
                                    <div style="margin-top: 4px;">
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $ord->customer_phone);
                                            if(strlen($cleanPhone) === 10) $cleanPhone = '91' . $cleanPhone;
                                            $waText = "Hello {$ord->customer_name}, please complete payment of Rs. " . number_format($ord->total_amount, 2) . " for order #{$ord->order_no} via: {$ord->payment_link}";
                                        @endphp
                                        <a href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text={{ rawurlencode($waText) }}" target="_blank" class="btn btn-xs btn-success" title="Send Link on WhatsApp" style="background-color: #25D366; border-color: #25D366; padding: 1px 6px; font-size: 11px;">
                                            <i class="icon-bubble position-left" style="margin-right: 2px;"></i> WA
                                        </a>
                                        <button type="button" class="btn btn-xs btn-default" onclick="copyOrderLink('{{ $ord->payment_link }}', this)" title="Copy Payment Link" style="padding: 1px 6px; font-size: 11px;">
                                            <i class="icon-copy"></i>
                                        </button>
                                    </div>
                                @endif
                            @else
                                <span class="label label-warning">Pending</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($ord->order_status === 'delivered')
                                <span class="label label-success">Delivered</span>
                            @elseif($ord->order_status === 'dispatched')
                                <span class="label label-info">Dispatched</span>
                            @elseif($ord->order_status === 'processing')
                                <span class="label label-primary">Processing</span>
                            @elseif($ord->order_status === 'confirmed')
                                <span class="label label-success">Confirmed</span>
                            @elseif($ord->order_status === 'cancelled')
                                <span class="label label-danger">Cancelled</span>
                            @else
                                <span class="label label-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $ord->created_at ? $ord->created_at->format('d-m-Y') : '-' }}</div>
                            <div class="text-muted text-size-mini">{{ $ord->created_at ? $ord->created_at->format('h:i A') : '' }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->isSuperAdmin() ? 10 : 9 }}" class="text-center text-muted" style="padding: 30px;">
                            No orders found. Once inquiries are confirmed or website orders placed, they will appear here.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-right" style="margin-top: 15px;">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function() {
        $(".styled").uniform({
            radioClass: 'choice'
        });
    });

    function toggleSelectAllOrders(source) {
        $('.order-checkbox').prop('checked', source.checked);
        $.uniform.update('.order-checkbox');
    }

    $(document).on('change', '.order-checkbox', function() {
        var total = $('.order-checkbox').length;
        var checked = $('.order-checkbox:checked').length;
        $('#select_all_orders').prop('checked', total > 0 && total === checked);
        $.uniform.update('#select_all_orders');
    });

    function bulkAssignOrdersToSeller(sellerId, sellerName) {
        var ids = [];
        $('.order-checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            swal("Notice", "Please select at least one order using the checkbox first.", "info");
            return;
        }

        swal({
            title: "Assign " + ids.length + " orders?",
            text: "Assign selected orders to seller: " + sellerName + "?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#2196F3",
            confirmButtonText: "Yes, Assign!",
            cancelButtonText: "Cancel",
            closeOnConfirm: false
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "{{ route('admin.order.bulk_assign') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: ids,
                        seller_id: sellerId
                    },
                    success: function(response) {
                        if (response.status) {
                            swal({
                                title: "Assigned!",
                                text: response.message,
                                type: "success",
                                closeOnConfirm: true
                            }, function() {
                                location.reload();
                            });
                        } else {
                            swal({
                                title: "Error",
                                text: response.message,
                                type: "error",
                                closeOnConfirm: true
                            });
                        }
                    },
                    error: function() {
                        swal({
                            title: "Error!",
                            text: "Failed to assign orders",
                            type: "error",
                            closeOnConfirm: true
                        });
                    }
                });
            }
        });
    }

    function copyOrderLink(link, btn) {
        if (!link) return;
        if (navigator.clipboard) {
            navigator.clipboard.writeText(link).then(function() {
                var $btn = $(btn);
                var origHtml = $btn.html();
                $btn.html('<i class="icon-checkmark3 text-success"></i>');
                setTimeout(function() { $btn.html(origHtml); }, 1500);
            });
        } else {
            var temp = $('<input>');
            $('body').append(temp);
            temp.val(link).select();
            document.execCommand('copy');
            temp.remove();
            var $btn = $(btn);
            var origHtml = $btn.html();
            $btn.html('<i class="icon-checkmark3 text-success"></i>');
            setTimeout(function() { $btn.html(origHtml); }, 1500);
        }
    }
</script>
@endsection
