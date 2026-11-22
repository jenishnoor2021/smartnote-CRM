@extends('layouts.front')

@section('title', 'Checkout - SMART NOTES PUBLICATION PVT. LTD.')

@section('page_style')
<style>
  .sn-checkout-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    padding: 32px;
    margin-bottom: 24px;
  }
  @media (max-width: 767px) {
    .sn-checkout-card {
      padding: 20px 16px;
    }
  }
  .sn-checkout-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: #0f172a;
    padding-bottom: 14px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .sn-checkout-form .form-label {
    font-size: 13.5px;
    font-weight: 600;
    color: #334155 !important;
    margin-bottom: 6px;
    display: block;
  }
  .sn-checkout-form .form-label .text-danger {
    color: #ef4444 !important;
  }
  /* Force dark text and clean white background on checkout inputs */
  .sn-checkout-form input.form-control,
  .sn-checkout-form select.form-control,
  .sn-checkout-form textarea.form-control {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 11px 16px !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    height: 48px;
    line-height: normal;
    box-shadow: none !important;
    -webkit-text-fill-color: #0f172a !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }
  .sn-checkout-form input.form-control:focus,
  .sn-checkout-form select.form-control:focus,
  .sn-checkout-form textarea.form-control:focus {
    background-color: #ffffff !important;
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    border-color: #0284c7 !important;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18) !important;
    outline: none !important;
  }
  .sn-checkout-form input.form-control::placeholder,
  .sn-checkout-form textarea.form-control::placeholder {
    color: #94a3b8 !important;
    -webkit-text-fill-color: #94a3b8 !important;
    opacity: 1 !important;
  }
  .sn-checkout-form textarea.form-control {
    height: auto !important;
    min-height: 85px !important;
    line-height: 1.5 !important;
    resize: vertical;
  }
  /* Payment option cards */
  .sn-payment-option {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 18px;
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 14px;
    background: #ffffff;
  }
  .sn-payment-option:hover {
    border-color: #93c5fd;
    background: #f8fafc;
  }
  .sn-payment-option.active {
    border-color: #0284c7;
    background: #f0f9ff;
  }
  .sn-payment-option input[type="radio"] {
    width: 20px;
    height: 20px;
    accent-color: #0284c7;
    cursor: pointer;
  }
  .sn-payment-details {
    flex: 1;
  }
  .sn-payment-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 2px;
  }
  .sn-payment-subtitle {
    font-size: 12.5px;
    color: #64748b;
  }
  /* Summary card */
  .sn-summary-item {
    display: flex;
    gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
  }
  .sn-summary-item:last-child {
    border-bottom: none;
  }
  .sn-summary-thumb {
    width: 58px;
    height: 74px;
    border-radius: 6px;
    object-fit: contain;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    flex-shrink: 0;
  }
  .sn-summary-info {
    flex: 1;
    min-width: 0;
  }
  .sn-summary-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.35;
    margin-bottom: 4px;
  }
  .sn-summary-qty {
    font-size: 12.5px;
    color: #64748b;
  }
  .sn-summary-price {
    font-size: 14px;
    font-weight: 700;
    color: #0284c7;
    text-align: right;
    white-space: nowrap;
  }
</style>
@endsection

@section('content')
  <!-- Breadcrumb -->
  <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg-4.png') }}">
    <div class="container z-index-common">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">Checkout</h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span><a href="{{ route('front.cart') }}">Cart</a></span>
            <span>Checkout</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Checkout Section -->
  <div class="vs-checkout-wrapper space-top space-extra-bottom">
    <div class="container">

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
          <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
          <ul class="mb-0 ps-3">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <form action="{{ route('front.checkout.submit') }}" method="POST" id="snCheckoutForm" class="sn-checkout-form">
        @csrf

        <div class="row">
          <!-- Left Column: Shipping & Payment -->
          <div class="col-lg-7">
            <!-- 1. Customer & Delivery Address -->
            <div class="sn-checkout-card">
              <h3>
                <i class="fa-solid fa-location-dot text-primary"></i> Delivery & Customer Details
              </h3>

              <div class="row g-3">
                <div class="col-md-6 form-group">
                  <label class="form-label">Full Name <span class="text-danger">*</span></label>
                  <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="Your Full Name" required>
                </div>

                <div class="col-md-6 form-group">
                  <label class="form-label">Mobile Phone Number <span class="text-danger">*</span></label>
                  <input type="tel" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" placeholder="10-digit mobile number" pattern="[6-9][0-9]{9}" maxlength="10" required>
                </div>

                <div class="col-12 form-group">
                  <label class="form-label">Email Address <span class="text-muted">(Optional for invoice)</span></label>
                  <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" placeholder="you@example.com">
                </div>

                <div class="col-12 form-group">
                  <label class="form-label">Complete Delivery Address <span class="text-danger">*</span></label>
                  <textarea name="shipping_address" rows="2" class="form-control" placeholder="House/Shop no., Building, Street Name, Landmark..." required>{{ old('shipping_address') }}</textarea>
                </div>

                <div class="col-md-4 form-group">
                  <label class="form-label">City / Town <span class="text-danger">*</span></label>
                  <input type="text" name="city" class="form-control" value="{{ old('city') }}" placeholder="City name" required>
                </div>

                <div class="col-md-4 form-group">
                  <label class="form-label">State <span class="text-danger">*</span></label>
                  <input type="text" name="state" class="form-control" value="{{ old('state', 'Gujarat') }}" placeholder="State" required>
                </div>

                <div class="col-md-4 form-group">
                  <label class="form-label">Pincode <span class="text-danger">*</span></label>
                  <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}" placeholder="6-digit pincode" pattern="[0-9]{6}" maxlength="6" required>
                </div>

                <div class="col-12 form-group">
                  <label class="form-label">Order Notes / Instructions <span class="text-muted">(Optional)</span></label>
                  <textarea name="notes" rows="2" class="form-control" placeholder="Any specific instructions for delivery...">{{ old('notes') }}</textarea>
                </div>
              </div>
            </div>

            <!-- 2. Payment & Verification Process -->
            <div class="sn-checkout-card">
              <h3>
                <i class="fa-solid fa-file-invoice-dollar text-primary"></i> Payment & Order Confirmation
              </h3>

              <input type="hidden" name="payment_method" value="razorpay_link">

              <div class="p-3 rounded-3" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                <div class="d-flex align-items-start gap-3">
                  <div style="width: 44px; height: 44px; background: #16a34a; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);">
                    <i class="fa-solid fa-phone-volume"></i>
                  </div>
                  <div>
                    <h5 class="fw-bold text-success mb-1" style="font-size: 15px;">
                      Pay After Seller Confirmation (No Upfront Online Payment Required)
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 13px; line-height: 1.55;">
                      After you place your order, our sales & customer support team will call you to verify your order and shipping address. Following phone confirmation, an official <strong>Razorpay Payment Link</strong> will be sent to your Mobile / WhatsApp to complete payment securely.
                    </p>
                  </div>
                </div>
              </div>

              <div class="d-flex align-items-center gap-2 mt-3 text-muted small">
                <i class="fa-solid fa-shield-halved text-success"></i>
                <span>No credit card, debit card, or UPI details are required to place your order now.</span>
              </div>
            </div>

            <!-- 3. Bot Protection & Submit -->
            <div class="sn-checkout-card">
              <h3>
                <i class="fa-solid fa-shield-halved text-primary"></i> Security & Order Placement
              </h3>

              <div class="mb-3">
                @include('partial.bot_protection', ['formKey' => 'checkout', 'label' => 'Security Verification'])
              </div>

              <button type="submit" id="btnPlaceOrder" class="vs-btn w-100 justify-content-center text-center py-3 fs-6">
                <i class="fa-solid fa-check-circle me-2"></i> Confirm & Place Order (₹{{ number_format($subtotal, 2) }})
              </button>

              <div class="text-center text-muted small mt-2">
                <i class="fa-solid fa-lock text-success me-1"></i> Your information is encrypted and securely processed.
              </div>
            </div>
          </div>

          <!-- Right Column: Order Review Summary -->
          <div class="col-lg-5">
            <div class="sn-checkout-card position-sticky" style="top: 100px;">
              <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                <h3 class="p-0 m-0 border-0 fs-5 fw-bold text-dark">
                  Order Summary
                </h3>
                <a href="{{ route('front.cart') }}" class="small text-primary fw-semibold text-decoration-none">
                  <i class="fal fa-edit me-1"></i> Edit Cart
                </a>
              </div>

              <!-- Product items list -->
              <div class="sn-summary-items mb-3" style="max-height: 380px; overflow-y: auto;">
                @foreach($cart as $id => $item)
                  <div class="sn-summary-item">
                    <img src="{{ !empty($item['cover_image']) ? asset($item['cover_image']) : asset('assets/img/book/maths-four.png') }}" alt="{{ $item['product_name'] ?? 'Product' }}" class="sn-summary-thumb" onerror="this.onerror=null;this.src='{{ asset('assets/img/book/maths-four.png') }}';">
                    <div class="sn-summary-info">
                      <div class="sn-summary-title">{{ $item['product_name'] }}</div>
                      <div class="sn-summary-qty">
                        Qty: <strong>{{ $item['quantity'] }}</strong> × ₹{{ number_format($item['price'], 2) }}
                      </div>
                      @if(!empty($item['standard_class']) || !empty($item['medium']))
                        <div class="text-muted" style="font-size: 11px;">
                          {{ $item['standard_class'] ?? '' }} {{ !empty($item['medium']) ? '(' . $item['medium'] . ')' : '' }}
                        </div>
                      @endif
                    </div>
                    <div class="sn-summary-price">
                      ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                  </div>
                @endforeach
              </div>

              <!-- Price Breakdown -->
              <div class="border-top pt-3 mb-2 d-flex justify-content-between text-muted">
                <span>Items Subtotal</span>
                <span class="text-dark fw-bold">₹{{ number_format($subtotal, 2) }}</span>
              </div>

              <div class="d-flex justify-content-between text-muted mb-3">
                <span>Delivery Charges</span>
                <span class="text-success fw-bold"><i class="fa-solid fa-check me-1"></i> FREE Delivery</span>
              </div>

              <div class="border-top pt-3 mb-4 d-flex justify-content-between align-items-baseline">
                <span class="fs-6 fw-bold text-dark">Total Amount</span>
                <span class="fs-4 fw-bolder text-primary">₹{{ number_format($subtotal, 2) }}</span>
              </div>

              <!-- Guarantee box -->
              <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px dashed #cbd5e1; font-size: 12.5px;">
                <div class="d-flex align-items-center gap-2 mb-2 text-dark fw-semibold">
                  <i class="fa-solid fa-award text-primary"></i> Publisher Assurance:
                </div>
                <ul class="list-unstyled mb-0 text-muted ps-2" style="line-height: 1.6;">
                  <li><i class="fa-solid fa-check text-success me-1"></i> Direct dispatch from Ahmedabad publishing warehouse</li>
                  <li><i class="fa-solid fa-check text-success me-1"></i> Safe water-resistant bulk packaging</li>
                  <li><i class="fa-solid fa-check text-success me-1"></i> GST Invoice issued with delivery</li>
                </ul>
              </div>

            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
@endsection

@section('page_script')
<script>
function snSelectPayment(mode) {
  document.getElementById('labelPayOnline')?.classList.toggle('active', mode === 'online');
  document.getElementById('labelPayCod')?.classList.toggle('active', mode === 'cod');
}

document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('snCheckoutForm');
  const btn = document.getElementById('btnPlaceOrder');

  if (form && btn) {
    form.addEventListener('submit', function(e) {
      if (!form.checkValidity()) {
        return;
      }
      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Placing Your Order...';
      btn.style.pointerEvents = 'none';
      btn.style.opacity = '0.85';
    });
  }
});
</script>
@endsection
