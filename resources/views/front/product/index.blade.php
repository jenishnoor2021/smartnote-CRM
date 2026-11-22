@extends('layouts.front')

@section('title', (isset($currentSubcategory) ? $currentSubcategory->subcategory_name : (isset($currentCategory) ? $currentCategory->category_name : 'All Books')) . ' - SMART NOTES PUBLICATION PVT. LTD.')

@section('page_style')
<link rel="stylesheet" href="{{ asset('assets/css/sn-workbook-listing.css') }}">
<style>
  /* Sidebar Filter Cards */
  .sn-filter-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px 18px;
    margin-bottom: 22px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
  }
  .sn-filter-card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px dashed #e2e8f0;
    letter-spacing: -0.2px;
  }
  .sn-filter-card-title i {
    color: #084b87;
    font-size: 14px;
  }

  /* Active Filters Bar */
  .sn-active-filters-box {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 20px;
  }
  .sn-active-filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #1e293b;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 500;
    text-decoration: none;
    margin: 3px;
    transition: all 0.2s ease;
  }
  .sn-active-filter-chip:hover {
    background: #fee2e2;
    border-color: #fca5a5;
    color: #dc2626;
  }

  /* Reset Theme Categories Pollution */
  .sidebar-area .widget_categories a,
  .sn-filter-column .widget_categories a {
    display: flex !important;
    min-height: auto !important;
    height: auto !important;
    margin: 0 !important;
    padding: 0 !important;
    border-radius: 0 !important;
    background: transparent !important;
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
  }

  /* Categories & Series Accordion */
  .sn-cat-accordion {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  .sn-cat-accordion .accordion-item {
    border: 1px solid #e2e8f0 !important;
    border-radius: 10px !important;
    overflow: hidden !important;
    background: #ffffff !important;
    margin: 0 !important;
    box-shadow: none !important;
    transition: border-color 0.2s ease;
  }
  .sn-cat-accordion .accordion-item:hover {
    border-color: #cbd5e1 !important;
  }
  .sn-cat-accordion .accordion-header {
    margin: 0 !important;
    padding: 0 !important;
  }
  .sn-cat-header-btn {
    width: 100% !important;
    padding: 10px 12px !important;
    background: #f8fafc !important;
    border: none !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    font-size: 13.5px !important;
    font-weight: 600 !important;
    color: #1e293b !important;
    text-align: left !important;
    cursor: pointer !important;
    transition: background-color 0.2s, color 0.2s !important;
    outline: none !important;
    box-shadow: none !important;
  }
  .sn-cat-header-btn::after {
    display: none !important; /* Hide Bootstrap default chevron */
  }
  .sn-cat-header-btn:hover {
    background: #eff6ff !important;
    color: #084b87 !important;
  }
  .sn-cat-header-btn:not(.collapsed) {
    background: #eff6ff !important;
    color: #084b87 !important;
    border-bottom: 1px solid #dbeafe !important;
  }
  .sn-cat-title-text {
    flex: 1 1 auto;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    padding-right: 6px;
    font-family: inherit;
  }
  .sn-cat-badge {
    background: #e2e8f0;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 10px;
    margin-right: 6px;
    flex-shrink: 0;
    line-height: 1.2;
  }
  .sn-cat-header-btn:not(.collapsed) .sn-cat-badge {
    background: #bfdbfe;
    color: #1d4ed8;
  }
  .sn-cat-arrow {
    font-size: 11px;
    color: #94a3b8;
    transition: transform 0.25s ease;
    flex-shrink: 0;
  }
  .sn-cat-header-btn:not(.collapsed) .sn-cat-arrow {
    transform: rotate(180deg);
    color: #084b87;
  }

  /* Subcategories Inside Accordion */
  .sn-subcat-list {
    padding: 6px 6px !important;
    background: #ffffff !important;
    display: flex;
    flex-direction: column;
    gap: 3px;
  }
  .sn-subcat-link {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 7px 10px !important;
    margin: 0 !important;
    min-height: auto !important;
    height: auto !important;
    border-radius: 7px !important;
    font-size: 12.5px !important;
    font-weight: 500 !important;
    color: #475569 !important;
    text-decoration: none !important;
    background: transparent !important;
    line-height: 1.35 !important;
    font-family: inherit !important;
    border: none !important;
    transition: all 0.15s ease !important;
  }
  .sn-subcat-link:hover {
    background: #f1f5f9 !important;
    color: #084b87 !important;
    padding-left: 14px !important;
  }
  .sn-subcat-link.active {
    background: #084b87 !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 6px rgba(8, 75, 135, 0.22) !important;
  }
  .sn-subcat-count {
    background: #f1f5f9;
    color: #64748b;
    font-size: 10.5px;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 8px;
    flex-shrink: 0;
    line-height: 1.3;
  }
  .sn-subcat-link.active .sn-subcat-count {
    background: rgba(255, 255, 255, 0.25) !important;
    color: #ffffff !important;
  }

  /* Price Range Items */
  .sn-price-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }
  .sn-price-item {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 8px 12px !important;
    margin: 0 !important;
    min-height: auto !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 9px !important;
    font-size: 13px !important;
    color: #334155 !important;
    text-decoration: none !important;
    background: #ffffff !important;
    transition: all 0.18s ease !important;
    font-family: inherit !important;
  }
  .sn-price-item:hover {
    background: #f8fafc !important;
    border-color: #cbd5e1 !important;
    color: #084b87 !important;
  }
  .sn-price-item.active {
    background: #eff6ff !important;
    border-color: #3b82f6 !important;
    color: #084b87 !important;
    font-weight: 600 !important;
  }
  .sn-price-radio {
    width: 16px;
    height: 16px;
    border: 2px solid #cbd5e1;
    border-radius: 50%;
    margin-right: 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s;
  }
  .sn-price-item.active .sn-price-radio {
    border-color: #084b87;
  }
  .sn-price-radio::after {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: transparent;
    transition: all 0.2s;
  }
  .sn-price-item.active .sn-price-radio::after {
    background: #084b87;
  }

  /* Medium / Stream Items */
  .sn-medium-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 7px;
  }
  .sn-medium-btn {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 9px 12px !important;
    min-height: auto !important;
    margin: 0 !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 9px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #334155 !important;
    text-decoration: none !important;
    background: #ffffff !important;
    transition: all 0.18s ease !important;
    font-family: inherit !important;
  }
  .sn-medium-btn:hover {
    background: #f8fafc !important;
    border-color: #cbd5e1 !important;
    color: #084b87 !important;
  }
  .sn-medium-btn.active {
    background: #084b87 !important;
    border-color: #084b87 !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    box-shadow: 0 2px 7px rgba(8, 75, 135, 0.2) !important;
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
        <h1 class="breadcumb-title">
          @if(isset($currentSubcategory))
            {{ $currentSubcategory->subcategory_name }}
          @elseif(isset($currentCategory))
            {{ $currentCategory->category_name }}
          @elseif(request('search'))
            Search: "{{ request('search') }}"
          @else
            All Books &amp; Educational Publications
          @endif
        </h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span><a href="{{ route('front.product.index') }}">Books</a></span>
            @if(isset($currentCategory))
              <span><a href="{{ route('front.product.index', ['category' => $currentCategory->id]) }}">{{ $currentCategory->category_name }}</a></span>
            @endif
            @if(isset($currentSubcategory))
              <span>{{ $currentSubcategory->subcategory_name }}</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="sn-filter-backdrop" aria-hidden="true"></div>

  <!--==============================
      Main Catalog Listing Area
  ============================== -->
  <section class="books-layout1 space-top category-listing space-extra-bottom sn-workbook-listing">
    <div class="container-fluid">
      <div class="row g-4">

        <!-- Left / Products Column -->
        <div class="col-xl-9 col-lg-8">
          
          <!-- Top Sort & Filter Bar -->
          <div class="vs-sort-bar">
            <div class="row g-2 align-items-center justify-content-between">
              <div class="col-auto d-lg-none">
                <button class="sn-filter-trigger vs-btn py-2 px-3 fs-6" type="button" aria-controls="snMobileFilterPanel" aria-expanded="false">
                  <i class="fa-solid fa-sliders me-1"></i> Filters
                </button>
              </div>
              <div class="col-auto">
                <p class="woocommerce-result-count mb-0">
                  Showing <span>{{ $products->firstItem() ?? 1 }}–{{ $products->lastItem() ?? $products->count() }} of {{ $products->total() }}</span> books
                </p>
              </div>
              <div class="col-auto">
                <form class="woocommerce-ordering d-flex align-items-center gap-2" method="GET" action="{{ route('front.product.index') }}">
                  @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                  @if(request('subcategory')) <input type="hidden" name="subcategory" value="{{ request('subcategory') }}"> @endif
                  @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                  @if(request('medium')) <input type="hidden" name="medium" value="{{ request('medium') }}"> @endif
                  @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                  @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif

                  <select name="orderby" class="orderby form-select form-select-sm" aria-label="Sort books" onchange="this.form.submit()">
                    <option value="latest" {{ request('orderby') == 'latest' ? 'selected' : '' }}>Sort By: Latest</option>
                    <option value="price_asc" {{ in_array(request('orderby'), ['price', 'price_asc']) ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ in_array(request('orderby'), ['price-desc', 'price_desc']) ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ request('orderby') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                    <option value="oldest" {{ request('orderby') == 'oldest' ? 'selected' : '' }}>Sort By: Oldest</option>
                  </select>

                  <select name="limit" class="form-select form-select-sm" aria-label="Books per page" onchange="this.form.submit()">
                    <option value="12" {{ request('limit', 12) == 12 ? 'selected' : '' }}>Show: 12</option>
                    <option value="24" {{ request('limit') == 24 ? 'selected' : '' }}>Show: 24</option>
                    <option value="36" {{ request('limit') == 36 ? 'selected' : '' }}>Show: 36</option>
                    <option value="48" {{ request('limit') == 48 ? 'selected' : '' }}>Show: 48</option>
                  </select>
                </form>
              </div>
            </div>

            <!-- Active Filter Badges -->
            @if(request('category') || request('subcategory') || request('search') || request('medium') || request('min_price') || request('max_price'))
              <div class="mt-2 pt-2 border-top d-flex align-items-center flex-wrap">
                <span class="small text-muted me-2">Active Filters:</span>
                @if(isset($currentCategory))
                  <a href="{{ route('front.product.index', request()->except('category', 'subcategory', 'page')) }}" class="sn-active-filter-badge">
                    Category: {{ $currentCategory->category_name }} <i class="fa-solid fa-xmark"></i>
                  </a>
                @endif
                @if(isset($currentSubcategory))
                  <a href="{{ route('front.product.index', request()->except('subcategory', 'page')) }}" class="sn-active-filter-badge">
                    Subcategory: {{ $currentSubcategory->subcategory_name }} <i class="fa-solid fa-xmark"></i>
                  </a>
                @endif
                @if(request('medium'))
                  <a href="{{ route('front.product.index', request()->except('medium', 'page')) }}" class="sn-active-filter-badge">
                    Medium: {{ request('medium') }} <i class="fa-solid fa-xmark"></i>
                  </a>
                @endif
                @if(request('search'))
                  <a href="{{ route('front.product.index', request()->except('search', 'page')) }}" class="sn-active-filter-badge">
                    Search: "{{ request('search') }}" <i class="fa-solid fa-xmark"></i>
                  </a>
                @endif
                @if(request('min_price') || request('max_price'))
                  <a href="{{ route('front.product.index', request()->except('min_price', 'max_price', 'page')) }}" class="sn-active-filter-badge">
                    Price: ₹{{ request('min_price', 0) }} - ₹{{ request('max_price', 'Any') }} <i class="fa-solid fa-xmark"></i>
                  </a>
                @endif
                <a href="{{ route('front.product.index') }}" class="small text-danger fw-bold ms-2">Clear All</a>
              </div>
            @endif
          </div>

          <!-- Product Grid -->
          <div class="row g-4">
            @forelse($products as $pIndex => $p)
              <div class="col-xl-3 col-md-4 col-sm-6">
                <div class="product-style1 wow animate__fadeInUp" data-wow-delay="{{ 0.15 + (($pIndex % 4) * 0.08) }}s">
                  <div class="product-img">
                    <a href="{{ route('front.product.show', $p->id) }}">
                      @if(!empty($p->cover_image))
                        <img src="{{ asset($p->cover_image) }}" alt="{{ $p->product_name }}" style="max-height: 220px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ asset('assets/img/book/pg-6.png') }}';">
                      @else
                        <img src="{{ asset('assets/img/book/pg-6.png') }}" alt="{{ $p->product_name }}" style="max-height: 220px; object-fit: contain;">
                      @endif
                    </a>
                    <div class="product-btns">
                      <button type="button" class="icon-btn cart btn-add-to-cart-quick" data-id="{{ $p->id }}" title="Add to Cart">
                        <i class="fa-solid fa-basket-shopping"></i>
                      </button>
                    </div>
                  </div>
                  <div class="product-content">
                    <div class="product-rating">
                      <span class="star"><i class="fas fa-star"></i> (4.8)</span>
                      <ul class="price-list">
                        @if($p->mrp_price > $p->selling_price)
                          <li><del>₹{{ number_format($p->mrp_price, 0) }}</del></li>
                        @endif
                        <li>₹{{ number_format($p->selling_price, 0) }}/{{ $p->unit ?? 'pcs' }}</li>
                      </ul>
                    </div>
                    <h2 class="product-title">
                      <a href="{{ route('front.product.show', $p->id) }}">{{ $p->product_name }}</a>
                    </h2>
                    <span class="product-author"><strong>By:</strong> {{ $p->author_publisher ?? 'SmartNotes Publication' }}</span>
                    @if($p->standard_class)
                      <span class="product-author"><strong>Class:</strong> {{ $p->standard_class }}</span>
                    @endif
                    <span class="product-author"><strong>Stream:</strong> {{ $p->medium ?? ($p->category->category_name ?? 'English Medium') }}</span>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 text-center text-muted py-5">
                <i class="fa-solid fa-book-open text-secondary mb-3" style="font-size: 55px;"></i>
                <h4>No books found matching your criteria.</h4>
                <p class="text-secondary mb-4">Try clearing some filters or browse all our school publications.</p>
                <a href="{{ route('front.product.index') }}" class="vs-btn">View All Books</a>
              </div>
            @endforelse
          </div>

          <!-- Pagination -->
          <div class="d-flex justify-content-center mt-5">
            {{ $products->links('front.pagination') }}
          </div>

        </div>

        <!-- Right / Filter Sidebar Column -->
        <div class="col-xl-3 col-lg-4 sn-filter-column" id="snMobileFilterPanel">
          <div class="sn-filter-heading d-lg-none d-flex justify-content-between align-items-center p-3 border-bottom">
            <strong>Filters</strong>
            <button type="button" class="sn-filter-close btn btn-sm btn-outline-secondary" aria-label="Close filters">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>

          <aside class="sidebar-area">
            
            <!-- Search Widget -->
            <div class="sn-filter-card wow animate__fadeInUp p-3" data-wow-delay="0.15s">
              <form class="search-form m-0" action="{{ route('front.product.index') }}" method="GET">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('subcategory')) <input type="hidden" name="subcategory" value="{{ request('subcategory') }}"> @endif
                @if(request('medium')) <input type="hidden" name="medium" value="{{ request('medium') }}"> @endif
                @if(request('orderby')) <input type="hidden" name="orderby" value="{{ request('orderby') }}"> @endif
                @if(request('limit')) <input type="hidden" name="limit" value="{{ request('limit') }}"> @endif
                <div class="position-relative">
                  <input type="text" name="search" class="form-control rounded-pill ps-3 pe-5 py-2" placeholder="Search by book name..." value="{{ request('search') }}" style="font-size: 13.5px; border: 1px solid #cbd5e1;">
                  <button class="btn btn-primary rounded-circle position-absolute top-50 end-0 translate-middle-y me-1 p-0 d-flex align-items-center justify-content-center" type="submit" style="width: 32px; height: 32px;" aria-label="Search">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 12px;"></i>
                  </button>
                </div>
              </form>
            </div>

            <!-- Active Filters Bar -->
            @php
              $hasFilters = request('category') || request('subcategory') || request('min_price') || request('max_price') || request('medium') || request('search');
            @endphp
            @if($hasFilters)
              <div class="sn-active-filters-box wow animate__fadeInUp" data-wow-delay="0.20s">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="fw-bold text-dark" style="font-size: 12.5px;"><i class="fa-solid fa-filter me-1 text-primary"></i> Active Filters</span>
                  <a href="{{ route('front.product.index') }}" class="small text-danger fw-semibold text-decoration-none" style="font-size: 11.5px;">
                    <i class="fa-solid fa-rotate-left me-1"></i> Clear All
                  </a>
                </div>
                <div class="d-flex flex-wrap">
                  @if(request('search'))
                    <a href="{{ route('front.product.index', request()->except('search', 'page')) }}" class="sn-active-filter-chip">
                      "{{ request('search') }}" <i class="fa-solid fa-xmark"></i>
                    </a>
                  @endif
                  @if(request('category'))
                    @php $catObj = $filterCategories->firstWhere('id', request('category')); @endphp
                    @if($catObj)
                      <a href="{{ route('front.product.index', request()->except('category', 'subcategory', 'page')) }}" class="sn-active-filter-chip">
                        Cat: {{ $catObj->category_name }} <i class="fa-solid fa-xmark"></i>
                      </a>
                    @endif
                  @endif
                  @if(request('subcategory'))
                    @php 
                      $subObj = null;
                      foreach($filterCategories as $c) {
                        $f = $c->subcategories->firstWhere('id', request('subcategory'));
                        if ($f) { $subObj = $f; break; }
                      }
                    @endphp
                    @if($subObj)
                      <a href="{{ route('front.product.index', request()->except('subcategory', 'page')) }}" class="sn-active-filter-chip">
                        {{ $subObj->subcategory_name }} <i class="fa-solid fa-xmark"></i>
                      </a>
                    @endif
                  @endif
                  @if(request('medium'))
                    <a href="{{ route('front.product.index', request()->except('medium', 'page')) }}" class="sn-active-filter-chip">
                      {{ request('medium') }} Medium <i class="fa-solid fa-xmark"></i>
                    </a>
                  @endif
                  @if(request('min_price') || request('max_price'))
                    <a href="{{ route('front.product.index', request()->except('min_price', 'max_price', 'page')) }}" class="sn-active-filter-chip">
                      Price Filter <i class="fa-solid fa-xmark"></i>
                    </a>
                  @endif
                </div>
              </div>
            @endif

            <!-- Categories & Series Widget -->
            <div class="sn-filter-card wow animate__fadeInUp" data-wow-delay="0.25s">
              <div class="sn-filter-card-title">
                <i class="fa-solid fa-layer-group"></i>
                <span>Categories &amp; Series</span>
              </div>
              
              <div class="accordion sn-cat-accordion" id="catalogCategoriesAccordion">
                @foreach($filterCategories as $fIdx => $cat)
                  @php
                    $isActiveCategory = request('category') == $cat->id || (isset($currentCategory) && $currentCategory->id == $cat->id);
                    $hasActiveSub = $cat->subcategories->contains('id', request('subcategory'));
                    $shouldExpand = $isActiveCategory || $hasActiveSub || $fIdx < 2;
                  @endphp
                  <div class="accordion-item">
                    <div class="accordion-header" id="headingCat{{ $cat->id }}">
                      <button class="sn-cat-header-btn {{ $shouldExpand ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCat{{ $cat->id }}" aria-expanded="{{ $shouldExpand ? 'true' : 'false' }}" aria-controls="collapseCat{{ $cat->id }}">
                        <span class="sn-cat-title-text" title="{{ $cat->category_name }}">{{ $cat->category_name }}</span>
                        <span class="sn-cat-badge">{{ $cat->products_count }}</span>
                        <i class="fa-solid fa-chevron-down sn-cat-arrow"></i>
                      </button>
                    </div>
                    <div id="collapseCat{{ $cat->id }}" class="accordion-collapse collapse {{ $shouldExpand ? 'show' : '' }}" aria-labelledby="headingCat{{ $cat->id }}">
                      <div class="sn-subcat-list">
                        <a href="{{ route('front.product.index', array_merge(request()->except('subcategory', 'page'), ['category' => $cat->id])) }}" class="sn-subcat-link {{ $isActiveCategory && !request('subcategory') ? 'active' : '' }}">
                          <span><i class="fa-solid fa-folder-open me-1 small opacity-75"></i> All {{ $cat->category_name }}</span>
                          <span class="sn-subcat-count">{{ $cat->products_count }}</span>
                        </a>
                        @foreach($cat->subcategories as $sub)
                          <a href="{{ route('front.product.index', array_merge(request()->except('page'), ['category' => $cat->id, 'subcategory' => $sub->id])) }}" class="sn-subcat-link {{ request('subcategory') == $sub->id ? 'active' : '' }}">
                            <span>{{ $sub->subcategory_name }}</span>
                            <span class="sn-subcat-count">{{ $sub->products_count }}</span>
                          </a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Price Filter Range Widget -->
            <div class="sn-filter-card wow animate__fadeInUp" data-wow-delay="0.35s">
              <div class="sn-filter-card-title">
                <i class="fa-solid fa-tags"></i>
                <span>Price Range</span>
              </div>
              <div class="sn-price-list">
                @php
                  $isAllPrices = !request('min_price') && !request('max_price');
                  $isUnder150 = request('max_price') == 150 && (!request('min_price') || request('min_price') == 0);
                  $is150To250 = request('min_price') == 150 && request('max_price') == 250;
                  $isAbove250 = request('min_price') == 250 && (!request('max_price') || request('max_price') == 1000);
                @endphp

                <a href="{{ route('front.product.index', array_merge(request()->except('min_price', 'max_price', 'page'))) }}" class="sn-price-item {{ $isAllPrices ? 'active' : '' }}">
                  <div class="d-flex align-items-center">
                    <span class="sn-price-radio"></span>
                    <span>All Prices</span>
                  </div>
                  @if($isAllPrices)<i class="fa-solid fa-check small text-primary"></i>@endif
                </a>

                <a href="{{ route('front.product.index', array_merge(request()->except('page'), ['min_price' => 0, 'max_price' => 150])) }}" class="sn-price-item {{ $isUnder150 ? 'active' : '' }}">
                  <div class="d-flex align-items-center">
                    <span class="sn-price-radio"></span>
                    <span>Under ₹150</span>
                  </div>
                  @if($isUnder150)<i class="fa-solid fa-check small text-primary"></i>@endif
                </a>

                <a href="{{ route('front.product.index', array_merge(request()->except('page'), ['min_price' => 150, 'max_price' => 250])) }}" class="sn-price-item {{ $is150To250 ? 'active' : '' }}">
                  <div class="d-flex align-items-center">
                    <span class="sn-price-radio"></span>
                    <span>₹150 to ₹250</span>
                  </div>
                  @if($is150To250)<i class="fa-solid fa-check small text-primary"></i>@endif
                </a>

                <a href="{{ route('front.product.index', array_merge(request()->except('page'), ['min_price' => 250, 'max_price' => 1000])) }}" class="sn-price-item {{ $isAbove250 ? 'active' : '' }}">
                  <div class="d-flex align-items-center">
                    <span class="sn-price-radio"></span>
                    <span>Above ₹250</span>
                  </div>
                  @if($isAbove250)<i class="fa-solid fa-check small text-primary"></i>@endif
                </a>
              </div>
            </div>

            <!-- Medium / Language Stream Filter Widget -->
            <div class="sn-filter-card wow animate__fadeInUp" data-wow-delay="0.45s">
              <div class="sn-filter-card-title d-flex justify-content-between align-items-center">
                <div>
                  <i class="fa-solid fa-language"></i>
                  <span>Medium / Stream</span>
                </div>
                @if(request('medium'))
                  <a href="{{ route('front.product.index', request()->except('medium', 'page')) }}" class="small text-danger text-decoration-none fw-normal" style="font-size: 11px;">
                    <i class="fa-solid fa-rotate-left me-1"></i>Reset
                  </a>
                @endif
              </div>
              <div class="sn-medium-grid">
                <a href="{{ route('front.product.index', array_merge(request()->except('page'), ['medium' => 'English'])) }}" class="sn-medium-btn {{ request('medium') == 'English' ? 'active' : '' }}">
                  <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>English Medium</span>
                  </div>
                  @if(request('medium') == 'English')
                    <i class="fa-solid fa-circle-check"></i>
                  @endif
                </a>

                <a href="{{ route('front.product.index', array_merge(request()->except('page'), ['medium' => 'Gujarati'])) }}" class="sn-medium-btn {{ request('medium') == 'Gujarati' ? 'active' : '' }}">
                  <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-book-bookmark"></i>
                    <span>Gujarati Medium</span>
                  </div>
                  @if(request('medium') == 'Gujarati')
                    <i class="fa-solid fa-circle-check"></i>
                  @endif
                </a>
              </div>
            </div>

          </aside>
        </div>

      </div>
    </div>
  </section>
@endsection

@section('page_script')
@endsection
