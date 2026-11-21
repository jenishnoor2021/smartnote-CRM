@extends('layouts.admin')
@section('content')
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Discount Coupons') }}</span>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
            </li>
            <li class="active">{{ __('Coupons') }}</li>
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

    <div class="panel panel-flat">

        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('admin.coupon.create') }}" class="btn btn-primary btn-sm">Add New Coupon <i class="icon-plus-circle2 position-right"></i></a>
                    <a href="javascript:delete_selected();" class="btn btn-danger btn-sm" id="delete_selected">Delete Selected <i class="icon-trash position-right"></i></a>
                </div>
                <div class="col-md-6 text-right">
                    <form method="GET" action="{{ route('admin.coupon.index') }}" class="form-inline" style="display: inline-block;">
                        <select name="status" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="">-- All Status --</option>
                            <option value="unused" {{ request('status') == 'unused' ? 'selected' : '' }}>Unused Only</option>
                            <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Used Only</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                        </select>
                        <select name="limit" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="15" {{ request('limit', 15) == 15 ? 'selected' : '' }}>Show 15</option>
                            <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>Show 25</option>
                            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>Show 50</option>
                            <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>Show 100</option>
                        </select>
                        <input type="text" name="search" class="form-control input-sm" placeholder="Search Code..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-default btn-sm"><i class="icon-search4"></i></button>
                        @if(request()->hasAny(['status', 'search', 'limit']))
                            <a href="{{ route('admin.coupon.index') }}" class="btn btn-link btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="panel-body table-responsive">
            <table id="coupon_table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="bg-slate-700">
                        <th width="3%" class="text-center">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th width="8%" class="text-center">Actions</th>
                        <th width="12%">Coupon Code</th>
                        <th width="10%">Type</th>
                        <th width="10%">Discount Value</th>
                        <th width="10%">Min Order</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="12%">Usage</th>
                        <th width="12%">Expires On</th>
                        <th width="13%">Created By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                    <tr>
                        <td class="text-center">
                            @if(!$coupon->is_used)
                                <input type="checkbox" class="checkbox styled" name="delete" id="{{ $coupon->id }}">
                            @else
                                <span class="text-muted" title="Used coupon cannot be deleted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="Edit" href="{{ route('admin.coupon.edit', $coupon->id) }}" class="text-info" style="margin-right: 8px;">
                                <i class="icon-pencil7"></i>
                            </a>
                            @if(!$coupon->is_used)
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record({{ $coupon->id }});" class="text-danger">
                                <i class="icon-trash"></i>
                            </a>
                            @endif
                        </td>
                        <td>
                            <strong class="text-primary" style="font-size: 14px; letter-spacing: 1px;">
                                <i class="icon-price-tag2 position-left text-muted"></i>{{ $coupon->code }}
                            </strong>
                            @if($coupon->notes)
                                <div class="text-muted text-size-small">{{ $coupon->notes }}</div>
                            @endif
                        </td>
                        <td>
                            @if($coupon->type === 'percentage')
                                <span class="label label-info">Percentage (%)</span>
                            @else
                                <span class="label label-primary">Fixed (₹)</span>
                            @endif
                        </td>
                        <td>
                            <strong>
                                @if($coupon->type === 'percentage')
                                    {{ $coupon->amount }}%
                                    @if($coupon->max_discount_amount)
                                        <div class="text-size-small text-muted">(Max: ₹{{ number_format($coupon->max_discount_amount, 2) }})</div>
                                    @endif
                                @else
                                    ₹{{ number_format($coupon->amount, 2) }}
                                @endif
                            </strong>
                        </td>
                        <td>
                            @if($coupon->min_order_amount > 0)
                                ₹{{ number_format($coupon->min_order_amount, 2) }}
                            @else
                                <span class="text-muted">None</span>
                            @endif
                        </td>
                        <td class="text-center switchery-sm">
                            <input type="checkbox" onchange="change_status(this);" class="switchery"
                                id="{{ $coupon->id }}" {{ $coupon->is_active == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            @if($coupon->is_used)
                                <span class="label label-danger">Used</span>
                                @if($coupon->order_id)
                                    <div class="text-size-small text-muted" style="margin-top: 3px;">
                                        Order #{{ $coupon->order->order_no ?? $coupon->order_id }}
                                    </div>
                                @endif
                            @else
                                <span class="label label-success">Available</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->expires_at)
                                @if($coupon->expires_at->isPast())
                                    <span class="text-danger" title="Expired">{{ $coupon->expires_at->format('d-m-Y') }} (Expired)</span>
                                @else
                                    <span class="text-success">{{ $coupon->expires_at->format('d-m-Y') }}</span>
                                @endif
                            @else
                                <span class="text-muted">No Expiry</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $coupon->creator->name ?? 'Admin' }}</div>
                            <div class="text-size-mini text-muted">{{ $coupon->created_at ? $coupon->created_at->format('d-m-Y') : '' }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted" style="padding: 25px;">No coupons found. Click "Add New Coupon" to create one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-right" style="margin-top: 15px;">
                {{ $coupons->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function select_all(obj) {
        if (obj.checked) {
            $('.checkbox').prop('checked', true);
            $.uniform.update('.checkbox');
        } else {
            $('.checkbox').prop('checked', false);
            $.uniform.update('.checkbox');
        }
    }

    function change_status(obj) {
        var checked = 0;
        if (obj.checked) {
            checked = 1;
        }

        $.ajax({
            url: '{{ route("admin.coupon.update_status") }}',
            type: 'POST',
            data: {
                coupon_id: obj.id,
                is_active: checked,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    swal({
                        title: response.message,
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    swal({
                        title: "Failed to update status",
                        type: "error"
                    });
                }
            },
            error: function() {
                jGrowlAlert("An error occurred while updating status.", 'error');
            }
        });
    }

    function delete_record(id) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this coupon!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#EF5350",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel",
            closeOnConfirm: false
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "{{ url('admin/coupon/destroy') }}/" + id,
                    type: "DELETE",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.status) {
                            $("#" + id).closest("tr").remove();
                            swal({
                                title: "Deleted!",
                                text: response.message,
                                type: "success",
                                closeOnConfirm: true
                            }, function() {
                                swal.close();
                            });
                        } else {
                            swal({
                                title: "Cannot Delete",
                                text: response.message,
                                type: "error",
                                closeOnConfirm: true
                            });
                        }
                    },
                    error: function(xhr) {
                        var msg = "Failed to delete coupon";
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        swal({
                            title: "Error!",
                            text: msg,
                            type: "error",
                            closeOnConfirm: true
                        });
                    }
                });
            }
        });
    }

    function delete_selected() {
        var ids = [];
        $('.checkbox:checked').each(function() {
            var id = $(this).attr('id');
            if (id) {
                ids.push(id);
            }
        });

        if(ids.length === 0) {
            swal({
                title: "Notice",
                text: "Please select at least one coupon to delete.",
                type: "info",
                closeOnConfirm: true
            });
            return;
        }

        swal({
            title: "Delete " + ids.length + " selected coupons?",
            text: "This action cannot be undone!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#EF5350",
            confirmButtonText: "Yes, delete selected!",
            cancelButtonText: "Cancel",
            closeOnConfirm: false
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "{{ route('admin.coupon.delete.multiple') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        ids: ids
                    },
                    success: function(response) {
                        if(response.status) {
                            $(ids).each(function(index, element) {
                                $("#" + element).closest("tr").remove();
                            });
                            swal({
                                title: "Deleted!",
                                text: response.message,
                                type: "success",
                                closeOnConfirm: true
                            }, function() {
                                swal.close();
                            });
                        } else {
                            swal({
                                title: "Error!",
                                text: response.message,
                                type: "error",
                                closeOnConfirm: true
                            });
                        }
                    },
                    error: function() {
                        swal({
                            title: "Error!",
                            text: "Failed to delete selected coupons",
                            type: "error",
                            closeOnConfirm: true
                        });
                    }
                });
            }
        });
    }
</script>
@endsection

