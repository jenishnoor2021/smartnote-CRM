@extends('layouts.admin')
@section('content')
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Category') }}</span>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li>
                <a href="/admin/dashboard"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
            </li>
            <li class="active">{{ __('Category') }}</li>
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
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm">Add New <i class="icon-plus-circle2 position-right"></i></a>
            <a href="javascript:delete_selected();" class="btn btn-danger" id="delete_selected">Delete Selected<i class=" icon-trash position-right"></i></a>
            <span class="text-muted text-size-small pull-right" style="margin-top: 8px;"><i class="icon-three-bars position-left text-primary"></i> <strong>Drag &amp; drop rows</strong> to change display order</span>
        </div>

        <div class="panel-body table-responsive">
            <table id="category_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="3%" class="text-center" title="Drag to reorder"><i class="icon-menu2 text-muted"></i></th>
                        <th width="2%">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th width="8%" class="text-center">Actions</th>
                        <th width="5%">ID</th>
                        <th width="10%" class="text-center">Image</th>
                        <th>Category Name</th>
                        <th width="6%" class="text-center">Sort</th>
                        <th width="12%" class="text-center">Active/De-active</th>
                        <th width="15%">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr id="row-{{ $category->id }}" data-id="{{ $category->id }}" class="sortable-row">
                        <td class="text-center drag-handle" title="Drag to reorder"><i class="icon-three-bars"></i></td>
                        <td>
                            <input type="checkbox" class="checkbox styled" name="delete" id="{{ $category->id }}">
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="Edit" href="{{ route('admin.category.edit', $category->id) }}" id="{{ $category->id }}" class="text-info" style="margin-right: 8px;">
                                <i class="icon-pencil7"></i>
                            </a>
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record({{ $category->id }});" class="text-danger delete" id="{{ $category->id }}">
                                <i class="icon-trash"></i>
                            </a>
                        </td>
                        <td>{{ $category->id }}</td>
                        <td class="text-center">
                            @if($category->image && file_exists(public_path($category->image)))
                                <img src="{{ asset($category->image) }}" alt="{{ $category->category_name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                            @else
                                <span class="label label-default" style="display: inline-block; padding: 6px 10px;">No Image</span>
                            @endif
                        </td>
                        <td><strong>{{ $category->category_name }}</strong></td>
                        <td class="text-center"><span class="badge badge-default sort-order-badge">{{ $category->sort_order ?? $loop->iteration }}</span></td>
                        <td class="text-center switchery-sm">
                            <input type="checkbox" onchange="change_status(this);" class="switchery"
                                id="{{ $category->id }}" {{ $category->is_active == 1 ? 'checked' : '' }}>
                        </td>
                        <td>{{ $category->created_at ? $category->created_at->format('d-m-Y H:i') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-right" style="margin-top: 15px;">
                @if(method_exists($categories, 'links')) {{ $categories->links() }} @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function() {
        $('#category_table').DataTable({
            'ordering': false,
            'columnDefs': [{
                'targets': [0, 1, 2, 4],
                'orderable': false,
            }],
        });

        $('div.dataTables_length select').addClass('datatable-select');
        makeTableSortable('#category_table', '{{ route("admin.category.reorder") }}');
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
        var checked = 0;
        if (obj.checked) {
            checked = 1;
        }

        $.ajax({
            url: '{{ route("admin.category.update_status") }}',
            type: 'POST',
            data: {
                category_id: obj.id,
                is_active: checked,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    swal({
                        title: response.message,
                        type: "success",
                    });
                } else {
                    swal({
                        title: "Failed to update status",
                        type: "error",
                    });
                }
            },
            error: function(xhr) {
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
        },
        function() {
            $.ajax({
                url: '/admin/category/destroy/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.status) {
                        $("#" + id).closest("tr").remove();
                        swal({
                            title: "Category deleted successfully.",
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
        });
    }

    function delete_selected() {
        var category_ids = [];

        $(".checkbox:checked").each(function() {
            var id = $(this).attr('id');
            if (id) {
                category_ids.push(id);
            }
        });

        if (category_ids.length === 0) {
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
        },
        function() {
            $.ajax({
                url: '{{ route("admin.category.delete.multiple") }}',
                type: 'POST',
                data: {
                    ids: category_ids,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        $(category_ids).each(function(index, element) {
                            $("#" + element).closest("tr").remove();
                        });
                        swal({
                            title: "Categories deleted successfully.",
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
        });
    }
</script>
@endsection

