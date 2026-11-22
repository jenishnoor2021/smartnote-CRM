@extends('layouts.admin')
@section('content')
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Products') }}</span>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li>
                <a href="/admin/dashboard"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a>
            </li>
            <li class="active">{{ __('Products') }}</li>
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
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm">Add New <i class="icon-plus-circle2 position-right"></i></a>
            <a href="javascript:delete_selected();" class="btn btn-danger" id="delete_selected">Delete Selected<i class=" icon-trash position-right"></i></a>
        </div>

        <div class="panel-body table-responsive">
            <table id="product_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="2%">
                            <input type="checkbox" name="select_all" id="select_all" class="styled" onclick="select_all(this);">
                        </th>
                        <th width="8%" class="text-center">Actions</th>
                        <th width="4%">ID</th>
                        <th width="8%" class="text-center">Image</th>
                        <th>Product Info</th>
                        <th>Category / Sub Category</th>
                        <th width="12%">Price</th>
                        <th width="10%" class="text-center">Stock</th>
                        <th width="10%" class="text-center">Active/De-active</th>
                        <th width="12%">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr>
                        <td>
                            <input type="checkbox" class="checkbox styled" name="delete" id="{{ $product->id }}">
                        </td>
                        <td class="text-center">
                            <a data-popup="tooltip" data-placement="top" title="Edit" href="{{ route('admin.product.edit', $product->id) }}" id="{{ $product->id }}" class="text-info" style="margin-right: 8px;">
                                <i class="icon-pencil7"></i>
                            </a>
                            <a data-popup="tooltip" data-placement="top" title="Delete" href="javascript:delete_record({{ $product->id }});" class="text-danger delete" id="{{ $product->id }}">
                                <i class="icon-trash"></i>
                            </a>
                        </td>
                        <td>{{ $product->id }}</td>
                        <td class="text-center">
                            @if(!empty($product->cover_image))
                                <img src="{{ asset($product->cover_image) }}" alt="{{ $product->product_name }}" style="width: 50px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;" onerror="this.onerror=null;this.src='{{ asset('assets/img/book/pg-6.png') }}';">
                            @else
                                <span class="label label-default" style="display: inline-block; padding: 6px 10px;">No Cover</span>
                            @endif
                        </td>
                        <td>
                            <strong style="font-size: 14px;">{{ $product->product_name }}</strong>
                            <div class="text-muted" style="font-size: 11px; margin-top: 3px;">
                                @if($product->product_code)
                                    <span class="label label-default" style="margin-right: 5px;">SKU: {{ $product->product_code }}</span>
                                @endif
                                @if($product->author_publisher)
                                    <span>By: {{ $product->author_publisher }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="label label-info" style="font-size: 11px;">
                                {{ $product->category->category_name ?? '-' }}
                            </span>
                            @if($product->subcategory)
                                <div style="margin-top: 4px;">
                                    <span class="label label-primary" style="font-size: 10px;">
                                        {{ $product->subcategory->subcategory_name }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong class="text-success" style="font-size: 14px;">₹{{ number_format($product->selling_price, 2) }}</strong>
                            <span class="text-muted" style="font-size: 11px;">/ {{ $product->unit ?? 'pcs' }}</span>
                            @if($product->mrp_price > $product->selling_price)
                                <div class="text-muted" style="font-size: 11px; text-decoration: line-through;">
                                    ₹{{ number_format($product->mrp_price, 2) }}
                                </div>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($product->is_in_stock && $product->stock_quantity > 0)
                                <span class="label label-success" style="font-size: 11px;">{{ $product->stock_quantity }} In Stock</span>
                            @else
                                <span class="label label-danger" style="font-size: 11px;">Out of Stock</span>
                            @endif
                        </td>
                        <td class="text-center switchery-sm">
                            <input type="checkbox" onchange="change_status(this);" class="switchery"
                                id="{{ $product->id }}" {{ $product->is_active == 1 ? 'checked' : '' }}>
                        </td>
                        <td>{{ $product->created_at ? $product->created_at->format('d-m-Y H:i') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if(method_exists($products, 'links'))
            <div class="text-right" style="margin-top: 15px;">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function() {
        $('#product_table').DataTable({
            'columnDefs': [{
                'targets': [0, 1, 3],
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
        var checked = 0;
        if (obj.checked) {
            checked = 1;
        }

        $.ajax({
            url: '{{ route("admin.product.update_status") }}',
            type: 'POST',
            data: {
                product_id: obj.id,
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
            title: "Are you sure you want to delete this product?",
            text: "All associated images will also be removed.",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "No, Cancel It",
            confirmButtonText: "Yes, I am sure",
        },
        function() {
            $.ajax({
                url: '/admin/product/destroy/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE'
                },
                success: function(response) {
                    if (response.status) {
                        $("#" + id).closest("tr").remove();
                        swal({
                            title: "Product deleted successfully.",
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
        var product_ids = [];

        $(".checkbox:checked").each(function() {
            var id = $(this).attr('id');
            if (id) {
                product_ids.push(id);
            }
        });

        if (product_ids.length === 0) {
            jGrowlAlert("Please select some records to delete.", 'danger');
            return;
        }

        swal({
            title: "Are you sure you want to delete selected products?",
            text: "This will remove all selected products and their images.",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "No, Cancel It",
            confirmButtonText: "Yes, I am sure",
        },
        function() {
            $.ajax({
                url: '{{ route("admin.product.delete.multiple") }}',
                type: 'POST',
                data: {
                    ids: product_ids,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        $(product_ids).each(function(index, element) {
                            $("#" + element).closest("tr").remove();
                        });
                        swal({
                            title: "Products deleted successfully.",
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

