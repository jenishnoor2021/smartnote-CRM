@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Product Inquiries') }}</span>
                <small class="display-block">Manage customer inquiries, assign to sellers & convert to orders</small>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li class="active">{{ __('Inquiries') }}</li>
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

    <!-- Status Tabs / Counters -->
    <div class="row mb-15" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <div class="btn-group btn-group-justified">
                <a href="{{ route('admin.inquiry.index') }}" class="btn {{ !request('status') ? 'btn-primary' : 'btn-default' }}">
                    All <span class="badge badge-info">{{ $statusCounts['all'] }}</span>
                </a>
                <a href="{{ route('admin.inquiry.index', array_merge(request()->query(), ['status' => 'pending'])) }}" class="btn {{ request('status') == 'pending' ? 'btn-primary' : 'btn-default' }}">
                    Pending <span class="badge badge-warning">{{ $statusCounts['pending'] }}</span>
                </a>
                <a href="{{ route('admin.inquiry.index', array_merge(request()->query(), ['status' => 'contacted'])) }}" class="btn {{ request('status') == 'contacted' ? 'btn-primary' : 'btn-default' }}">
                    Contacted <span class="badge badge-info">{{ $statusCounts['contacted'] }}</span>
                </a>
                <a href="{{ route('admin.inquiry.index', array_merge(request()->query(), ['status' => 'confirmed'])) }}" class="btn {{ request('status') == 'confirmed' ? 'btn-primary' : 'btn-default' }}">
                    Confirmed <span class="badge badge-success">{{ $statusCounts['confirmed'] }}</span>
                </a>
                <a href="{{ route('admin.inquiry.index', array_merge(request()->query(), ['status' => 'converted'])) }}" class="btn {{ request('status') == 'converted' ? 'btn-primary' : 'btn-default' }}">
                    Converted <span class="badge bg-purple">{{ $statusCounts['converted'] }}</span>
                </a>
                <a href="{{ route('admin.inquiry.index', array_merge(request()->query(), ['status' => 'cancelled'])) }}" class="btn {{ request('status') == 'cancelled' ? 'btn-primary' : 'btn-default' }}">
                    Cancelled <span class="badge badge-danger">{{ $statusCounts['cancelled'] }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="panel panel-flat">

        <div class="panel-heading">
            <div class="row">
                <div class="col-md-5">
                    <a href="{{ route('admin.inquiry.create') }}" class="btn btn-primary btn-sm">
                        <i class="icon-plus-circle2 position-left"></i> Add New Inquiry
                    </a>

                    @if(Auth::user()->isSuperAdmin())
                        <div class="btn-group" style="margin-left: 10px;">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-user-check position-left"></i> Bulk Assign Seller <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @forelse($sellers as $seller)
                                    <li>
                                        <a href="javascript:void(0);" onclick="bulkAssignToSeller({{ $seller->id }}, '{{ addslashes($seller->name) }}')">
                                            Assign to <strong>{{ $seller->name }}</strong>
                                        </a>
                                    </li>
                                @empty
                                    <li class="disabled"><a href="#">No sellers available</a></li>
                                @endforelse
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="col-md-7 text-right">
                    <form method="GET" action="{{ route('admin.inquiry.index') }}" class="form-inline" style="display: inline-block;">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif

                        @if(Auth::user()->isSuperAdmin())
                        <select name="seller_id" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="">-- All Sellers --</option>
                            <option value="unassigned" {{ request('seller_id') == 'unassigned' ? 'selected' : '' }}>Unassigned Only</option>
                            @foreach($sellers as $seller)
                                <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                                    {{ $seller->name }}
                                </option>
                            @endforeach
                        </select>
                        @endif

                        <select name="limit" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="15" {{ request('limit', 15) == 15 ? 'selected' : '' }}>Show 15</option>
                            <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>Show 25</option>
                            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>Show 50</option>
                            <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>Show 100</option>
                        </select>

                        <input type="text" name="search" class="form-control input-sm" placeholder="Search Customer / Phone / INQ..." value="{{ request('search') }}" style="width: 220px;">
                        <button type="submit" class="btn btn-default btn-sm"><i class="icon-search4"></i></button>

                        @if(request()->hasAny(['search', 'seller_id', 'status', 'limit']))
                            <a href="{{ route('admin.inquiry.index') }}" class="btn btn-link btn-sm">Reset</a>
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
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="toggleSelectAll(this)">
                        </th>
                        @endif
                        <th width="8%" class="text-center">Actions</th>
                        <th width="12%">Inquiry No</th>
                        <th width="18%">Customer Details</th>
                        <th width="20%">Products (Items)</th>
                        <th width="10%">Total Amount</th>
                        <th width="12%">Assigned Seller</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="10%">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inq)
                    <tr>
                        @if(Auth::user()->isSuperAdmin())
                        <td class="text-center">
                            @if($inq->status !== 'converted' && $inq->status !== 'cancelled')
                                <input type="checkbox" class="inq-checkbox styled" value="{{ $inq->id }}" id="inq_{{ $inq->id }}">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        @endif
                        <td class="text-center" style="white-space: nowrap;">
                            <a href="{{ route('admin.inquiry.show', $inq->id) }}" class="btn btn-xs btn-primary" title="View & Process Inquiry" style="margin-right: 4px;">
                                <i class="icon-eye"></i> View
                            </a>
                            <a href="{{ route('admin.inquiry.quotation.pdf', $inq->id) }}" class="btn btn-xs btn-danger" title="Download PDF Quotation" style="margin-right: 4px;">
                                <i class="icon-file-pdf"></i> PDF
                            </a>
                            @if($inq->status !== 'converted')
                                <a href="{{ route('admin.inquiry.edit', $inq->id) }}" class="text-info" title="Edit Products/Customer" style="margin-right: 4px;">
                                    <i class="icon-pencil7"></i>
                                </a>
                            @endif
                            @if(Auth::user()->isSuperAdmin() && $inq->status !== 'converted')
                                <a href="javascript:deleteInquiry({{ $inq->id }});" class="text-danger" title="Delete">
                                    <i class="icon-trash"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.inquiry.show', $inq->id) }}">
                                <strong class="text-primary">{{ $inq->inquiry_no }}</strong>
                            </a>
                            <div>
                                <span class="label label-default" style="font-size: 10px;">{{ strtoupper($inq->source) }}</span>
                            </div>
                        </td>
                        <td>
                            <div><strong style="font-size: 13px;">{{ $inq->customer_name }}</strong></div>
                            <div style="margin-top: 3px;">
                                <a href="tel:{{ $inq->customer_phone }}" class="text-success text-semibold" title="Click to call">
                                    <i class="icon-phone2 position-left"></i>{{ $inq->customer_phone }}
                                </a>
                            </div>
                            @if($inq->city)
                                <div class="text-muted text-size-mini"><i class="icon-location4 position-left"></i>{{ $inq->city }}</div>
                            @endif
                        </td>
                        <td>
                            <ul class="list-unstyled" style="margin-bottom: 0;">
                                @foreach($inq->items->take(3) as $item)
                                    <li>
                                        <i class="icon-arrow-right5 text-muted position-left"></i>
                                        {{ Str::limit($item->product_name, 28) }}
                                        <span class="text-muted">x {{ $item->quantity }}</span>
                                    </li>
                                @endforeach
                                @if($inq->items->count() > 3)
                                    <li class="text-muted text-size-small" style="margin-top: 2px;">
                                        <em>+ {{ $inq->items->count() - 3 }} more item(s)...</em>
                                    </li>
                                @endif
                            </ul>
                        </td>
                        <td>
                            <strong style="font-size: 14px;">₹{{ number_format($inq->total_amount, 2) }}</strong>
                            @if($inq->discount_amount > 0)
                                <div class="text-success text-size-mini">
                                    Saved: ₹{{ number_format($inq->discount_amount, 2) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($inq->assignedSeller)
                                <span class="label label-info" style="font-size: 11px; padding: 4px 8px;">
                                    <i class="icon-user position-left"></i>{{ $inq->assignedSeller->name }}
                                </span>
                            @else
                                <span class="label label-warning" style="font-size: 11px; padding: 4px 8px;">
                                    Unassigned
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($inq->status === 'pending')
                                <span class="label label-warning">Pending</span>
                            @elseif($inq->status === 'contacted')
                                <span class="label label-info">Contacted</span>
                            @elseif($inq->status === 'confirmed')
                                <span class="label label-success">Confirmed</span>
                            @elseif($inq->status === 'converted')
                                <span class="label bg-purple">Converted</span>
                            @elseif($inq->status === 'cancelled')
                                <span class="label label-danger">Cancelled</span>
                            @elseif($inq->status === 'merged')
                                <span class="label label-default">Merged</span>
                            @else
                                <span class="label label-default">{{ ucfirst($inq->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $inq->created_at ? $inq->created_at->format('d-m-Y') : '-' }}</div>
                            <div class="text-muted text-size-mini">{{ $inq->created_at ? $inq->created_at->format('h:i A') : '' }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->isSuperAdmin() ? 9 : 8 }}" class="text-center text-muted" style="padding: 30px;">
                            <i class="icon-folder-open text-muted" style="font-size: 30px; display: block; margin-bottom: 10px;"></i>
                            No inquiries found. Click "Add New Inquiry" to create one.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-right" style="margin-top: 15px;">
                {{ $inquiries->appends(request()->query())->links() }}
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

    function toggleSelectAll(source) {
        $('.inq-checkbox').prop('checked', source.checked);
        $.uniform.update('.inq-checkbox');
    }

    $(document).on('change', '.inq-checkbox', function() {
        var total = $('.inq-checkbox').length;
        var checked = $('.inq-checkbox:checked').length;
        $('#select_all').prop('checked', total > 0 && total === checked);
        $.uniform.update('#select_all');
    });

    function bulkAssignToSeller(sellerId, sellerName) {
        var ids = [];
        $('.inq-checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            swal("Notice", "Please select at least one inquiry using the checkbox first.", "info");
            return;
        }

        swal({
            title: "Assign " + ids.length + " inquiries?",
            text: "Assign selected inquiries to seller: " + sellerName + "?",
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
                    url: "{{ route('admin.inquiry.bulk_assign') }}",
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
                            text: "Failed to assign inquiries",
                            type: "error",
                            closeOnConfirm: true
                        });
                    }
                });
            }
        });
    }

    function deleteInquiry(id) {
        swal({
            title: "Are you sure?",
            text: "This inquiry will be deleted permanently!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#EF5350",
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "Cancel",
            closeOnConfirm: false
        },
        function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "{{ url('admin/inquiry/destroy') }}/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#inq-row-" + id).remove();
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
                                title: "Error",
                                text: response.message || "Failed to delete inquiry",
                                type: "error",
                                closeOnConfirm: true
                            });
                        }
                    },
                    error: function() {
                        swal({
                            title: "Error!",
                            text: "Failed to delete inquiry",
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

