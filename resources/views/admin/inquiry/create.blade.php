@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Create New Product Inquiry') }}</span>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.inquiry.index') }}">{{ __('Inquiries') }}</a></li>
            <li class="active">{{ __('Create') }}</li>
        </ul>
    </div>
</div>

<div class="content">

    @if(session('error'))
        <div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.inquiry.store') }}" method="POST" id="inquiryForm">
        @csrf
        <div class="row">
            <!-- Customer Information Card -->
            <div class="col-md-5">
                <div class="panel panel-flat">
                    <div class="panel-heading bg-primary">
                        <h6 class="panel-title"><i class="icon-user position-left"></i> Customer Details</h6>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="text-semibold"><span class="text-danger">*</span> Customer Full Name:</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="Enter customer name" value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="text-semibold"><span class="text-danger">*</span> Phone / Mobile Number:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icon-phone2"></i></span>
                                <input type="text" name="customer_phone" class="form-control" placeholder="e.g. 9876543210" value="{{ old('customer_phone') }}" required>
                            </div>
                            <span class="help-block">Used for seller calling & inquiry consolidation.</span>
                            @error('customer_phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Email Address (Optional):</label>
                            <input type="email" name="customer_email" class="form-control" placeholder="customer@example.com" value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Shipping Address:</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="House/Flat No, Society/Street">{{ old('address') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-semibold">City:</label>
                                    <input type="text" name="city" class="form-control" placeholder="e.g. Ahmedabad" value="{{ old('city') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-semibold">Pincode:</label>
                                    <input type="text" name="pincode" class="form-control" placeholder="e.g. 380001" value="{{ old('pincode') }}">
                                </div>
                            </div>
                        </div>

                        @if(Auth::user()->isSuperAdmin())
                        <div class="form-group">
                            <label class="text-semibold">Assign to Seller:</label>
                            <select name="assigned_to" class="form-control">
                                <option value="">-- Leave Unassigned (Assign Later) --</option>
                                @foreach($sellers as $seller)
                                    <option value="{{ $seller->id }}" {{ old('assigned_to') == $seller->id ? 'selected' : '' }}>
                                        {{ $seller->name }} ({{ $seller->username }})
                                    </option>
                                @endforeach
                            </select>
                            <span class="help-block">Superadmin can assign immediately or later in bulk.</span>
                        </div>
                        @else
                        <div class="alert alert-info alert-styled-left alert-arrow-left">
                            <i class="icon-info22 position-left"></i> This inquiry will be assigned directly to your seller account.
                        </div>
                        @endif

                        <div class="form-group">
                            <label class="text-semibold">Initial Notes / Requirements:</label>
                            <textarea name="general_note" class="form-control" rows="2" placeholder="Customer requirements, preferred call timings, etc.">{{ old('general_note') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Selection Card -->
            <div class="col-md-7">
                <div class="panel panel-flat">
                    <div class="panel-heading bg-slate-700">
                        <div class="row">
                            <div class="col-xs-8">
                                <h6 class="panel-title"><i class="icon-books position-left"></i> Products in this Inquiry</h6>
                            </div>
                            <div class="col-xs-4 text-right">
                                <button type="button" class="btn btn-xs btn-success" onclick="addProductRow()">
                                    <i class="icon-plus2 position-left"></i> Add Product
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-bordered table-striped" id="productsTable">
                            <thead>
                                <tr class="bg-slate-600">
                                    <th width="45%">Product</th>
                                    <th width="20%">Price (₹)</th>
                                    <th width="15%">Qty</th>
                                    <th width="20%">Subtotal (₹)</th>
                                    <th width="5%" class="text-center"><i class="icon-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody id="productRowsContainer">
                                <!-- Dynamic Rows -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right text-semibold">Estimated Total:</th>
                                    <th colspan="2" class="text-primary text-bold" style="font-size: 16px;">
                                        ₹<span id="grandTotalDisplay">0.00</span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>

                        @error('products')
                            <div class="text-danger mt-10">{{ $message }}</div>
                        @enderror

                        <div class="text-right" style="margin-top: 25px;">
                            <a href="{{ route('admin.inquiry.index') }}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-labeled btn-labeled-right">
                                <b><i class="icon-arrow-right14"></i></b> Save & Create Inquiry
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Product Options Template for JS -->
<div id="productOptionsTemplate" style="display: none;">
    <option value="">-- Select Product --</option>
    @foreach($products as $prod)
        <option value="{{ $prod->id }}" data-price="{{ $prod->selling_price }}">
            {{ $prod->product_name }} (₹{{ number_format($prod->selling_price, 2) }})
        </option>
    @endforeach
</div>

@endsection

@section('script')
<script type="text/javascript">
    var rowCounter = 0;

    function addProductRow(selectedId = '', initialPrice = '', initialQty = 1) {
        var optionsHtml = $('#productOptionsTemplate').html();
        var rowId = 'row_' + rowCounter;

        var html = '<tr id="' + rowId + '">' +
            '<td>' +
                '<select name="products[' + rowCounter + '][product_id]" class="form-control product-select" required onchange="onProductChange(this, ' + rowCounter + ')">' +
                    optionsHtml +
                '</select>' +
            '</td>' +
            '<td>' +
                '<div class="input-group">' +
                    '<span class="input-group-addon">₹</span>' +
                    '<input type="number" step="0.01" min="0" name="products[' + rowCounter + '][price]" class="form-control product-price" required oninput="calculateRow(' + rowCounter + ')" value="' + initialPrice + '">' +
                '</div>' +
            '</td>' +
            '<td>' +
                '<input type="number" min="1" name="products[' + rowCounter + '][quantity]" class="form-control product-qty" required value="' + initialQty + '" oninput="calculateRow(' + rowCounter + ')">' +
            '</td>' +
            '<td>' +
                '<strong class="product-subtotal-text">₹0.00</strong>' +
                '<input type="hidden" class="product-subtotal-val" value="0">' +
            '</td>' +
            '<td class="text-center">' +
                '<button type="button" class="btn btn-xs btn-danger" onclick="removeRow(\'' + rowId + '\')"><i class="icon-cross2"></i></button>' +
            '</td>' +
        '</tr>';

        $('#productRowsContainer').append(html);

        if(selectedId) {
            $('#' + rowId + ' .product-select').val(selectedId);
        }

        rowCounter++;
        calculateGrandTotal();
    }

    function onProductChange(selectElement, rowIndex) {
        var selectedOption = $(selectElement).find('option:selected');
        var price = selectedOption.data('price') || 0;
        var row = $(selectElement).closest('tr');
        row.find('.product-price').val(price);
        calculateRow(rowIndex);
    }

    function calculateRow(rowIndex) {
        var row = $('input[name="products[' + rowIndex + '][price]"]').closest('tr');
        var price = parseFloat(row.find('.product-price').val()) || 0;
        var qty = parseInt(row.find('.product-qty').val()) || 0;
        var subtotal = price * qty;

        row.find('.product-subtotal-text').text('₹' + subtotal.toFixed(2));
        row.find('.product-subtotal-val').val(subtotal);

        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        var grandTotal = 0;
        $('.product-subtotal-val').each(function() {
            grandTotal += parseFloat($(this).val()) || 0;
        });
        $('#grandTotalDisplay').text(grandTotal.toFixed(2));
    }

    function removeRow(rowId) {
        if($('#productRowsContainer tr').length <= 1) {
            swal("Notice", "An inquiry must have at least one product.", "warning");
            return;
        }
        $('#' + rowId).remove();
        calculateGrandTotal();
    }

    $(document).ready(function() {
        // Add one empty product row by default
        addProductRow();
    });
</script>
@endsection

