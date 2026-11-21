@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><span class="text-semibold">{{ __('Client Reviews & Testimonials') }}</span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li class="active">{{ __('Reviews') }}</li>
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
            <a href="{{ route('admin.testimonial.create') }}" class="btn btn-primary btn-sm">
                Add New <i class="icon-plus-circle2 position-right"></i>
            </a>
            <a href="javascript:delete_selected();" class="btn btn-danger" id="delete_selected">
                Delete Selected <i class="icon-trash position-right"></i>
            </a>
            <span class="text-muted text-size-small pull-right" style="margin-top: 8px;"><i class="icon-three-bars position-left text-primary"></i> <strong>Drag &amp; drop rows</strong> to change display order</span>
        </div>

        <div class="panel-body table-responsive">
            <table id="testimonial_table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="bg-slate-700">
                        <th width="3%" class="text-center" title="Drag to reorder"><i class="icon-menu2 text-muted"></i></th>
                        <th width="2%" class="text-center">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th width="8%" class="text-center">Actions</th>
                        <th width="8%" class="text-center">Photo</th>
                        <th width="18%">Person Name</th>
                        <th width="18%">School / Designation</th>
                        <th width="10%" class="text-center">Rating</th>
                        <th width="26%">Review Quote</th>
                        <th width="6%" class="text-center">Sort</th>
                        <th width="10%" class="text-center">Active/De-active</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $t)
                    <tr id="row-{{ $t->id }}" data-id="{{ $t->id }}" class="sortable-row">
                        <td class="text-center drag-handle" title="Drag to reorder"><i class="icon-three-bars"></i></td>
                        <td class="text-center">
                            <input type="checkbox" class="checkbox styled" name="delete" id="{{ $t->id }}">
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="Edit" href="{{ route('admin.testimonial.edit', $t->id) }}" class="text-info" style="margin-right: 8px;">
                                <i class="icon-pencil7"></i>
                            </a>
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record({{ $t->id }});" class="text-danger delete" id="{{ $t->id }}">
                                <i class="icon-trash"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            @if($t->image && file_exists(public_path($t->image)))
                                <img src="{{ asset($t->image) }}" alt="{{ $t->name }}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 1px solid #ddd;">
                            @else
                                <span class="label label-default" style="display: inline-block; padding: 6px 10px;"><i class="icon-user"></i></span>
                            @endif
                        </td>
                        <td><strong>{{ $t->name }}</strong></td>
                        <td>
                            <div>{{ $t->designation ?? '-' }}</div>
                            @if($t->school_name)<div class="text-muted text-size-mini"><i class="icon-office"></i> {{ $t->school_name }}</div>@endif
                        </td>
                        <td class="text-center">
                            <span class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $t->rating)
                                        <i class="icon-star-full2"></i>
                                    @else
                                        <i class="icon-star-empty3"></i>
                                    @endif
                                @endfor
                            </span>
                        </td>
                        <td>{{ Str::limit($t->review, 85) }}</td>
                        <td class="text-center"><span class="badge badge-default sort-order-badge">{{ $t->sort_order ?? $loop->iteration }}</span></td>
                        <td class="text-center switchery-sm">
                            <input type="checkbox" onchange="change_status(this);" class="switchery"
                                id="{{ $t->id }}" {{ $t->is_active == 1 ? 'checked' : '' }}>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No reviews found. Click "Add New" to create one.</td>
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
        makeTableSortable('#testimonial_table', '{{ route("admin.testimonial.reorder") }}');
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
            url: '{{ route("admin.testimonial.update_status") }}',
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
                    url: '/admin/testimonial/destroy/' + id,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#" + id).closest("tr").remove();
                            swal({
                                title: "Review deleted successfully.",
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
                    url: '{{ route("admin.testimonial.delete_multiple") }}',
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
                                title: "Reviews deleted successfully.",
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
