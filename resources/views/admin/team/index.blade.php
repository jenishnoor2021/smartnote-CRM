@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Our Team Members') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li class="active">{{ __('Team Members') }}</li>
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
            <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm">
                Add New <i class="icon-plus-circle2 position-right"></i>
            </a>
            <a href="javascript:delete_selected();" class="btn btn-danger" id="delete_selected">
                Delete Selected <i class="icon-trash position-right"></i>
            </a>
            <span class="text-muted text-size-small pull-right" style="margin-top: 8px;"><i class="icon-three-bars position-left text-primary"></i> <strong>Drag &amp; drop rows</strong> to change display order</span>
        </div>

        <div class="panel-body table-responsive">
            <table id="team_table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="bg-slate-700">
                        <th width="3%" class="text-center" title="Drag to reorder"><i class="icon-menu2 text-muted"></i></th>
                        <th width="2%" class="text-center">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th width="8%" class="text-center">Actions</th>
                        <th width="8%" class="text-center">Photo</th>
                        <th width="20%">Name</th>
                        <th width="18%">Designation</th>
                        <th width="15%">Contact</th>
                        <th width="8%" class="text-center">Sort</th>
                        <th width="10%" class="text-center">Active/De-active</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $m)
                    <tr id="row-{{ $m->id }}" data-id="{{ $m->id }}" class="sortable-row">
                        <td class="text-center drag-handle" title="Drag to reorder"><i class="icon-three-bars"></i></td>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox styled" name="delete" id="{{ $m->id }}">
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="Edit" href="{{ route('admin.team.edit', $m->id) }}" class="text-info" style="margin-right: 8px;">
                                <i class="icon-pencil7"></i>
                            </a>
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record({{ $m->id }});" class="text-danger delete" id="{{ $m->id }}">
                                <i class="icon-trash"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            @if($m->image && file_exists(public_path($m->image)))
                                <img src="{{ asset($m->image) }}" alt="{{ $m->name }}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 1px solid #ddd;">
                            @else
                                <span class="label label-default" style="display: inline-block; padding: 6px 10px;"><i class="icon-user"></i></span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $m->name }}</strong>
                            @if($m->is_leadership)
                                <span class="label label-primary text-size-mini">Leadership</span>
                            @endif
                        </td>
                        <td>{{ $m->designation }}</td>
                        <td>
                            @if($m->phone)<div><i class="icon-phone2 text-success"></i> {{ $m->phone }}</div>@endif
                            @if($m->email)<div class="text-muted text-size-mini"><i class="icon-mail5"></i> {{ $m->email }}</div>@endif
                        </td>
                        <td class="text-center"><span class="badge badge-default sort-order-badge">{{ $m->sort_order ?? $loop->iteration }}</span></td>
                        <td class="text-center switchery-sm">
                            <input type="checkbox" onchange="change_status(this);" class="switchery"
                                id="{{ $m->id }}" {{ $m->is_active == 1 ? 'checked' : '' }}>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No team members found. Click "Add New" to create one.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function() {
        makeTableSortable('#team_table', '{{ route("admin.team.reorder") }}');
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
            url: '{{ route("admin.team.update_status") }}',
            type: 'POST',
            data: {
                id: obj.id,
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
                    obj.checked = !obj.checked;
                    swal({
                        title: "Failed to update status",
                        type: "error",
                    });
                }
            },
            error: function(xhr) {
                obj.checked = !obj.checked;
                jGrowlAlert("An error occurred", 'error');
            }
        });
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
                    url: '/admin/team/destroy/' + id,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#" + id).closest("tr").remove();
                            swal({
                                title: "Team member deleted successfully.",
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
                    url: '{{ route("admin.team.delete_multiple") }}',
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
                                title: "Team members deleted successfully.",
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
