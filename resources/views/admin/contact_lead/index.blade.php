@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Contact Messages & Website Leads') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li class="active">{{ __('Contact Leads') }}</li>
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
                    <form method="GET" action="{{ route('admin.contact-lead.index') }}" class="form-inline">
                        <select name="status" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="">-- All Statuses --</option>
                            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        <select name="limit" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="20" {{ request('limit', 20) == 20 ? 'selected' : '' }}>Show 20</option>
                            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>Show 50</option>
                            <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>Show 100</option>
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, phone, email..." class="form-control input-sm" style="width: 220px;">
                        <button type="submit" class="btn btn-default btn-sm"><i class="icon-search4"></i></button>
                        @if(request()->hasAny(['status', 'search', 'limit']))
                            <a href="{{ route('admin.contact-lead.index') }}" class="btn btn-link btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="panel-body table-responsive">
            <table id="contact_table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="bg-slate-700">
                        <th width="2%" class="text-center">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th width="8%" class="text-center">Actions</th>
                        <th width="18%">Contact Person</th>
                        <th width="15%">Phone / Email</th>
                        <th width="15%">Subject / Page</th>
                        <th width="24%">Message</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="8%" class="text-center">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox styled" name="delete" id="{{ $lead->id }}">
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="View Details" href="{{ route('admin.contact-lead.show', $lead->id) }}" class="text-info" style="margin-right: 8px;">
                                <i class="icon-eye"></i>
                            </a>
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record({{ $lead->id }});" class="text-danger delete" id="{{ $lead->id }}">
                                <i class="icon-trash"></i>
                            </a>
                        </td>
                        <td>
                            <strong>{{ $lead->name }}</strong>
                        </td>
                        <td>
                            <div><i class="icon-phone text-size-mini text-muted"></i> <a href="tel:{{ $lead->phone }}">{{ $lead->phone }}</a></div>
                            @if($lead->email)
                                <div><i class="icon-mail5 text-size-mini text-muted"></i> <a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></div>
                            @endif
                        </td>
                        <td>
                            @if($lead->subject)
                                <div><strong>{{ $lead->subject }}</strong></div>
                            @endif
                            @if($lead->source_page)
                                <span class="label label-default text-size-mini">{{ $lead->source_page }}</span>
                            @endif
                        </td>
                        <td>
                            {{ Str::limit($lead->message, 80) }}
                        </td>
                        <td class="text-center">
                            @if($lead->status == 'new')
                                <span class="label label-danger">NEW</span>
                            @elseif($lead->status == 'contacted')
                                <span class="label label-primary">CONTACTED</span>
                            @else
                                <span class="label label-default">CLOSED</span>
                            @endif
                        </td>
                        <td class="text-center text-size-mini">
                            {{ $lead->created_at ? $lead->created_at->format('d-m-Y') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No contact messages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-right" style="margin-top: 15px;">
                {{ $leads->links() }}
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
                    url: '/admin/contact-lead/' + id,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#" + id).closest("tr").remove();
                            swal({
                                title: "Contact lead deleted successfully.",
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
                    url: '{{ route("admin.contact-lead.delete_multiple") }}',
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
                                title: "Leads deleted successfully.",
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
</script>
@endsection
