@extends('layouts.admin')
@section('content')

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4>
                <span class="text-semibold">{{ __('Create Discount Coupon') }}</span>
            </h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="icon-home2 position-left"></i>{{ __('Dashboard') }}</a></li>
            <li><a href="{{ route('admin.coupon.index') }}">{{ __('Coupons') }}</a></li>
            <li class="active">{{ __('Create') }}</li>
        </ul>
    </div>
</div>

<div class="content">
    <form action="{{ route('admin.coupon.store') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <strong>{{ __('Coupon Details') }}</strong>
                        </h5>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label class="col-lg-3 control-label text-semibold">
                                <span class="text-danger">*</span> {{ __('Coupon Code') }}:
                            </label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon-price-tag2"></i></span>
                                    <input type="text" name="code" id="code" class="form-control text-uppercase" placeholder="e.g. DISCOUNT10, FLAT200" value="{{ old('code') }}" required style="font-weight: bold; letter-spacing: 1px;">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" onclick="generateRandomCode()">Generate</button>
                                    </span>
                                </div>
                                <span class="help-block">Will automatically convert to UPPERCASE.</span>
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label text-semibold">
                                <span class="text-danger">*</span> {{ __('Discount Type') }}:
                            </label>
                            <div class="col-lg-9">
                                <label class="radio-inline">
                                    <input type="radio" name="type" value="percentage" {{ old('type') == 'percentage' ? 'checked' : '' }} onchange="toggleTypeHelp()">
                                    Percentage (%)
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="type" value="fixed" {{ old('type', 'fixed') == 'fixed' ? 'checked' : '' }} onchange="toggleTypeHelp()">
                                    Fixed Amount (₹)
                                </label>
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label text-semibold">
                                <span class="text-danger">*</span> {{ __('Discount Amount / Value') }}:
                            </label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <span class="input-group-addon" id="amount-prefix">₹</span>
                                    <input type="number" step="0.01" min="0.01" name="amount" id="amount" class="form-control" placeholder="e.g. 10 or 200" value="{{ old('amount') }}" required>
                                </div>
                                <span class="help-block" id="amount-help">Fixed discount value in Rupees.</span>
                                @error('amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group" id="max-discount-group" style="display: none;">
                            <label class="col-lg-3 control-label text-semibold">
                                {{ __('Max Discount Cap (₹)') }}:
                            </label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <span class="input-group-addon">₹</span>
                                    <input type="number" step="0.01" min="0" name="max_discount_amount" class="form-control" placeholder="e.g. 500 (Optional max discount limit)" value="{{ old('max_discount_amount') }}">
                                </div>
                                <span class="help-block">Maximum ceiling for percentage discount (leave blank for unlimited).</span>
                                @error('max_discount_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label text-semibold">
                                {{ __('Minimum Order Subtotal (₹)') }}:
                            </label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <span class="input-group-addon">₹</span>
                                    <input type="number" step="0.01" min="0" name="min_order_amount" class="form-control" placeholder="0 (Optional minimum order total)" value="{{ old('min_order_amount', 0) }}">
                                </div>
                                <span class="help-block">Minimum cart subtotal required to apply this coupon.</span>
                                @error('min_order_amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label text-semibold">
                                {{ __('Expiry Date') }}:
                            </label>
                            <div class="col-lg-9">
                                <input type="date" name="expires_at" class="form-control" value="{{ old('expires_at') }}" min="{{ date('Y-m-d') }}">
                                <span class="help-block">Leave blank for no expiration.</span>
                                @error('expires_at')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label text-semibold">
                                {{ __('Notes / Description') }}:
                            </label>
                            <div class="col-lg-9">
                                <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Special discount approved for Seller Rahul on Call">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label text-semibold">
                                {{ __('Status') }}:
                            </label>
                            <div class="col-lg-9">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                        <strong>Active</strong> (Available for application)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-right" style="margin-top: 20px;">
                            <a href="{{ route('admin.coupon.index') }}" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Coupon <i class="icon-arrow-right14 position-right"></i></button>
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
    function toggleTypeHelp() {
        var type = $('input[name="type"]:checked').val();
        if(type === 'percentage') {
            $('#amount-prefix').text('%');
            $('#amount-help').text('Discount percentage (between 1 and 100).');
            $('#max-discount-group').slideDown();
        } else {
            $('#amount-prefix').text('₹');
            $('#amount-help').text('Fixed discount amount in Rupees.');
            $('#max-discount-group').slideUp();
        }
    }

    function generateRandomCode() {
        var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        var code = 'SAVE';
        for (var i = 0; i < 4; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        $('#code').val(code);
    }

    $(document).ready(function() {
        toggleTypeHelp();
    });
</script>
@endsection

