@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Distributor / Dealer Applications') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li class="active">{{ __('Distributor Applications') }}</li>
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
                <div class="col-md-6">
                    <a href="javascript:delete_selected();" class="btn btn-danger" id="delete_selected">
                        Delete Selected <i class="icon-trash position-right"></i>
                    </a>
                </div>
                <div class="col-md-6 text-right">
                    <form method="GET" action="{{ route('admin.distributor.index') }}" class="form-inline">
                        <select name="status" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="">-- All Statuses --</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <select name="limit" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="20" {{ request('limit', 20) == 20 ? 'selected' : '' }}>Show 20</option>
                            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>Show 50</option>
                            <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>Show 100</option>
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search trader, firm, phone, city..." class="form-control input-sm" style="width: 240px;">
                        <button type="submit" class="btn btn-default btn-sm"><i class="icon-search4"></i></button>
                        @if(request()->hasAny(['status', 'search', 'limit']))
                            <a href="{{ route('admin.distributor.index') }}" class="btn btn-link btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="panel-body table-responsive">
            <table id="distributor_table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="bg-slate-700">
                        <th width="2%" class="text-center">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th width="8%" class="text-center">Actions</th>
                        <th width="18%">Trader / Firm Name</th>
                        <th width="15%">Phone / Email</th>
                        <th width="14%">City / Address</th>
                        <th width="14%">Business Type / GST</th>
                        <th width="10%">Experience</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="8%" class="text-center">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox styled" name="delete" id="{{ $app->id }}">
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="View Details" href="{{ route('admin.distributor.show', $app->id) }}" class="text-info" style="margin-right: 8px;">
                                <i class="icon-eye"></i>
                            </a>
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record({{ $app->id }});" class="text-danger delete" id="{{ $app->id }}">
                                <i class="icon-trash"></i>
                            </a>
                        </td>
                        <td>
                            <strong>{{ $app->trader_name }}</strong>
                            @if($app->firm_name)
                                <div class="text-muted"><i class="icon-store2 text-size-mini"></i> {{ $app->firm_name }}</div>
                            @endif
                        </td>
                        <td>
                            <div><i class="icon-phone text-size-mini text-muted"></i> <a href="tel:{{ $app->phone }}">{{ $app->phone }}</a></div>
                            @if($app->email)
                                <div><i class="icon-mail5 text-size-mini text-muted"></i> <a href="mailto:{{ $app->email }}">{{ $app->email }}</a></div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $app->city }}</strong>
                            @if($app->address)
                                <div class="text-muted text-size-mini">{{ Str::limit($app->address, 40) }}</div>
                            @endif
                        </td>
                        <td>
                            {{ $app->business_type ?? '-' }}
                            @if($app->gst_number)
                                <div class="text-muted text-size-mini">GST: {{ $app->gst_number }}</div>
                            @endif
                        </td>
                        <td>{{ $app->experience_years ? $app->experience_years . ' Years' : '-' }}</td>
                        <td class="text-center">
                            @if($app->status == 'pending')
                                <span class="label label-warning">PENDING</span>
                            @elseif($app->status == 'contacted')
                                <span class="label label-info">CONTACTED</span>
                            @elseif($app->status == 'approved')
                                <span class="label label-success">APPROVED</span>
                            @else
                                <span class="label label-danger">REJECTED</span>
                            @endif
                        </td>
                        <td class="text-center text-size-mini">
                            {{ $app->created_at ? $app->created_at->format('d-m-Y') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No distributor applications found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-right" style="margin-top: 15px;">
                {{ $applications->links() }}
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

    function delete_record(id) {
        swal({
            title: "Are you sure you want to delete this record?",
            text: "You will not be able to recover this record after deletion.",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "No, Cancel It",
            confirmButtonText: "Yes, I am sure",
            confirmButtonColor: "#EF5350",
            closeOnConfirm: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '/admin/distributor-application/' + id,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#" + id).closest("tr").remove();
                            swal({
                                title: "Application deleted successfully.",
                                type: "success",
                                closeOnConfirm: true
                            }, function() {
                                swal.close();
                            });
                        } else {
                            swal({
                                title: response.message || "An error occurred while deleting record.",
                                type: "error",
                                closeOnConfirm: true
                            });
                        }
                    },
                    error: function(xhr) {
                        jGrowlAlert("An error occurred", 'error');
                    },
                });
            }
        });
    }

    function delete_selected() {
        var ids = [];

        $(".checkbox:checked").each(function() {
            var id = $(this).attr('id');
            if (id) {
                ids.push(id);
            }
        });

        if (ids.length === 0) {
            jGrowlAlert("Please select some records to delete.", 'danger');
            return;
        }

        swal({
            title: "Are you sure you want to delete selected records?",
            text: "You will not be able to recover these records after deletion.",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "No, Cancel It",
            confirmButtonText: "Yes, I am sure",
            confirmButtonColor: "#EF5350",
            closeOnConfirm: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: '{{ route("admin.distributor.delete_multiple") }}',
                    type: 'POST',
                    data: {
                        ids: ids,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status) {
                            $(ids).each(function(index, element) {
                                $("#" + element).closest("tr").remove();
                            });
                            swal({
                                title: "Applications deleted successfully.",
                                type: "success",
                                closeOnConfirm: true
                            }, function() {
                                swal.close();
                            });
                        } else {
                            swal({
                                title: response.message || "An error occurred while deleting records.",
                                type: "error",
                                closeOnConfirm: true
                            });
                        }
                    },
                    error: function(xhr) {
                        jGrowlAlert("An error occurred", 'error');
                    }
                });
            }
        });
    }
                        jGrowlAlert("An error occurred", 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
