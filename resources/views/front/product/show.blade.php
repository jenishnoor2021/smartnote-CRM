@extends('layouts.front')

@section('title', $product->product_name . ' - SMART NOTES PUBLICATION PVT. LTD.')

@section('page_style')
<link rel="stylesheet" href="{{ asset('assets/css/sn-product-actions.css') }}">
<style>
  .sn-product-actions .vs-btn {
    cursor: pointer;
  }
  .sn-product-actions .sn-buy-now {
    background: #084b87 !important;
    color: #fff !important;
  }
  .sn-product-actions .sn-buy-now:hover {
    background: #063968 !important;
  }
  .sn-product-actions .sn-add-to-cart {
    background: #e6ac00 !important;
    color: #111 !important;
  }
  .sn-product-actions .sn-add-to-cart:hover {
    background: #cca000 !important;
  }
  .sn-inquiry-open {
    background: #0dcaf0 !important;
    color: #fff !important;
  }
  .sn-inquiry-open:hover {
    background: #0bb5d8 !important;
  }
  .product-price del {
    color: #94a3b8;
    margin-left: 8px;
    font-size: 16px;
    font-weight: 500;
  }
  .product-description .description .text {
    line-height: 1.8;
    font-size: 15px;
    color: #475569;
  }
</style>
@endsection

@section('content')
  <!--==============================
      Breadcrumb
  ============================== -->
  <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg-4.png') }}">
    <div class="container z-index-common">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">{{ $product->product_name }}</h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span><a href="{{ route('front.product.index') }}">Books</a></span>
            <span>{{ $product->product_name }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Shop Details Area Start -->
  <div class="vs-product-wrapper space-top space-extra-bottom">
    <div class="container">
      <div class="row gx-60 sn-product-details-row">

        <!-- Left Column: Vertical Gallery Rail & Main Enlarge Image -->
        <div class="col-lg-6 sn-product-gallery-column">
          <div class="product-slide-row sn-product-gallery wow animate__fadeInUp" data-wow-delay="0.30s">
            <div class="sn-gallery-rail" aria-label="Book image thumbnails">
              <button type="button" class="sn-gallery-scroll" data-direction="-1" aria-label="Scroll to previous thumbnails"><span aria-hidden="true">&#8249;</span></button>
              <div class="sn-gallery-thumbnails" data-lenis-prevent>
                @php
                  $mainImgUrl = ($product->cover_image && file_exists(public_path($product->cover_image))) 
                    ? asset($product->cover_image) 
                    : asset('assets/img/book/pg-6.png');
                @endphp
                <button type="button" class="sn-gallery-thumb" aria-label="View {{ $product->product_name }} cover" aria-pressed="true">
                  <img src="{{ $mainImgUrl }}" alt="{{ $product->product_name }} cover" loading="lazy">
                </button>

                @if($product->images && $product->images->count() > 0)
                  @foreach($product->images as $idx => $gImg)
                    @php
                      $gUrl = ($gImg->image && file_exists(public_path($gImg->image))) ? asset($gImg->image) : $mainImgUrl;
                    @endphp
                    <button type="button" class="sn-gallery-thumb" aria-label="View {{ $product->product_name }} page {{ $idx + 1 }}" aria-pressed="false">
                      <img src="{{ $gUrl }}" alt="{{ $product->product_name }} preview {{ $idx + 1 }}" loading="lazy">
                    </button>
                  @endforeach
                @else
                  @for($i = 1; $i <= 8; $i++)
                    @if(file_exists(public_path('assets/img/book/pg/pg-' . $i . '.png')))
                      <button type="button" class="sn-gallery-thumb" aria-label="View {{ $product->product_name }} page {{ $i }}" aria-pressed="false">
                        <img src="{{ asset('assets/img/book/pg/pg-' . $i . '.png') }}" alt="{{ $product->product_name }} page {{ $i }}" loading="lazy">
                      </button>
                    @endif
                  @endfor
                @endif
              </div>
              <button type="button" class="sn-gallery-scroll" data-direction="1" aria-label="Scroll to next thumbnails"><span aria-hidden="true">&#8250;</span></button>
            </div>
            <div class="product-big-img sn-gallery-main">
              <button type="button" class="sn-gallery-open" aria-label="Enlarge selected book image" aria-haspopup="dialog" aria-controls="snGalleryModal">
                <img src="{{ $mainImgUrl }}" alt="{{ $product->product_name }}">
              </button>
              <p class="sn-gallery-hint">Click image to enlarge</p>
            </div>
          </div>


        </div>

        <!-- Right Column: Product Meta, Pricing, Purchase & Inquiry Actions -->
        <div class="col-lg-6">
          <div class="product-about wow animate__fadeInUp" data-wow-delay="0.30s">
            <h2 class="product-title">{{ $product->product_name }}</h2>
            <span class="product-author"><strong>By:</strong> <a href="javascript:void(0);">{{ $product->author_publisher ?? 'SmartNotes Publication' }}</a></span>
            
            <p class="product-price">
              ₹{{ number_format($product->selling_price, 2) }}/{{ $product->unit ?? 'pcs' }}
              @if($product->mrp_price > $product->selling_price)
                <del> ₹{{ number_format($product->mrp_price, 2) }}/{{ $product->unit ?? 'pcs' }}</del>
                @php
                  $saving = $product->mrp_price - $product->selling_price;
                  $pct = round(($saving / $product->mrp_price) * 100);
                @endphp
                <span class="badge bg-danger ms-2" style="font-size: 13px; vertical-align: middle;">{{ $pct }}% OFF</span>
              @endif
            </p>

            <p class="text">
              {{ $product->short_description ?? ($product->description ? Str::limit(strip_tags($product->description), 250) : 'An exceptional educational book designed to introduce young learners to foundational concepts through vibrant visual illustrations and interactive learning content.') }}
            </p>

            <span class="product-instock">
              <p>Availability:</p>
              @if($product->is_in_stock)
                <span><i class="fas fa-check-square"></i>In Stock ({{ $product->stock_quantity ?? 'Available' }} copies)</span>
              @else
                <span class="text-danger"><i class="fas fa-times-circle"></i>Out of Stock</span>
              @endif
            </span>

            <!-- Actions: Stepper, Add to Cart, Buy Now, Inquiry Now, Wishlist -->
            <div class="actions sn-product-actions">
              <div class="quantity">
                <div class="quantity__field quantity-container">
                  <div class="quantity__buttons">
                    <button type="button" class="quantity-plus qty-btn" onclick="snAdjustQty(5)"><i class="fal fa-plus"></i></button>
                    <input type="number" id="quantity" class="qty-input" step="5" min="5" max="500" name="quantity" value="5" title="Qty" readonly>
                    <button type="button" class="quantity-minus qty-btn" onclick="snAdjustQty(-5)"><i class="fal fa-minus"></i></button>
                  </div>
                </div>
              </div>
              <button type="button" class="vs-btn sn-add-to-cart" id="btnAddToCart">
                <i class="fa-solid fa-cart-shopping me-1" aria-hidden="true"></i>Add to Cart
              </button>
              <button type="button" class="vs-btn sn-buy-now" id="btnBuyNow">
                <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>Buy Now
              </button>
              <a href="#snInquiryModal" class="vs-btn sn-inquiry-open" data-bs-toggle="modal" data-bs-target="#snInquiryModal" style="background: #0284c7; border-color: #0284c7; color: #fff;">
                <i class="fa-solid fa-circle-question" aria-hidden="true"></i>Inquiry Now
              </a>
              {{-- Wishlist commented out as requested --}}
              {{--
              <a href="{{ url('wishlist') }}" class="icon-btn" aria-label="Add to wishlist" title="Wishlist">
                <i class="far fa-heart" aria-hidden="true"></i>
              </a>
              --}}
            </div>

            <!-- Product Information Meta -->
            <div class="product_meta">
              <h4 class="h5">Information:</h4>
              <span class="sku_wrapper">
                <p>SKU:</p> <span class="sku">{{ $product->product_code ?? 'SN-' . $product->id }}</span>
              </span>
              @if($product->category)
                <span class="posted_in">
                  <p>Category:</p> <span rel="tag">{{ $product->category->category_name }}</span>
                </span>
              @endif
              @if($product->subcategory)
                <span class="posted_in">
                  <p>Sub Category:</p> <span rel="tag">{{ $product->subcategory->subcategory_name }}</span>
                </span>
              @endif
              @if($product->medium)
                <span class="posted_in">
                  <p>Medium / Stream:</p> <span rel="tag">{{ $product->medium }}</span>
                </span>
              @endif
              @if($product->subject)
                <span class="posted_in">
                  <p>Subject:</p> <span rel="tag">{{ $product->subject }}</span>
                </span>
              @endif
              @if($product->standard_class)
                <span>
                  <p>Recommended For:</p> <span rel="tag">{{ $product->standard_class }}</span>
                </span>
              @endif
            </div>

          </div>
        </div>
      </div>

      <!-- Description, Features & Reviews Tabs -->
      <div class="product-description wow animate__fadeInUp" data-wow-delay="0.50s">
        <div class="product-description__tab">
          <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Description</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-features-tab" data-bs-toggle="pill" data-bs-target="#pills-features" type="button" role="tab" aria-controls="pills-features" aria-selected="false">Key Features & Benefits</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Reviews</button>
            </li>
          </ul>
        </div>
        <div class="tab-content" id="pills-tabContent">
          <!-- Description Tab -->
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="description">
              <h6>About {{ $product->product_name }}</h6>
              <div class="text">
                {!! !empty($product->description) ? $product->description : nl2br(e($product->short_description ?? 'Designed to encourage early learning, this book helps young minds recognise foundational concepts, associate them with familiar objects, and develop essential language and cognitive skills.')) !!}
              </div>
            </div>
          </div>

          <!-- Key Features & Benefits Tab -->
          <div class="tab-pane fade" id="pills-features" role="tabpanel" aria-labelledby="pills-features-tab">
            <div class="description">
              @if(!empty($product->key_features))
                <div class="product_meta product-desc-list mb-4">
                  <h6>Key Features:</h6>
                  {!! $product->key_features !!}
                </div>
              @else
                <div class="product_meta product-desc-list mb-4">
                  <h6>Key Features:</h6>
                  <span class="ps-3"><i class="fa-solid fa-circle-arrow-right pe-2"></i><p class="pe-2">Comprehensive Learning:</p> <span>Covers core concepts systematically with age-appropriate illustrations.</span></span>
                  <span class="ps-3"><i class="fa-solid fa-circle-arrow-right pe-2"></i><p class="pe-2">Colourful Illustrations:</p> <span>Engaging full-color layouts and cheerful characters make learning joyful.</span></span>
                  <span class="ps-3"><i class="fa-solid fa-circle-arrow-right pe-2"></i><p class="pe-2">Interactive Activities:</p> <span>Packed with exercises designed to boost observation, identification, and retention.</span></span>
                  <span class="ps-3"><i class="fa-solid fa-circle-arrow-right pe-2"></i><p class="pe-2">Premium Quality Paper:</p> <span>Durable, high GSM paper suitable for frequent handling and pencil practice.</span></span>
                </div>
              @endif

              @if(!empty($product->learning_benefits))
                <div class="product_meta product-product-list">
                  <h6>Learning Benefits:</h6>
                  {!! $product->learning_benefits !!}
                </div>
              @else
                <div class="product_meta product-product-list">
                  <h6>Learning Benefits:</h6>
                  <span class="sku_wrapper"><i class="fa-regular fa-circle-right pe-2"></i><span>Improves visual observation and recognition skills.</span></span>
                  <span class="posted_in"><i class="fa-regular fa-circle-right pe-2"></i><span>Builds foundational vocabulary and early cognitive skills.</span></span>
                  <span><i class="fa-regular fa-circle-right pe-2"></i><span>Instills confidence and excitement for reading and exploration.</span></span>
                  <span><i class="fa-regular fa-circle-right pe-2"></i><span>Strengthens memory association between concepts and everyday objects.</span></span>
                </div>
              @endif
            </div>
          </div>

          <!-- Reviews Tab -->
          <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="woocommerce-reviews">
              <div class="vs-comment-form review-form">
                <div id="respond" class="comment-respond">
                  <div class="form-title">
                    <h3 class="blog-inner-title">Add A Review</h3>
                    <div class="rating-select">
                      <label>Your Rating</label>
                      <p class="stars">
                        <span>
                          <a class="star-1" href="javascript:void(0);">1</a>
                          <a class="star-2" href="javascript:void(0);">2</a>
                          <a class="star-3" href="javascript:void(0);">3</a>
                          <a class="star-4" href="javascript:void(0);">4</a>
                          <a class="star-5" href="javascript:void(0);">5</a>
                        </span>
                      </p>
                    </div>
                  </div>
                  <form onsubmit="event.preventDefault(); Swal.fire({ icon: 'info', title: 'Review Received', text: 'Thank you for reviewing ' + '{{ $product->product_name }}' + '! It will be published after moderation.' });">
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <input type="text" class="form-control" placeholder="Complete Name" required>
                      </div>
                      <div class="col-md-6 form-group">
                        <input type="email" class="form-control" placeholder="Email Address" required>
                      </div>
                      <div class="col-12 form-group">
                        <textarea class="form-control" placeholder="Write your review here..." rows="3" required></textarea>
                      </div>
                      <div class="col-12 form-group mb-0">
                        <button type="submit" class="vs-btn"><span class="vs-btn__bar"></span>Submit Review</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- Shop Details Area End -->

  <!-- Recommended Products Carousel -->
  <section class="books-layout1 style2 space-bottom">
    <div class="container">
      <div class="title-area2 animation-style1 title-anime">
        <h2 class="sec-title title-anime__title">Recommended Products</h2>
        <div class="arraw-area">
          <div class="d-flex justify-content-center align-items-center gap-2">
            <button class="icon-btn border-none" data-slick-prev=".book-carousel">
              <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button class="icon-btn" data-slick-next=".book-carousel">
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="row vs-carousel recomended-books g-4 book-carousel wow animate__fadeInUp" data-wow-delay="0.30s" data-slide-show="4" data-autoplay="true">
        @if(isset($otherProducts) && $otherProducts->count() > 0)
          @foreach($otherProducts as $rel)
            <div class="col-xl-2 col-md-3 col-sm-6">
              <div class="product-style1 wow animate__fadeInUp" data-wow-delay="0.30s">
                <a href="{{ route('front.product.show', $rel->id) }}">
                  <div class="product-img">
                    <img src="{{ $rel->cover_image && file_exists(public_path($rel->cover_image)) ? asset($rel->cover_image) : asset('assets/img/book/pg-1.png') }}" alt="{{ $rel->product_name }}">
                  </div>
                  <div class="product-content">
                    <div class="product-rating">
                      <span class="star"><i class="fas fa-star"></i> (4.8)</span>
                      <ul class="price-list">
                        @if($rel->mrp_price > $rel->selling_price)
                          <li><del>₹{{ number_format($rel->mrp_price, 0) }}/{{ $rel->unit ?? 'pcs' }}</del></li>
                        @endif
                        <li>₹{{ number_format($rel->selling_price, 0) }}/{{ $rel->unit ?? 'pcs' }}</li>
                      </ul>
                    </div>
                    <h2 class="product-title"><a href="{{ route('front.product.show', $rel->id) }}">{{ $rel->product_name }}</a></h2>
                    <span class="product-author"><strong>By:</strong> {{ $rel->author_publisher ?? 'SmartNotes Publication' }}</span>
                    @if($rel->standard_class)
                      <span class="product-author"><strong>Class:</strong> {{ $rel->standard_class }}</span>
                    @endif
                  </div>
                </a>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </section>

  <!-- Product Inquiry Modal -->
  <div class="modal fade sn-inquiry-modal" id="snInquiryModal" data-lenis-prevent data-bs-backdrop="static" tabindex="-1" aria-labelledby="snInquiryTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title fs-5" id="snInquiryTitle"><i class="fa-solid fa-circle-question text-warning me-2"></i>Product Inquiry</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close product inquiry"></button>
        </div>
        <div class="modal-body">
          <p class="sn-inquiry-product fw-bold fs-6 text-primary mb-3">{{ $product->product_name }}</p>
          <form class="sn-inquiry-form" data-endpoint="{{ route('front.inquiry.submit') }}" novalidate>
            <input type="hidden" name="product_id" id="snInquiryProductId" value="{{ $product->id }}">
            <div class="row g-3">
              <div class="col-12 col-md-6 sn-inquiry-field">
                <label class="form-label" for="snInquiry-customerName">Name <span aria-hidden="true" class="text-danger">*</span></label>
                <input class="form-control" id="snInquiry-customerName" name="customerName" type="text" autocomplete="name" minlength="2" maxlength="100" placeholder="e.g. Rahul Sharma" required aria-describedby="snInquiry-customerName-error">
                <div class="invalid-feedback" id="snInquiry-customerName-error"></div>
              </div>
              <div class="col-12 col-md-6 sn-inquiry-field">
                <label class="form-label" for="snInquiry-email">Email <span aria-hidden="true" class="text-danger">*</span></label>
                <input class="form-control" id="snInquiry-email" name="email" type="email" autocomplete="email" maxlength="254" placeholder="e.g. rahul@example.com" required aria-describedby="snInquiry-email-error">
                <div class="invalid-feedback" id="snInquiry-email-error"></div>
              </div>
              <div class="col-12 col-md-6 sn-inquiry-field">
                <label class="form-label" for="snInquiry-mobile">Mobile <span aria-hidden="true" class="text-danger">*</span></label>
                <input class="form-control" id="snInquiry-mobile" name="mobile" type="tel" autocomplete="tel-national" inputmode="numeric" pattern="[6-9][0-9]{9}" minlength="10" maxlength="10" placeholder="10-digit mobile number" required aria-describedby="snInquiry-mobile-error">
                <div class="invalid-feedback" id="snInquiry-mobile-error"></div>
              </div>
              <div class="col-12 col-md-6 sn-inquiry-field">
                <label class="form-label" for="snInquiry-quantity">Quantity <span aria-hidden="true" class="text-danger">*</span></label>
                <input class="form-control" id="snInquiry-quantity" name="quantity" type="number" readonly step="1" required aria-describedby="snInquiry-quantity-error">
                <div class="invalid-feedback" id="snInquiry-quantity-error"></div>
              </div>
              <div class="col-12 col-md-6 sn-inquiry-field">
                <label class="form-label" for="snInquiry-unitPrice">Unit Price <span aria-hidden="true" class="text-danger">*</span></label>
                <input class="form-control bg-light" id="snInquiry-unitPrice" name="unitPrice" type="text" readonly required aria-describedby="snInquiry-unitPrice-error">
                <div class="invalid-feedback" id="snInquiry-unitPrice-error"></div>
              </div>
              <div class="col-12 col-md-6 sn-inquiry-summary d-flex flex-column justify-content-center bg-light p-3 rounded">
                <p class="mb-1 text-muted small">Total Estimated Price</p>
                <output class="fw-bold text-success fs-5" id="snInquiryTotal" aria-live="polite">—</output>
              </div>
              <div class="col-12 sn-inquiry-field">
                <label class="form-label" for="snInquiry-message">Inquiry Message / Requirement <span aria-hidden="true" class="text-danger">*</span></label>
                <textarea class="form-control" id="snInquiry-message" name="message" rows="3" minlength="10" maxlength="1000" placeholder="Please enter your inquiry details, school name or delivery questions..." required aria-describedby="snInquiry-message-error"></textarea>
                <div class="invalid-feedback" id="snInquiry-message-error"></div>
              </div>
              <div class="col-12 sn-inquiry-bot mb-2">
                @include('partial.bot_protection', ['formKey' => 'inquiry', 'includeMath' => true, 'label' => 'Human Verification'])
              </div>
              <div class="col-12">
                <p class="small text-muted mb-2">Our team will log your inquiry directly into our CRM and respond promptly.</p>
                <p class="sn-inquiry-status fw-bold" role="status" aria-live="polite"></p>
                <button type="submit" class="vs-btn sn-inquiry-submit">Submit Inquiry</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Enlarge Image Lightbox Modal -->
  <div class="modal fade sn-gallery-modal" id="snGalleryModal" data-lenis-prevent tabindex="-1" aria-labelledby="snGalleryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title fs-5" id="snGalleryModalTitle">{{ $product->product_name }} - Image View</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="sn-gallery-lightbox">
            <button type="button" class="sn-gallery-prev" aria-label="Previous book image">&#8249;</button>
            <img src="{{ $mainImgUrl }}" alt="{{ $product->product_name }}">
            <button type="button" class="sn-gallery-next" aria-label="Next book image">&#8250;</button>
          </div>
          <p class="sn-gallery-counter" aria-live="polite" aria-atomic="true"></p>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page_script')
<script>
  // Unit price and Product ID from backend
  const PRODUCT_UNIT_PRICE = {{ floatval($product->selling_price) }};
  const PRODUCT_ID = {{ $product->id }};

  const MIN_QTY = 5;
  const QTY_STEP = 5;

  // Adjust Quantity on page in steps of 5 (minimum 5, no 0 or negative)
  function snAdjustQty(delta) {
    const qtyInput = document.getElementById('quantity');
    let current = parseInt(qtyInput ? qtyInput.value : MIN_QTY) || MIN_QTY;
    current += delta;
    if (current < MIN_QTY) current = MIN_QTY;
    if (current > 500) current = 500;
    if (qtyInput) qtyInput.value = current;
  }

  // Add to Cart AJAX
  document.getElementById('btnAddToCart')?.addEventListener('click', function() {
    const btn = this;
    const qtyInput = document.getElementById('quantity');
    const qty = qtyInput ? (parseInt(qtyInput.value, 10) || 5) : 5;
    const productId = {{ $product->id }};
    const origHtml = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Adding...';

    fetch('{{ route("front.cart.add") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ product_id: productId, quantity: qty })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        document.querySelectorAll('.headerCartCountBadge, #headerCartCount').forEach(el => {
          el.textContent = data.cart_count;
        });
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'success',
            title: 'Added to Cart!',
            text: data.message,
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-basket-shopping me-1"></i> View Cart & Checkout',
            cancelButtonText: 'Continue Shopping',
            confirmButtonColor: '#084b87',
            cancelButtonColor: '#64748b'
          }).then((res) => {
            if (res.isConfirmed) {
              window.location.href = '{{ route("front.cart") }}';
            }
          });
        } else {
          alert(data.message);
        }
      } else {
        alert(data.message || 'Could not add to cart.');
      }
    })
    .catch(err => {
      console.error(err);
      alert('An error occurred while adding to cart.');
    })
    .finally(() => {
      btn.disabled = false;
      btn.innerHTML = origHtml;
    });
  });

  // Buy Now - Direct Add to Cart and Navigate to /cart
  document.getElementById('btnBuyNow')?.addEventListener('click', function() {
    const btn = this;
    const qtyInput = document.getElementById('quantity');
    const qty = qtyInput ? (parseInt(qtyInput.value, 10) || 5) : 5;
    const productId = {{ $product->id }};
    const origHtml = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Processing...';

    fetch('{{ route("front.cart.add") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      },
      body: JSON.stringify({ product_id: productId, quantity: qty })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        window.location.href = '{{ route("front.cart") }}';
      } else {
        alert(data.message || 'Could not add to cart.');
        btn.disabled = false;
        btn.innerHTML = origHtml;
      }
    })
    .catch(err => {
      console.error(err);
      alert('An error occurred. Please try again.');
      btn.disabled = false;
      btn.innerHTML = origHtml;
    });
  });
</script>
@endsection
