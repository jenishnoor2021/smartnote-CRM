  <!-- Trending Products Partial -->
  <section class="trending-layout1 trending-books space">
    <div class="container">
      <div class="title-area2 animation-style1 title-anime">
        <span class="border-line d-xxl-block d-none"></span>
        <h2 class="sec-title title-anime__title">Trending On SMART NOTES PUBLICATION</h2>
        <a class="vs-btn wow animate__flipInX" data-wow-delay="0.30s" href="{{ route('front.product.index') }}">View More</a>
      </div>
      <div class="row g-4">
        @php
            $displayProducts = isset($trendingProducts) && $trendingProducts->count() > 0 
                ? $trendingProducts 
                : \App\Models\Product::where('is_active', 1)->take(6)->get();
        @endphp

        @forelse($displayProducts as $index => $prod)
        <div class="col-xl-2 col-md-4 col-sm-6">
          <div class="product-style1 wow animate__fadeInUp" data-wow-delay="{{ 0.20 + ($index * 0.10) }}s">
               <div class="product-img">
                  <a href="{{ route('front.product.show', $prod->id) }}">
                      @if($prod->cover_image && file_exists(public_path($prod->cover_image)))
                          <img src="{{ asset($prod->cover_image) }}" alt="{{ $prod->product_name }}" style="max-height: 220px; object-fit: contain;" />
                      @else
                          <img src="{{ asset('assets/img/book/evs-second.png') }}" alt="{{ $prod->product_name }}" style="max-height: 220px; object-fit: contain;" />
                      @endif
                  </a>
                  <div class="product-btns">
                    <button type="button" class="icon-btn cart btn-add-to-cart-quick" data-id="{{ $prod->id }}" title="Add to Cart">
                      <i class="fa-solid fa-basket-shopping"></i>
                    </button>
                  </div>
              </div>
            <div class="product-content">
              <div class="product-rating">
                <span class="star"><i class="fas fa-star"></i> (4.8)</span>
                <ul class="price-list">
                  @if($prod->mrp_price > $prod->selling_price)
                      <li><del>₹{{ number_format($prod->mrp_price, 0) }}</del></li>
                  @endif
                  <li>₹{{ number_format($prod->selling_price, 0) }}/pcs</li>
                </ul>
              </div>
              <span class="product-author"><strong>By:</strong> {{ $prod->author_publisher ?? 'SmartNotes Publication' }}</span>
              <span class="product-author"><strong>Class:</strong> {{ $prod->standard_class ?? 'Primary' }}</span>
              <span class="product-author"><strong>Stream:</strong> {{ $prod->medium ?? 'English Medium' }}</span>
              <h2 class="product-title"><a href="{{ route('front.product.show', $prod->id) }}">{{ $prod->product_name }}</a></h2>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
            <p>No products available right now. Please visit back soon!</p>
        </div>
        @endforelse
      </div>
    </div>
  </section>
