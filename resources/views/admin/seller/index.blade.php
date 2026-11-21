@extends('layouts.admin')
@section('content')
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Sellers') }}</span>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li>
                <a href="/admin/dashboard"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
            </li>
            <li class="active">{{ __('Sellers') }}</li>
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
            <a href="{{ route('admin.seller.create') }}" class="btn btn-primary btn-sm">Add New Seller <i class="icon-plus-circle2 position-right"></i></a>
            <a href="javascript:delete_selected();" class="btn btn-danger btn-sm" id="delete_selected">Delete Selected <i class="icon-trash position-right"></i></a>
        </div>

        <div class="panel-body table-responsive">
            <table id="seller_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="2%">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th class="text-center" width="8%">Actions</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th class="text-center">Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sellers as $seller)
                    <tr>
                        <td>
                            <input type="checkbox" class="checkbox styled" name="delete" id="{{ $seller->id }}">
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="Edit" href="{{ route('admin.seller.edit', $seller->id) }}" class="text-info" style="margin-right: 8px;">
                                <i class="icon-pencil7"></i>
                            </a>
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record({{ $seller->id }});" class="text-danger delete" id="{{ $seller->id }}">
                                <i class="icon-trash"></i>
                            </a>
                        </td>
                        <td>{{ $seller->id }}</td>
                        <td><strong>{{ $seller->name }}</strong></td>
                        <td><span class="label label-default">{{ $seller->username }}</span></td>
                        <td>{{ $seller->email }}</td>
                        <td>{{ $seller->phone ?? '-' }}</td>
                        <td><span class="label label-primary">{{ ucfirst($seller->role) }}</span></td>
                        <td class="text-center switchery-sm">
                            <input type="checkbox" onchange="change_status(this);" class="switchery"
                                id="{{ $seller->id }}" {{ $seller->is_active ? 'checked' : '' }}>
                        </td>
                        <td>{{ $seller->created_at ? $seller->created_at->format('d-m-Y H:i') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No sellers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if(method_exists($sellers, 'links'))
            <div class="text-right" style="margin-top: 15px;">
                {{ $sellers->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function() {
        $('#seller_table').DataTable({
            'columnDefs': [{
                'targets': [0, 1],
                'orderable': false,
            }],
        });

        $('div.dataTables_length select').addClass('datatable-select');
    });

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
        var checked = obj.checked ? 1 : 0;

        $.ajax({
            url: '{{ route("admin.seller.update_status") }}',
            type: 'POST',
            data: {
                seller_id: obj.id,
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
                        type: "error",
                    });
                }
            },
            error: function(xhr) {
                swal({
                    title: "An error occurred while updating status",
                    type: "error",
                });
            }
        });
    }

    function delete_record(id) {
        swal({
            title: "Are you sure you want to delete this seller?",
            text: "The seller will no longer be able to log in.",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancel",
            confirmButtonText: "Yes, delete",
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: false
        },
        function() {
            $.ajax({
                url: '/admin/seller/destroy/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.status) {
                        $("#" + id).closest("tr").fadeOut(300, function() {
                            $(this).remove();
                        });
                        swal({
                            title: response.message || "Seller deleted successfully.",
                            type: "success",
                            closeOnConfirm: true
                        }, function() {
                            swal.close();
                        });
                    } else {
                        swal({
                            title: response.message || "Failed to delete seller.",
                            type: "error",
                            closeOnConfirm: true
                        });
                    }
                },
                error: function(xhr) {
                    swal({
                        title: "An error occurred",
                        type: "error",
                        closeOnConfirm: true
                    });
                },
            });
        });
    }

    function delete_selected() {
        var seller_ids = [];

        $(".checkbox:checked").each(function() {
            var id = $(this).attr('id');
            if (id) {
                seller_ids.push(id);
            }
        });

        if (seller_ids.length === 0) {
            swal({
                title: "Please select at least one seller to delete.",
                type: "warning",
                closeOnConfirm: true
            });
            return;
        }

        swal({
            title: "Are you sure you want to delete selected sellers?",
            text: "This action cannot be undone.",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancel",
            confirmButtonText: "Yes, delete selected",
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: false
        },
        function() {
            $.ajax({
                url: '{{ route("admin.seller.delete.multiple") }}',
                type: 'POST',
                data: {
                    ids: seller_ids,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        $(seller_ids).each(function(index, element) {
                            $("#" + element).closest("tr").fadeOut(300, function() {
                                $(this).remove();
                            });
                        });
                        swal({
                            title: response.message || "Selected sellers deleted successfully.",
                            type: "success",
                            closeOnConfirm: true
                        }, function() {
                            swal.close();
                        });
                    } else {
                        swal({
                            title: response.message || "Failed to delete selected sellers.",
                            type: "error",
                            closeOnConfirm: true
                        });
                    }
                },
                error: function(xhr) {
                    swal({
                        title: "An error occurred",
                        type: "error",
                        closeOnConfirm: true
                    });
                }
            });
        });
    }
</script>
@endsection

