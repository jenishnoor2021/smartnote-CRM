@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Newsletter Subscribers') }}</span></h4>
        </div>
        <div class="heading-elements">
            <a href="{{ route('admin.newsletter.export') }}" class="btn btn-success btn-sm">
                <i class="icon-file-excel position-left"></i> Export CSV
            </a>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li class="active">{{ __('Newsletter Subscribers') }}</li>
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
                    <form method="GET" action="{{ route('admin.newsletter.index') }}" class="form-inline">
                        <select name="limit" class="form-control input-sm" onchange="this.form.submit()">
                            <option value="25" {{ request('limit', 25) == 25 ? 'selected' : '' }}>Show 25</option>
                            <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>Show 50</option>
                            <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>Show 100</option>
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search subscriber email..." class="form-control input-sm" style="width: 240px;">
                        <button type="submit" class="btn btn-default btn-sm"><i class="icon-search4"></i></button>
                        @if(request()->hasAny(['search', 'limit']))
                            <a href="{{ route('admin.newsletter.index') }}" class="btn btn-link btn-sm">Reset</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="panel-body table-responsive">
            <table id="newsletter_table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="bg-slate-700">
                        <th width="2%" class="text-center">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th width="8%" class="text-center">Action</th>
                        <th width="50%">Subscriber Email</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="25%">Subscribed Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $sub)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox styled" name="delete" id="{{ $sub->id }}">
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record({{ $sub->id }});" class="text-danger delete" id="{{ $sub->id }}">
                                <i class="icon-trash"></i>
                            </a>
                        </td>
                        <td>
                            <strong><a href="mailto:{{ $sub->email }}">{{ $sub->email }}</a></strong>
                        </td>
                        <td class="text-center">
                            @if($sub->status == 'subscribed')
                                <span class="label label-success">SUBSCRIBED</span>
                            @else
                                <span class="label label-default">UNSUBSCRIBED</span>
                            @endif
                        </td>
                        <td>
                            {{ $sub->created_at ? $sub->created_at->format('d-m-Y H:i') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No newsletter subscribers yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-right" style="margin-top: 15px;">
                {{ $subscribers->links() }}
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
            title: "Are you sure you want to remove this subscriber?",
            text: "This email will be deleted from your newsletter list.",
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
                    url: '/admin/newsletter/' + id,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#" + id).closest("tr").remove();
                            swal({
                                title: "Subscriber removed successfully.",
                                type: "success",
                                closeOnConfirm: true
                            }, function() {
                                swal.close();
                            });
                        } else {
                            swal({
                                title: response.message || "An error occurred while removing subscriber.",
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
            title: "Are you sure you want to delete selected subscribers?",
            text: "This action cannot be undone.",
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
                    url: '{{ route("admin.newsletter.delete_multiple") }}',
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
                                title: "Subscribers deleted successfully.",
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
