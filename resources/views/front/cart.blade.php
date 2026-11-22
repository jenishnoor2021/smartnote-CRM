@extends('layouts.front')

@section('title', 'Shopping Cart - SMART NOTES PUBLICATION PVT. LTD.')

@section('page_style')
<style>
  .sn-cart-empty-box {
    background: #ffffff;
    border-radius: 16px;
    padding: 60px 20px;
    border: 1px dashed #cbd5e1;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
  }
  .sn-cart-empty-icon {
    width: 90px;
    height: 90px;
    background: #f1f5f9;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    color: #64748b;
    font-size: 38px;
  }
  .cart_table td {
    vertical-align: middle;
  }
  .cart_table .cart-productimage img {
    border-radius: 8px;
    object-fit: contain;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
  }
  .cart-meta-tag {
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 4px;
    background: #e0f2fe;
    color: #0369a1;
    display: inline-block;
    margin-top: 4px;
  }
  .quantity.style2 .qty-btn {
    width: 38px;
    height: 38px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    border-radius: 6px;
    color: #0f172a;
    transition: all 0.2s;
  }
  .quantity.style2 .qty-btn:hover {
    background: #084b87;
    color: #fff;
    border-color: #084b87;
  }
  .quantity.style2 .qty-input {
    width: 58px;
    height: 38px;
    border: 1px solid #cbd5e1;
    text-align: center;
    font-weight: 700;
    color: #0f172a;
    border-radius: 6px;
    background: #fff;
  }
  .btn-remove-item {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-remove-item:hover {
    background: #dc2626;
    color: #ffffff;
  }
  .cart_totals {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
  }
  .cart_totals td, .cart_totals th {
    padding: 16px 20px;
    border-color: #f1f5f9;
  }
  .cart-totals-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 28px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
  }
</style>
@endsection

@section('content')
  <!-- Breadcrumb -->
  <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg-4.png') }}">
    <div class="container z-index-common">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">Shopping Cart</h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span><a href="{{ route('front.product.index') }}">Books</a></span>
            <span>Cart</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Cart Area -->
  <div class="vs-cart-wrapper space-top space-extra-bottom">
    <div class="container">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
          <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
          <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div id="snEmptyCartView" class="{{ empty($cart) ? '' : 'd-none' }}">
        <div class="sn-cart-empty-box text-center">
          <div class="sn-cart-empty-icon">
            <i class="fa-solid fa-basket-shopping"></i>
          </div>
          <h2 class="h3 fw-bold text-dark mb-2">Your Shopping Cart is Empty</h2>
          <p class="text-muted mb-4" style="max-width: 480px; margin: 0 auto 24px;">You haven't added any books to your cart yet. Explore our educational catalog to select books for your school or bookshop.</p>
          <a href="{{ route('front.product.index') }}" class="vs-btn">
            <i class="fa-solid fa-book-open me-2"></i> Browse Books & Publications
          </a>
        </div>
      </div>

      <div id="snActiveCartView" class="{{ empty($cart) ? 'd-none' : '' }}">
        <div class="row">
          <div class="col-lg-8 mb-4">
            <div class="table-responsive bg-white rounded-3 border p-3">
              <table class="cart_table w-100 mb-0">
                <thead>
                  <tr class="text-muted small" style="border-bottom: 2px solid #f1f5f9;">
                    <th class="cart-col-image py-3" style="width: 90px;">Book</th>
                    <th class="cart-col-productname py-3">Details</th>
                    <th class="cart-col-price py-3">Price</th>
                    <th class="cart-col-quantity py-3 text-center" style="min-width: 140px;">Quantity</th>
                    <th class="cart-col-total py-3 text-end">Total</th>
                    <th class="cart-col-remove py-3 text-center" style="width: 60px;">Remove</th>
                  </tr>
                </thead>
                <tbody id="cartTableBody">
                  @foreach($cart as $id => $item)
                    <tr class="cart_item" id="cart_row_{{ $id }}" style="border-bottom: 1px solid #f1f5f9;">
                      <td class="cart-col-image py-3">
                        <a href="{{ route('front.product.show', $id) }}" class="cart-productimage">
                          <img src="{{ !empty($item['cover_image']) ? asset($item['cover_image']) : asset('assets/img/book/maths-four.png') }}" alt="{{ $item['product_name'] ?? 'Product' }}" width="75" height="95" style="border-radius: 6px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ asset('assets/img/book/maths-four.png') }}';">
                        </a>
                      </td>
                      <td class="cart-col-productname py-3">
                        <h4 class="fs-6 fw-bold mb-1">
                          <a href="{{ route('front.product.show', $id) }}" class="text-dark text-decoration-none">
                            {{ $item['product_name'] }}
                          </a>
                        </h4>
                        <div>
                          @if(!empty($item['standard_class']))
                            <span class="cart-meta-tag">{{ $item['standard_class'] }}</span>
                          @endif
                          @if(!empty($item['medium']))
                            <span class="cart-meta-tag" style="background: #fef3c7; color: #92400e;">{{ $item['medium'] }}</span>
                          @endif
                        </div>
                      </td>
                      <td class="cart-col-price py-3">
                        <span class="fw-bold text-dark">₹{{ number_format($item['price'], 2) }}</span>
                        @if(!empty($item['mrp_price']) && $item['mrp_price'] > $item['price'])
                          <div class="small text-muted text-decoration-line-through">₹{{ number_format($item['mrp_price'], 2) }}</div>
                        @endif
                      </td>
                      <td class="cart-col-quantity py-3 text-center">
                        <div class="quantity style2 d-inline-block">
                          <div class="d-flex align-items-center justify-content-center gap-1">
                            <button type="button" class="qty-btn" onclick="snChangeQty({{ $id }}, -5)" title="Decrease by 5">
                              <i class="fal fa-minus"></i>
                            </button>
                            <input type="number" id="cart_qty_{{ $id }}" class="qty-input" value="{{ $item['quantity'] }}" min="5" step="5" readonly>
                            <button type="button" class="qty-btn" onclick="snChangeQty({{ $id }}, 5)" title="Increase by 5">
                              <i class="fal fa-plus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="text-muted" style="font-size: 11px; margin-top: 4px;">Min 5 pcs (±5)</div>
                      </td>
                      <td class="cart-col-total py-3 text-end">
                        <strong class="fs-6 text-primary" id="line_total_{{ $id }}">
                          ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                        </strong>
                      </td>
                      <td class="cart-col-remove py-3 text-center">
                        <button type="button" class="btn-remove-item" onclick="snRemoveItem({{ $id }}, '{{ addslashes($item['product_name']) }}')" title="Remove this item">
                          <i class="fal fa-trash-alt"></i>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
              <a href="{{ route('front.product.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold">
                <i class="fa-solid fa-arrow-left me-1"></i> Continue Shopping
              </a>
              <span class="text-muted small">
                <i class="fa-solid fa-truck-fast text-success me-1"></i> Direct Publisher Delivery across India
              </span>
            </div>
          </div>

          <!-- Cart Totals & Checkout -->
          <div class="col-lg-4">
            <div class="cart-totals-box">
              <h3 class="fs-5 fw-bold text-dark pb-3 border-bottom mb-3 d-flex align-items-center justify-content-between">
                <span>Order Summary</span>
                <span class="badge bg-primary text-white rounded-pill px-2 py-1 fs-xs" id="cartTotalItemsCountBadge">{{ $totalItems ?? 0 }} items</span>
              </h3>

              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Cart Subtotal</span>
                <span class="fw-bold text-dark fs-6" id="cartSubtotalText">₹{{ number_format($subtotal, 2) }}</span>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Estimated Shipping</span>
                <span class="text-success fw-bold"><i class="fa-solid fa-check me-1"></i> FREE Delivery</span>
              </div>

              <div class="border-top pt-3 mb-4 d-flex justify-content-between align-items-baseline">
                <span class="fs-6 fw-bold text-dark">Total Amount</span>
                <span class="fs-4 fw-bolder text-primary" id="cartGrandTotalText">₹{{ number_format($subtotal, 2) }}</span>
              </div>

              <div class="d-grid gap-2">
                <a href="{{ route('front.checkout') }}" class="vs-btn justify-content-center text-center py-3 fs-6">
                  <i class="fa-solid fa-bag-shopping me-2"></i> Proceed to Checkout
                </a>
              </div>

              <div class="mt-4 pt-3 border-top text-muted fs-xs">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <i class="fa-solid fa-shield-halved text-primary"></i>
                  <span>100% Genuine Publications</span>
                </div>
                <div class="d-flex align-items-center gap-2 mb-2">
                  <i class="fa-solid fa-box-open text-primary"></i>
                  <span>Bulk Packaging & Fast Courier</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                  <i class="fa-solid fa-phone-volume text-primary"></i>
                  <span>Support: (+91) 99798-65666</span>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@section('page_script')
<script>
const CSRF_TOKEN = '{{ csrf_token() }}';

function snChangeQty(productId, delta) {
  const input = document.getElementById('cart_qty_' + productId);
  if (!input) return;

  let currentVal = parseInt(input.value, 10) || 5;
  let newVal = currentVal + delta;
  if (newVal < 5) newVal = 5; // Hard policy minimum of 5

  input.value = newVal;

  fetch('{{ route("front.cart.update") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': CSRF_TOKEN,
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json'
    },
    body: JSON.stringify({ product_id: productId, quantity: newVal })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      // Update line total
      const lineEl = document.getElementById('line_total_' + productId);
      if (lineEl) lineEl.textContent = data.line_total_formatted;

      // Update subtotals
      const subtotalEl = document.getElementById('cartSubtotalText');
      if (subtotalEl) subtotalEl.textContent = data.subtotal_formatted;

      const grandEl = document.getElementById('cartGrandTotalText');
      if (grandEl) grandEl.textContent = data.subtotal_formatted;

      // Update badge
      const countEl = document.getElementById('cartTotalItemsCountBadge');
      if (countEl) countEl.textContent = data.cart_count + ' items';

      document.querySelectorAll('.headerCartCountBadge, #headerCartCount').forEach(el => {
        el.textContent = data.cart_count;
      });
    } else {
      alert(data.message || 'Could not update cart quantity.');
      input.value = currentVal;
    }
  })
  .catch(err => {
    console.error(err);
    input.value = currentVal;
  });
}

function snRemoveItem(productId, productName) {
  const confirmMsg = 'Remove "' + productName + '" from your cart?';
  
  const proceedRemove = function() {
    const row = document.getElementById('cart_row_' + productId);
    if (row) {
      row.style.opacity = '0.4';
      row.style.pointerEvents = 'none';
    }

    fetch('{{ url("cart/remove") }}/' + productId, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        if (row) row.remove();

        // Update subtotals
        const subtotalEl = document.getElementById('cartSubtotalText');
        if (subtotalEl) subtotalEl.textContent = data.subtotal_formatted;

        const grandEl = document.getElementById('cartGrandTotalText');
        if (grandEl) grandEl.textContent = data.subtotal_formatted;

        const countEl = document.getElementById('cartTotalItemsCountBadge');
        if (countEl) countEl.textContent = data.cart_count + ' items';

        document.querySelectorAll('.headerCartCountBadge, #headerCartCount').forEach(el => {
          el.textContent = data.cart_count;
        });

        if (data.is_empty) {
          document.getElementById('snActiveCartView').classList.add('d-none');
          document.getElementById('snEmptyCartView').classList.remove('d-none');
        }
      } else {
        if (row) {
          row.style.opacity = '1';
          row.style.pointerEvents = 'auto';
        }
        alert(data.message || 'Could not remove item.');
      }
    })
    .catch(err => {
      console.error(err);
      if (row) {
        row.style.opacity = '1';
        row.style.pointerEvents = 'auto';
      }
      alert('An error occurred while removing item.');
    });
  };

  if (typeof Swal !== 'undefined') {
    Swal.fire({
      title: 'Remove Book?',
      text: confirmMsg,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc2626',
      cancelButtonColor: '#64748b',
      confirmButtonText: 'Yes, remove it'
    }).then((result) => {
      if (result.isConfirmed) {
        proceedRemove();
      }
    });
  } else {
    if (confirm(confirmMsg)) {
      proceedRemove();
    }
  }
}
</script>
@endsection
