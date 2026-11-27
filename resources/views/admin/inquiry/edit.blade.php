@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Edit Inquiry') }}: {{ $inquiry->inquiry_no }}</span>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.inquiry.index') }}">{{ __('Inquiries') }}</a></li>
            <li><a href="{{ route('admin.inquiry.show', $inquiry->id) }}">{{ $inquiry->inquiry_no }}</a></li>
            <li class="active">{{ __('Edit') }}</li>
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

    <form action="{{ route('admin.inquiry.update', $inquiry->id) }}" method="POST" id="inquiryForm">
        @csrf
        @method('PATCH')
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
                            <input type="text" name="customer_name" class="form-control" placeholder="Enter customer name" value="{{ old('customer_name', $inquiry->customer_name) }}" required>
                            @error('customer_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="text-semibold"><span class="text-danger">*</span> Phone / Mobile Number:</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icon-phone2"></i></span>
                                <input type="text" name="customer_phone" class="form-control" placeholder="e.g. 9876543210" value="{{ old('customer_phone', $inquiry->customer_phone) }}" required>
                            </div>
                            @error('customer_phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Email Address (Optional):</label>
                            <input type="email" name="customer_email" class="form-control" placeholder="customer@example.com" value="{{ old('customer_email', $inquiry->customer_email) }}">
                            @error('customer_email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="text-semibold">Shipping Address:</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="House/Flat No, Society/Street">{{ old('address', $inquiry->address) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-semibold">City:</label>
                                    <input type="text" name="city" class="form-control" placeholder="e.g. Ahmedabad" value="{{ old('city', $inquiry->city) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-semibold">Pincode:</label>
                                    <input type="text" name="pincode" class="form-control" placeholder="e.g. 380001" value="{{ old('pincode', $inquiry->pincode) }}">
                                </div>
                            </div>
                        </div>

                        @if(Auth::user()->isSuperAdmin())
                        <div class="form-group">
                            <label class="text-semibold">Assign to Seller:</label>
                            <select name="assigned_to" class="form-control">
                                <option value="">-- Leave Unassigned --</option>
                                @foreach($sellers as $seller)
                                    <option value="{{ $seller->id }}" {{ old('assigned_to', $inquiry->assigned_to) == $seller->id ? 'selected' : '' }}>
                                        {{ $seller->name }} ({{ $seller->username }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="form-group">
                            <label class="text-semibold">General Note:</label>
                            <textarea name="general_note" class="form-control" rows="2">{{ old('general_note', $inquiry->general_note) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Selection Card -->
            <div class="col-md-7">
                <div class="panel panel-flat">
                    <div class="panel-heading bg-slate-700">
                        <h6 class="panel-title"><i class="icon-books position-left"></i> Products in this Inquiry</h6>
                    </div>
                    <div class="panel-body">
                        <!-- Category & Sub Category Selection Box -->
                        <div class="well well-sm" style="background-color: #f8fafc; border: 1.5px solid #cbd5e1; border-radius: 6px; padding: 15px; margin-bottom: 20px;">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h6 class="text-semibold text-primary" style="margin-top: 0; margin-bottom: 12px;">
                                        <i class="icon-filter3 position-left"></i> Select Product by Category & Sub Category
                                    </h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-10">
                                        <label class="text-semibold text-size-small"><span class="text-danger">*</span> Category:</label>
                                        <select id="sel_category" class="form-control" onchange="onCategoryChange()">
                                            <option value="">-- Select Category --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-10">
                                        <label class="text-semibold text-size-small"><span class="text-danger">*</span> Sub Category:</label>
                                        <select id="sel_subcategory" class="form-control" disabled onchange="onSubcategoryChange()">
                                            <option value="">-- Select Category First --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group mb-10">
                                        <label class="text-semibold text-size-small"><span class="text-danger">*</span> Product / Book:</label>
                                        <select id="sel_product" class="form-control" disabled onchange="onProductSelectChange()">
                                            <option value="">-- Select Sub Category First --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 6px;">
                                <div class="col-xs-6 col-sm-4">
                                    <div class="form-group mb-0">
                                        <label class="text-semibold text-size-small">Price (₹):</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">₹</span>
                                            <input type="number" id="sel_price" class="form-control text-semibold" step="0.01" min="0" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group mb-0">
                                        <label class="text-semibold text-size-small">Quantity:</label>
                                        <input type="number" id="sel_qty" class="form-control text-semibold" min="1" value="1">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-5" style="margin-top: 25px;">
                                    <button type="button" class="btn btn-primary btn-block text-semibold" id="btnAddProduct" onclick="addProductFromSelector()">
                                        <i class="icon-plus22 position-left"></i> Add Product
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Table of Selected Products -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="productsTable">
                                <thead>
                                    <tr class="bg-slate-600">
                                        <th width="42%">Product Details</th>
                                        <th width="20%">Price (₹)</th>
                                        <th width="15%">Qty</th>
                                        <th width="18%">Subtotal (₹)</th>
                                        <th width="5%" class="text-center"><i class="icon-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="productRowsContainer">
                                    <tr id="emptyRowPlaceholder" style="display: none;">
                                        <td colspan="5" class="text-center text-muted" style="padding: 25px;">
                                            <i class="icon-cart-add2" style="font-size: 28px; opacity: 0.5;"></i>
                                            <div style="margin-top: 6px;">No products in this inquiry. Please select Category & Sub Category above and click <strong>"Add Product"</strong>.</div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-slate-100">
                                        <th colspan="3" class="text-right text-semibold">Estimated Total:</th>
                                        <th colspan="2" class="text-primary text-bold" style="font-size: 16px;">
                                            ₹<span id="grandTotalDisplay">0.00</span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @error('products')
                            <div class="text-danger mt-10">{{ $message }}</div>
                        @enderror

                        <div class="text-right" style="margin-top: 25px;">
                            <a href="{{ route('admin.inquiry.show', $inquiry->id) }}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-labeled btn-labeled-right">
                                <b><i class="icon-arrow-right14"></i></b> Update Inquiry
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')
<script type="text/javascript">
    var allSubcategories = @json($subcategories);
    var allProducts = @json($products);
    var rowCounter = 0;

    function onCategoryChange() {
        var catId = $('#sel_category').val();
        var $subCatSelect = $('#sel_subcategory');
        var $prodSelect = $('#sel_product');

        $subCatSelect.empty().append('<option value="">-- Select Sub Category --</option>');
        $prodSelect.empty().append('<option value="">-- Select Sub Category First --</option>').prop('disabled', true);
        $('#sel_price').val('');
        $('#sel_qty').val(1);

        if(!catId) {
            $subCatSelect.empty().append('<option value="">-- Select Category First --</option>').prop('disabled', true);
            return;
        }

        var filteredSubcats = allSubcategories.filter(function(sub) {
            return sub.category_id == catId;
        });

        if(filteredSubcats.length > 0) {
            $.each(filteredSubcats, function(index, sub) {
                $subCatSelect.append('<option value="' + sub.id + '">' + sub.subcategory_name + '</option>');
            });
            $subCatSelect.prop('disabled', false);
        } else {
            $subCatSelect.append('<option value="">-- No Subcategories Found --</option>').prop('disabled', true);
        }
    }

    function onSubcategoryChange() {
        var catId = $('#sel_category').val();
        var subId = $('#sel_subcategory').val();
        var $prodSelect = $('#sel_product');

        $prodSelect.empty().append('<option value="">-- Select Product --</option>');
        $('#sel_price').val('');
        $('#sel_qty').val(1);

        if(!subId) {
            $prodSelect.empty().append('<option value="">-- Select Sub Category First --</option>').prop('disabled', true);
            return;
        }

        var filteredProducts = allProducts.filter(function(prod) {
            return prod.category_id == catId && prod.subcategory_id == subId;
        });

        if(filteredProducts.length > 0) {
            $.each(filteredProducts, function(index, prod) {
                var priceDisplay = prod.selling_price ? parseFloat(prod.selling_price).toFixed(2) : '0.00';
                $prodSelect.append('<option value="' + prod.id + '" data-price="' + prod.selling_price + '">' + prod.product_name + ' (₹' + priceDisplay + ')</option>');
            });
            $prodSelect.prop('disabled', false);
        } else {
            $prodSelect.append('<option value="">-- No Products Found in this Subcategory --</option>').prop('disabled', true);
        }
    }

    function onProductSelectChange() {
        var selectedOption = $('#sel_product').find('option:selected');
        var price = selectedOption.data('price') || 0;
        $('#sel_price').val(parseFloat(price).toFixed(2));
        if(!$('#sel_qty').val() || $('#sel_qty').val() < 1) {
            $('#sel_qty').val(1);
        }
    }

    function addProductFromSelector() {
        var prodId = $('#sel_product').val();
        if(!prodId) {
            if(typeof swal === 'function') {
                swal("Required", "Please select a Category, Sub Category, and Product first.", "warning");
            } else {
                alert("Please select a Category, Sub Category, and Product first.");
            }
            return;
        }

        var price = parseFloat($('#sel_price').val()) || 0;
        var qty = parseInt($('#sel_qty').val()) || 1;
        if(qty < 1) qty = 1;

        // Check if already added in table
        var existingRow = $('input.row-product-id[value="' + prodId + '"]').closest('tr.product-row');
        if(existingRow.length > 0) {
            // Increment quantity on existing row!
            var currentQtyInput = existingRow.find('.product-qty');
            var newQty = (parseInt(currentQtyInput.val()) || 0) + qty;
            currentQtyInput.val(newQty);
            calculateRow(existingRow);

            // Reset product dropdown and price, keep category and subcategory selected!
            $('#sel_product').val('');
            $('#sel_price').val('');
            $('#sel_qty').val(1);

            if(typeof swal === 'function') {
                swal("Quantity Updated", "Product is already in the list. Quantity increased to " + newQty + ".", "info");
            }
            return;
        }

        var selectedProduct = allProducts.find(function(p) { return p.id == prodId; });
        var productName = selectedProduct ? selectedProduct.product_name : $('#sel_product option:selected').text();
        var catName = $('#sel_category option:selected').text();
        var subcatName = $('#sel_subcategory option:selected').text();

        appendRowToTable(prodId, productName, catName, subcatName, price, qty);

        // Reset product dropdown and price, keep Category & Subcategory selected for easy multiple addition!
        $('#sel_product').val('');
        $('#sel_price').val('');
        $('#sel_qty').val(1);
    }

    function appendRowToTable(prodId, productName, catName, subcatName, price, qty) {
        $('#emptyRowPlaceholder').hide();
        var rowId = 'row_' + rowCounter;
        var subtotal = (price * qty).toFixed(2);

        var html = '<tr id="' + rowId + '" class="product-row">' +
            '<td>' +
                '<div class="text-semibold text-primary" style="font-size: 13.5px;">' + productName + '</div>' +
                '<div style="margin-top: 4px;">' +
                    (catName ? '<span class="label label-default" style="margin-right: 4px; font-size: 10px;">' + catName + '</span>' : '') +
                    (subcatName ? '<span class="label label-info" style="font-size: 10px;">' + subcatName + '</span>' : '') +
                '</div>' +
                '<input type="hidden" class="row-product-id" name="products[' + rowCounter + '][product_id]" value="' + prodId + '">' +
            '</td>' +
            '<td>' +
                '<div class="input-group input-group-sm">' +
                    '<span class="input-group-addon">₹</span>' +
                    '<input type="number" step="0.01" min="0" name="products[' + rowCounter + '][price]" class="form-control product-price" required value="' + parseFloat(price).toFixed(2) + '" oninput="calculateRow(this)">' +
                '</div>' +
            '</td>' +
            '<td>' +
                '<input type="number" min="1" name="products[' + rowCounter + '][quantity]" class="form-control input-sm product-qty" required value="' + qty + '" oninput="calculateRow(this)">' +
            '</td>' +
            '<td>' +
                '<strong class="product-subtotal-text">₹' + subtotal + '</strong>' +
                '<input type="hidden" class="product-subtotal-val" value="' + subtotal + '">' +
            '</td>' +
            '<td class="text-center">' +
                '<button type="button" class="btn btn-xs btn-danger" onclick="removeRow(\'' + rowId + '\')" title="Remove"><i class="icon-trash"></i></button>' +
            '</td>' +
        '</tr>';

        $('#productRowsContainer').append(html);
        rowCounter++;
        calculateGrandTotal();
    }

    function calculateRow(element) {
        var row = $(element).closest('tr.product-row');
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
        $('#' + rowId).remove();
        if($('.product-row').length === 0) {
            $('#emptyRowPlaceholder').show();
        }
        calculateGrandTotal();
    }

    $(document).ready(function() {
        @if($inquiry->items && $inquiry->items->count() > 0)
            @foreach($inquiry->items as $item)
                appendRowToTable(
                    {{ $item->product_id }},
                    @json($item->product ? $item->product->product_name : ($item->product_name ?? 'Product #'.$item->product_id)),
                    @json($item->product && $item->product->category ? $item->product->category->category_name : ''),
                    @json($item->product && $item->product->subcategory ? $item->product->subcategory->subcategory_name : ''),
                    {{ $item->price }},
                    {{ $item->quantity }}
                );
            @endforeach
        @endif

        $('#inquiryForm').on('submit', function(e) {
            if($('.product-row').length === 0) {
                e.preventDefault();
                if(typeof swal === 'function') {
                    swal("Notice", "Please add at least one product to the inquiry.", "warning");
                } else {
                    alert("Please add at least one product to the inquiry.");
                }
                return false;
            }
        });
    });
</script>
@endsection

