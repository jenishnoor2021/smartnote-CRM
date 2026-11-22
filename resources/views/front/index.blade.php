@extends('layouts.front')

@section('title', 'Home - SMART NOTES PUBLICATION PVT. LTD.')

@section('page_style')
<link rel="stylesheet" href="{{ asset('assets/css/sn-home-categories.css') }}">
<style>
  .categorie-style2 .categorie-img img {
    height: 160px;
    width: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
  }
  .categorie-style2:hover .categorie-img img {
    transform: scale(1.08);
  }
  .product-style1 .product-img img {
    height: 220px;
    width: 100%;
    object-fit: contain;
    background: #f8fafc;
    padding: 10px;
    border-radius: 8px;
  }
</style>
@endsection

@section('content')
  <!--==============================
    Hero Area (Sliders)
  ==============================-->
  <section class="hero-layout3" data-wow-delay="0.25s">
    <div class="vs-carousel" data-fade="true" data-autoplay="true">
      @forelse($sliders ?? [] as $slIndex => $slide)
      <div class="hero-item" data-bg-src="{{ $slide->bg_image ? asset($slide->bg_image) : asset('assets/img/bg/hero-bg-1.png') }}">
        <div class="container position-relative z-index">
          <div class="row g-1 gx-50 g-xs-0 align-items-center">
            <div class="col-xxl-8 col-xl-8 col-lg-7 col-md-7 col-sm-7 col-xs-6 position-relative mt-lg-3 mt-sm-1 mt-2">
              <div class="hero-content">
                <h1 class="hero-title wow animate__fadeInUp" data-wow-delay="0.50s">
                  {{ $slide->title }}
                  @if($slide->highlight_text)
                    <span class="title-highlight">{{ $slide->highlight_text }}</span>
                  @endif
                </h1>
                @if($slide->subtitle)
                  <p class="hero-text wow animate__fadeInUp" data-wow-delay="0.75s">{{ $slide->subtitle }}</p>
                @endif
                @if($slide->button_text)
                  <a class="vs-btn wow animate__flipInX" data-wow-delay="0.95s" href="{{ $slide->button_link ? (str_starts_with($slide->button_link, 'http') ? $slide->button_link : url($slide->button_link)) : route('front.product.index') }}">
                    {{ $slide->button_text }}
                  </a>
                @endif
              </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-5 col-sm-5 col-xs-6 mt-lg-3 mt-sm-1 mt-2">
              <div class="hero-img wow animate__flipInY" data-wow-delay="0.50s">
                <img src="{{ !empty($slide->book_image) ? asset($slide->book_image) : asset('assets/img/hero/english-group-img.png') }}" alt="{{ $slide->title ?? 'Banner' }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/hero/english-group-img.png') }}';">
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="hero-item" data-bg-src="{{ asset('assets/img/bg/hero-bg-1.png') }}">
        <div class="container position-relative z-index">
          <div class="row g-1 gx-50 g-xs-0 align-items-center">
            <div class="col-xxl-8 col-xl-8 col-lg-7 col-md-7 col-sm-7 col-xs-6 position-relative mt-lg-3 mt-sm-1 mt-2">
              <div class="hero-content">
                <h1 class="hero-title wow animate__fadeInUp" data-wow-delay="0.50s">The Most Trusted <span class="title-highlight">PUBLICATION</span> in Education</h1>
                <p class="hero-text wow animate__fadeInUp" data-wow-delay="0.75s">High-quality, curriculum-aligned books for primary and pre-primary students.</p>
                <a class="vs-btn wow animate__flipInX" data-wow-delay="0.95s" href="{{ route('front.product.index') }}">Explore More</a>
              </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-5 col-sm-5 col-xs-6 mt-lg-3 mt-sm-1 mt-2">
              <div class="hero-img wow animate__flipInY" data-wow-delay="0.50s">
                <img src="{{ asset('assets/img/hero/english-group-img.png') }}" alt="hero image">
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforelse
    </div>
  </section>

  <!--==============================
    Explore Categories (Dynamic from DB)
  ==============================-->
  <section class="sn-categories arrow-wrap" aria-labelledby="sn-categories-title">
    <div class="container">
      <div class="sn-categories-heading">
        <span class="sn-categories-eyebrow">A BOOK FOR EVERY LEARNER</span>
        <h2 id="sn-categories-title">Explore <span>Categories</span></h2>
        <p>Find the right books for every stage of your child's learning journey.</p>
      </div>
      <div class="vs-carousel sn-categories-slider"
        data-slide-show="5" data-lg-slide-show="4" data-md-slide-show="3"
        data-sm-slide-show="2" data-xs-slide-show="2"
        data-arrows="true" data-xl-arrows="true" data-ml-arrows="true"
        data-lg-arrows="true" data-md-arrows="true" data-sm-arrows="true" data-xs-arrows="true"
        data-infinite="true" data-autoplay="true" data-autoplay-speed="3500"
        data-pauseon-hover="true" data-pauseon-focus="true" data-focuson-select="false" data-speed="350"
        data-slick='{"prevArrow":"<button type=\"button\" class=\"slick-prev\" aria-label=\"Previous categories\"><i class=\"fa-solid fa-arrow-left\" aria-hidden=\"true\"></i></button>","nextArrow":"<button type=\"button\" class=\"slick-next\" aria-label=\"Next categories\"><i class=\"fa-solid fa-arrow-right\" aria-hidden=\"true\"></i></button>"}'>
        @forelse($exploreCategories ?? [] as $idx => $cat)
          <div class="sn-category-slide">
            <a class="sn-category-card" href="{{ route('front.product.index', ['category' => $cat->id]) }}">
              <span class="sn-category-image">
                @php
                  $catFallbackList = [
                    'assets/img/hero/english-group-img.png',
                    'assets/img/hero/guj-group-img.png',
                    'assets/img/hero/hero-img-1-1.png',
                    'assets/img/hero/hero-img-2-1.png',
                    'assets/img/book/eng-workbook.png',
                    'assets/img/book/explore-by-series.png',
                  ];
                  $catImg = !empty($cat->image) 
                      ? $cat->image 
                      : $catFallbackList[$idx % count($catFallbackList)];
                @endphp
                <img src="{{ asset($catImg) }}" alt="{{ $cat->category_name }}" width="240" height="240" loading="lazy" style="object-fit: contain;" onerror="this.onerror=null;this.src='{{ asset('assets/img/hero/english-group-img.png') }}';">
              </span>
              <h3>{{ $cat->category_name }}</h3>
              <span class="sn-category-caption">
                {{ $cat->products_count > 0 ? $cat->products_count . ' Books Available' : 'Explore collection' }}
              </span>
            </a>
          </div>
        @empty
          <div class="sn-category-slide">
            <a class="sn-category-card sn-category-card--sets" href="{{ route('front.product.index') }}">
              <span class="sn-category-image"><img src="{{ asset('assets/img/hero/english-group-img.png') }}" alt="All Books" width="240" height="240" loading="lazy"></span>
              <h3>All School Books</h3>
              <span class="sn-category-caption">Complete learning collection</span>
            </a>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!--==============================
    Trending Products Partial
  ==============================-->
  @include('partial.products')

  <!--==============================
    Medium Highlight Offers
  ==============================-->
  <div class="offer-layout1 books-eng-guj space-bottom space-top">
    <div class="container-fluid">
      <div class="row g-4">
        <div class="col-xl-6 col-lg-6">
          <div class="offer-style1 wow animate__fadeInLeft" data-wow-delay="0.30s" data-bg-src="{{ asset('assets/img/bg/offer-bg1.jpg') }}">
            <div class="offer-img">
              <img src="{{ asset('assets/img/offer/brand-img1.png') }}" alt="English Medium Books">
            </div>
            <div class="offer-content">
              <div class="star-rating">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
              </div>
              <h4 class="offer-title">Premium Educational Book Series – English Medium</h4>
              <a class="vs-btn" href="{{ route('front.product.index', ['medium' => 'English']) }}">Explore More</a>
            </div>
            <span class="shape-mockup element1 z-index1 d-xxl-block d-none" data-wow-delay="0.80s" style="right: 0px; bottom: -5px;">
              <img src="{{ asset('assets/img/shapes/offer-shape1.png') }}" alt="offer shape">
            </span>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6">
          <div class="offer-style1 white-style wow animate__fadeInRight" data-wow-delay="0.30s" data-bg-src="{{ asset('assets/img/bg/offer-bg2.jpg') }}">
            <div class="offer-img">
              <img src="{{ asset('assets/img/offer/brand-img2.png') }}" alt="Gujarati Medium Books">
            </div>
            <div class="offer-content">
              <div class="star-rating">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
              </div>
              <h4 class="offer-title">Gujarati Medium Academic Excellence Series</h4>
              <a class="vs-btn" href="{{ route('front.product.index', ['medium' => 'Gujarati']) }}">Explore More</a>
            </div>
            <span class="shape-mockup element1 z-index1 d-xxl-block d-none" data-wow-delay="0.80s" style="right: 0px; bottom: -5px;">
              <img src="{{ asset('assets/img/shapes/offer-shape2.png') }}" alt="offer shape">
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--==============================
    Top Categories - English Version (Dynamic)
  ==============================-->
  <section class="categories-layout2 eng-category-books category-book-home space-top">
    <div class="container space-bottom position-relative">
      <div class="title-area2 animation-style1 title-anime">
        <h2 class="sec-title title-anime__title">Top Categories - English Version</h2>
        <a class="vs-btn wow animate__flipInX" data-wow-delay="0.70s" href="{{ route('front.product.index', ['medium' => 'English']) }}">View More</a>
      </div>
      <div class="row g-4">
        @php
          $subjectIcons = [
            // Pre-Primary standards
            'playgroup'           => 'assets/img/book/pg/pg-1.png',
            'pg'                  => 'assets/img/book/pg/pg-1.png',
            'nursery'             => 'assets/img/book/pg/pg-2.png',
            'junior kg'           => 'assets/img/book/jr-kg-eng.png',
            'jr kg'               => 'assets/img/book/jr-kg-eng.png',
            'jr. kg'              => 'assets/img/book/jr-kg-eng.png',
            'lkg'                 => 'assets/img/book/jr-kg-eng.png',
            'senior kg'           => 'assets/img/book/rhymes-sr-kg.png',
            'sr kg'               => 'assets/img/book/rhymes-sr-kg.png',
            'sr. kg'              => 'assets/img/book/rhymes-sr-kg.png',
            'ukg'                 => 'assets/img/book/rhymes-sr-kg.png',
            'phonics'             => 'assets/img/book/rhymes-sr-kg.png',
            'rhymes'              => 'assets/img/book/rhymes-sr-kg.png',

            // Standards / Classes
            'standard 1 (premium' => 'assets/img/book/eng-grammer/grammer-1.png',
            'standard 1 (standard'=> 'assets/img/book/eng-grammer/eng-grammer-1.jpg',
            'standard 1'          => 'assets/img/book/eng-grammer/grammer-1.png',
            'std 1'               => 'assets/img/book/eng-grammer/grammer-1.png',
            'std. 1'              => 'assets/img/book/eng-grammer/grammer-1.png',
            'class 1'             => 'assets/img/book/eng-grammer/grammer-1.png',

            'standard 2'          => 'assets/img/book/eng-grammer/grammer-2.png',
            'std 2'               => 'assets/img/book/eng-grammer/grammer-2.png',
            'std. 2'              => 'assets/img/book/eng-grammer/grammer-2.png',
            'class 2'             => 'assets/img/book/eng-grammer/grammer-2.png',

            'standard 3'          => 'assets/img/book/eng-grammer/grammer-3.png',
            'std 3'               => 'assets/img/book/eng-grammer/grammer-3.png',
            'std. 3'              => 'assets/img/book/eng-grammer/grammer-3.png',
            'class 3'             => 'assets/img/book/eng-grammer/grammer-3.png',

            'standard 4'          => 'assets/img/book/eng-grammer/grammer-4.png',
            'std 4'               => 'assets/img/book/eng-grammer/grammer-4.png',
            'std. 4'              => 'assets/img/book/eng-grammer/grammer-4.png',
            'class 4'             => 'assets/img/book/eng-grammer/grammer-4.png',

            'standard 5'          => 'assets/img/book/eng-grammer/grammer-5.png',
            'std 5'               => 'assets/img/book/eng-grammer/grammer-5.png',
            'std. 5'              => 'assets/img/book/eng-grammer/grammer-5.png',
            'class 5'             => 'assets/img/book/eng-grammer/grammer-5.png',

            'standard 6'          => 'assets/img/book/eng-grammer/grammer-6.png',
            'std 6'               => 'assets/img/book/eng-grammer/grammer-6.png',
            'std. 6'              => 'assets/img/book/eng-grammer/grammer-6.png',
            'class 6'             => 'assets/img/book/eng-grammer/grammer-6.png',

            'standard 7'          => 'assets/img/book/eng-grammer/grammer-7.png',
            'std 7'               => 'assets/img/book/eng-grammer/grammer-7.png',
            'std. 7'              => 'assets/img/book/eng-grammer/grammer-7.png',
            'class 7'             => 'assets/img/book/eng-grammer/grammer-7.png',

            'standard 8'          => 'assets/img/book/eng-grammer/grammer-8.png',
            'std 8'               => 'assets/img/book/eng-grammer/grammer-8.png',
            'std. 8'              => 'assets/img/book/eng-grammer/grammer-8.png',
            'class 8'             => 'assets/img/book/eng-grammer/grammer-8.png',

            // Subjects
            'workbook'            => 'assets/img/book/eng-workbook.png',
            'grammar'             => 'assets/img/book/eng-grammer/grammer-1.png',
            'mathematics'         => 'assets/img/book/maths-four.png',
            'maths'               => 'assets/img/book/maths-four.png',
            'science'             => 'assets/img/book/science-seven.png',
            'computer'            => 'assets/img/book/computer-four.png',
            'general knowledge'   => 'assets/img/book/gk-two.png',
            'g.k.'                => 'assets/img/book/gk-two.png',
            'environmental'       => 'assets/img/book/evs-second.png',
            'evs'                 => 'assets/img/book/evs-second.png',
            'value education'     => 'assets/img/book/value-edu-four.png',
            'english'             => 'assets/img/book/eng-four.png',
            'hindi'               => 'assets/img/book/hindi-five.png',
            'gujarati'            => 'assets/img/book/guj-four.png',
            'sanskrit'            => 'assets/img/book/sanskrit-six.png',
            'drawing'             => 'assets/img/book/guj/art-craft.png',
            'art'                 => 'assets/img/book/guj/art-craft.png',
          ];

          $engFallbacks = [
            'assets/img/book/pg/pg-1.png',
            'assets/img/book/pg/pg-2.png',
            'assets/img/book/jr-kg-eng.png',
            'assets/img/book/rhymes-sr-kg.png',
            'assets/img/book/eng-grammer/grammer-1.png',
            'assets/img/book/eng-grammer/grammer-2.png',
            'assets/img/book/eng-grammer/grammer-3.png',
            'assets/img/book/eng-grammer/grammer-4.png',
            'assets/img/book/eng-grammer/grammer-5.png',
            'assets/img/book/eng-grammer/grammer-6.png',
            'assets/img/book/eng-grammer/grammer-7.png',
            'assets/img/book/eng-grammer/grammer-8.png',
          ];
        @endphp

        @forelse($englishSubjects ?? [] as $eIndex => $eSub)
          @php
            $thumb = null;

            // 1. FIRST PRIORITY: Product's cover_image
            // When an admin adds a product under this subcategory/class, use that product's cover_image
            if (!empty($eSub->products) && $eSub->products->count() > 0) {
              $coverProd = $eSub->products->first(function($p) {
                return !empty($p->cover_image);
              });
              if ($coverProd && !empty($coverProd->cover_image)) {
                $thumb = $coverProd->cover_image;
              }
            }

            // 2. Check Subcategory image
            if (!$thumb && !empty($eSub->image)) {
              $thumb = $eSub->image;
            }

            // 3. Fallback: Keyword matching on subcategory name
            if (!$thumb) {
              $subLower = mb_strtolower($eSub->subcategory_name);
              foreach($subjectIcons as $key => $iconPath) {
                if (mb_stripos($subLower, $key) !== false) {
                  $thumb = $iconPath;
                  break;
                }
              }
            }

            // 4. Distinct rotating fallback
            if (!$thumb) {
              $thumb = $engFallbacks[$eIndex % count($engFallbacks)];
            }
          @endphp
          <div class="col-xl-2 col-md-4 col-sm-6 col-12">
            <div class="categorie-style2 wow animate__fadeInUp" data-wow-delay="{{ 0.10 + ($eIndex * 0.05) }}s">
              <div class="categorie-img mb-3">
                <a href="{{ route('front.product.index', ['subcategory' => $eSub->id]) }}">
                  <img src="{{ asset($thumb) }}" alt="{{ $eSub->subcategory_name }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/book/eng-workbook.png') }}';">
                </a>
              </div>
              <h2 class="product-title">
                <a href="{{ route('front.product.index', ['subcategory' => $eSub->id]) }}">{{ $eSub->subcategory_name }}</a>
              </h2>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted py-4">No categories currently listed.</div>
        @endforelse
      </div>
    </div>
  </section>

  <!--==============================
    Brand Story & Best Seller Spotlight
  ==============================-->
  <section class="selling-layout1 space" data-bg-src="{{ asset('assets/img/bg/selling-bg.jpg') }}">
    <div class="container">
      <div class="row g-4 gx-40 align-items-center">
        <div class="col-xl-4">
          <div class="selling-content">
            <h2 class="selling-title wow animate__fadeInUp" data-wow-delay="0.20s"><span>SmartNotes Publication</span> - Your Trusted Book Publisher</h2>
            <h4 class="author-name wow animate__fadeInUp" data-wow-delay="0.30s">Your next great read,<br>handpicked by us</h4>
            <span class="published wow animate__fadeInUp" data-wow-delay="0.40s">1000+ Published Books</span>
            <p class="selling-text wow animate__fadeInUp" data-wow-delay="0.50s">
              <strong>Smart Notes Publication</strong> is an innovative ed-tech startup and <strong>educational publishing house</strong> dedicated to crafting premier school solutions and early childhood literature. In perfect alignment with the <strong>National Education Policy (NEP) 2020</strong> and <strong>NCF 2023</strong>, we design curriculum resources blending foundational learning with future-ready pedagogy.
            </p>
            <a class="vs-btn wow animate__flipInX" data-wow-delay="0.60s" href="{{ url('about') }}">Read More</a>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="selling-img-tag wow animate__fadeInUp" data-wow-delay="0.30s">
            <div class="wow animate__fadeInDownBig" data-wow-delay="0.30s">
              <div class="tag" data-wow-delay="0.30s">
                <img src="{{ asset('assets/img/selling/selling-icon.png') }}" alt="selling icon">
                <h4 class="tag-title">No.1 Best Seller Of The Month</h4>
              </div>
            </div>
            @if(isset($featuredBook) && $featuredBook)
              <a href="{{ route('front.product.show', $featuredBook->id) }}">
                <img src="{{ !empty($featuredBook->cover_image) ? asset($featuredBook->cover_image) : asset('assets/img/selling/selling-img.png') }}" class="w-100" alt="{{ $featuredBook->product_name ?? 'Featured Book' }}" style="max-height: 480px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ asset('assets/img/selling/selling-img.png') }}';">
              </a>
            @else
              <img src="{{ asset('assets/img/selling/selling-img.png') }}" class="w-100" alt="selling images">
            @endif
          </div>
        </div>
        <div class="col-xl-4">
          <div class="selling-books">
            @if(isset($sideBooks) && $sideBooks->count() > 0)
              @foreach($sideBooks as $sIdx => $sBook)
                <div class="book-item wow animate__fadeInUp" data-wow-delay="{{ 0.30 + ($sIdx * 0.10) }}s">
                  <a href="{{ route('front.product.show', $sBook->id) }}" title="{{ $sBook->product_name }}">
                    <img src="{{ !empty($sBook->cover_image) ? asset($sBook->cover_image) : asset('assets/img/selling/book-img-' . ($sIdx + 1) . '.png') }}" alt="{{ $sBook->product_name ?? 'Book' }}" style="height: 110px; width: 80px; object-fit: contain; background: #fff; padding: 4px; border-radius: 4px;" onerror="this.onerror=null;this.src='{{ asset('assets/img/selling/book-img-1.png') }}';">
                  </a>
                </div>
              @endforeach
            @else
              <div class="book-item"><img src="{{ asset('assets/img/selling/book-img-1.png') }}" alt="book image"></div>
              <div class="book-item"><img src="{{ asset('assets/img/selling/book-img-2.png') }}" alt="book image"></div>
              <div class="book-item"><img src="{{ asset('assets/img/selling/book-img-3.png') }}" alt="book image"></div>
              <div class="book-item"><img src="{{ asset('assets/img/selling/book-img-4.png') }}" alt="book image"></div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--==============================
    Top Categories - Gujarati Version (Dynamic)
  ==============================-->
  <section class="categories-layout2 category-book-home guj-category-home space-top">
    <div class="container space-bottom position-relative">
      <div class="title-area2 animation-style1 title-anime">
        <h2 class="sec-title title-anime__title">Top Categories - Gujarati Version</h2>
        <a class="vs-btn wow animate__flipInX" data-wow-delay="0.70s" href="{{ route('front.product.index', ['medium' => 'Gujarati']) }}">View More</a>
      </div>
      <div class="row g-4">
        @php
          $gujSubjectIcons = [
            // Pre-Primary
            'playgroup'           => 'assets/img/book/guj/rhymes.png',
            'pg'                  => 'assets/img/book/guj/rhymes.png',
            'બાળગીત'              => 'assets/img/book/guj/rhymes.png',
            'જોડકણાં'             => 'assets/img/book/guj/rhymes.png',
            'nursery'             => 'assets/img/book/guj/art-craft-book.png',
            'નર્સરી'              => 'assets/img/book/guj/art-craft-book.png',
            'junior kg'           => 'assets/img/book/guj/hindi-two.png',
            'jr kg'               => 'assets/img/book/guj/hindi-two.png',
            'jr. kg'              => 'assets/img/book/guj/hindi-two.png',
            'lkg'                 => 'assets/img/book/guj/hindi-two.png',
            'જુનિયર'              => 'assets/img/book/guj/hindi-two.png',
            'senior kg'           => 'assets/img/book/guj/maths-two.png',
            'sr kg'               => 'assets/img/book/guj/maths-two.png',
            'sr. kg'              => 'assets/img/book/guj/maths-two.png',
            'ukg'                 => 'assets/img/book/guj/maths-two.png',
            'સિનિયર'              => 'assets/img/book/guj/maths-two.png',

            // Standards / Classes (both Gujarati digits & English numerals)
            'ધોરણ ૧'              => 'assets/img/book/guj/english-one.png',
            'ધોરણ 1'              => 'assets/img/book/guj/english-one.png',
            'standard 1'          => 'assets/img/book/guj/english-one.png',
            'std 1'               => 'assets/img/book/guj/english-one.png',
            'std. 1'              => 'assets/img/book/guj/english-one.png',
            'class 1'             => 'assets/img/book/guj/english-one.png',

            'ધોરણ ૨'              => 'assets/img/book/guj/kuhu.png',
            'ધોરણ 2'              => 'assets/img/book/guj/kuhu.png',
            'standard 2'          => 'assets/img/book/guj/kuhu.png',
            'std 2'               => 'assets/img/book/guj/kuhu.png',
            'std. 2'              => 'assets/img/book/guj/kuhu.png',
            'class 2'             => 'assets/img/book/guj/kuhu.png',

            'ધોરણ ૩'              => 'assets/img/book/guj/kalshor.png',
            'ધોરણ 3'              => 'assets/img/book/guj/kalshor.png',
            'standard 3'          => 'assets/img/book/guj/kalshor.png',
            'std 3'               => 'assets/img/book/guj/kalshor.png',
            'std. 3'              => 'assets/img/book/guj/kalshor.png',
            'class 3'             => 'assets/img/book/guj/kalshor.png',

            'ધોરણ ૪'              => 'assets/img/book/guj-four.png',
            'ધોરણ 4'              => 'assets/img/book/guj-four.png',
            'standard 4'          => 'assets/img/book/guj-four.png',
            'std 4'               => 'assets/img/book/guj-four.png',
            'std. 4'              => 'assets/img/book/guj-four.png',
            'class 4'             => 'assets/img/book/guj-four.png',

            'ધોરણ ૫'              => 'assets/img/book/guj/english-grammer-five.png',
            'ધોરણ 5'              => 'assets/img/book/guj/english-grammer-five.png',
            'standard 5'          => 'assets/img/book/guj/english-grammer-five.png',
            'std 5'               => 'assets/img/book/guj/english-grammer-five.png',
            'std. 5'              => 'assets/img/book/guj/english-grammer-five.png',
            'class 5'             => 'assets/img/book/guj/english-grammer-five.png',

            'ધોરણ ૬'              => 'assets/img/book/guj/gk-six.png',
            'ધોરણ 6'              => 'assets/img/book/guj/gk-six.png',
            'standard 6'          => 'assets/img/book/guj/gk-six.png',
            'std 6'               => 'assets/img/book/guj/gk-six.png',
            'std. 6'              => 'assets/img/book/guj/gk-six.png',
            'class 6'             => 'assets/img/book/guj/gk-six.png',

            'ધોરણ ૭'              => 'assets/img/book/guj/kekarav.png',
            'ધોરણ 7'              => 'assets/img/book/guj/kekarav.png',
            'standard 7'          => 'assets/img/book/guj/kekarav.png',
            'std 7'               => 'assets/img/book/guj/kekarav.png',
            'std. 7'              => 'assets/img/book/guj/kekarav.png',
            'class 7'             => 'assets/img/book/guj/kekarav.png',

            'ધોરણ ૮'              => 'assets/img/book/guj/computer-book.png',
            'ધોરણ 8'              => 'assets/img/book/guj/computer-book.png',
            'standard 8'          => 'assets/img/book/guj/computer-book.png',
            'std 8'               => 'assets/img/book/guj/computer-book.png',
            'std. 8'              => 'assets/img/book/guj/computer-book.png',
            'class 8'             => 'assets/img/book/guj/computer-book.png',

            // Subjects
            'computer'            => 'assets/img/book/guj/computer-four.png',
            'english'             => 'assets/img/book/guj/english-grammer-five.png',
            'અંગ્રેજી'            => 'assets/img/book/guj/english-grammer-five.png',
            'gujarati'            => 'assets/img/book/guj/guj-book.png',
            'ગુજરાતી'             => 'assets/img/book/guj/guj-book.png',
            'general knowledge'   => 'assets/img/book/guj/gk-book.png',
            'gk'                  => 'assets/img/book/guj/gk-six.png',
            'g.k.'                => 'assets/img/book/guj/gk-six.png',
            'સામાન્ય જ્ઞાન'       => 'assets/img/book/guj/gk-book.png',
            'art'                 => 'assets/img/book/guj/art-craft-eight.png',
            'ચિત્ર'               => 'assets/img/book/guj/art-craft-eight.png',
            'drawing'             => 'assets/img/book/guj/art-craft-eight.png',
            'rhymes'              => 'assets/img/book/guj/rhymes.png',
            'hindi'               => 'assets/img/book/guj/hindi-book.png',
            'હિન્દી'              => 'assets/img/book/guj/hindi-two.png',
            'maths'               => 'assets/img/book/guj/maths-two.png',
            'ગણિત'                => 'assets/img/book/guj/maths-two.png',
          ];

          $gujFallbacks = [
            'assets/img/book/guj/rhymes.png',
            'assets/img/book/guj/art-craft-book.png',
            'assets/img/book/guj/hindi-two.png',
            'assets/img/book/guj/maths-two.png',
            'assets/img/book/guj/english-one.png',
            'assets/img/book/guj/kuhu.png',
            'assets/img/book/guj/kalshor.png',
            'assets/img/book/guj-four.png',
            'assets/img/book/guj/english-grammer-five.png',
            'assets/img/book/guj/gk-six.png',
            'assets/img/book/guj/kekarav.png',
            'assets/img/book/guj/computer-book.png',
          ];
        @endphp

        @forelse($gujaratiSubjects ?? [] as $gIndex => $gSub)
          @php
            $gThumb = null;

            // 1. FIRST PRIORITY: Product's cover_image
            // When an admin adds a product under this subcategory/class, use that product's cover_image
            if (!empty($gSub->products) && $gSub->products->count() > 0) {
              $gCoverProd = $gSub->products->first(function($p) {
                return !empty($p->cover_image);
              });
              if ($gCoverProd && !empty($gCoverProd->cover_image)) {
                $gThumb = $gCoverProd->cover_image;
              }
            }

            // 2. Check Subcategory image
            if (!$gThumb && !empty($gSub->image)) {
              $gThumb = $gSub->image;
            }

            // 3. Fallback: Keyword matching on subcategory name
            if (!$gThumb) {
              $gSubLower = mb_strtolower($gSub->subcategory_name);
              foreach($gujSubjectIcons as $gKey => $gIconPath) {
                if (mb_stripos($gSubLower, $gKey) !== false) {
                  $gThumb = $gIconPath;
                  break;
                }
              }
            }

            // 4. Distinct rotating fallback
            if (!$gThumb) {
              $gThumb = $gujFallbacks[$gIndex % count($gujFallbacks)];
            }
          @endphp
          <div class="col-xl-2 col-md-4 col-sm-6 col-12">
            <div class="categorie-style2 cat_color wow animate__fadeInUp" data-wow-delay="{{ 0.10 + ($gIndex * 0.05) }}s">
              <div class="categorie-img mb-3">
                <a href="{{ route('front.product.index', ['subcategory' => $gSub->id]) }}">
                  <img src="{{ asset($gThumb) }}" alt="{{ $gSub->subcategory_name }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/book/guj-four.png') }}';">
                </a>
              </div>
              <h2 class="product-title">
                <a href="{{ route('front.product.index', ['subcategory' => $gSub->id]) }}">{{ $gSub->subcategory_name }}</a>
              </h2>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted py-4">No Gujarati categories currently listed.</div>
        @endforelse
      </div>
    </div>
  </section>

  <!--==============================
    Best Selling SERIES Books Carousel (Dynamic from DB)
  ==============================-->
  <section class="books-layout1 space" data-bg-src="{{ asset('assets/img/bg/section-bg2.jpg') }}">
    <div class="container-fluid">
      <div class="title-area text-center animation-style1 title-anime">
        <h2 class="sec-title title-anime__title">Best Selling SERIES Books</h2>
      </div>
      <div class="row vs-carousel book-carousel g-4" data-slide-show="6" data-xl-slide-show="5" data-ml-slide-show="4"
        data-lg-slide-show="4" data-md-slide-show="3" data-sm-slide-show="2" data-autoplay="true">
        @forelse($seriesBooks ?? [] as $bIndex => $bBook)
          <div class="col-xl-3 col-md-4 col-sm-6">
            <div class="product-style1 wow animate__fadeInUp" data-wow-delay="{{ 0.20 + ($bIndex * 0.10) }}s">
              <div class="product-img">
                @php
                  $seriesFallbacks = [
                    'assets/img/book/pg/pg-1.png',
                    'assets/img/book/pg/pg-2.png',
                    'assets/img/book/jr-kg-eng.png',
                    'assets/img/book/rhymes-sr-kg.png',
                    'assets/img/book/eng-workbook.png',
                    'assets/img/book/guj-four.png',
                    'assets/img/book/maths-four.png',
                    'assets/img/book/computer-four.png',
                    'assets/img/book/evs-second.png',
                    'assets/img/book/science-seven.png',
                  ];
                  $sBookImg = !empty($bBook->cover_image)
                      ? $bBook->cover_image
                      : $seriesFallbacks[$bIndex % count($seriesFallbacks)];
                @endphp
                <a href="{{ route('front.product.show', $bBook->id) }}">
                  <img src="{{ asset($sBookImg) }}" alt="{{ $bBook->product_name }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/book/pg-6.png') }}';">
                </a>
                {{-- Wishlist & Cart commented out as requested --}}
                {{--
                <div class="product-btns">
                  <a href="{{ url('wishlist') }}" class="icon-btn wishlist" title="Wishlist">
                    <i class="far fa-heart"></i>
                  </a>
                  <a href="{{ route('front.product.show', $bBook->id) }}" class="icon-btn cart" title="View & Order">
                    <i class="fa-solid fa-basket-shopping"></i>
                  </a>
                </div>
                --}}
              </div>
              <div class="product-content">
                <div class="product-rating">
                  <span class="star"><i class="fas fa-star"></i> (4.8)</span>
                  <ul class="price-list">
                    @if($bBook->mrp_price > $bBook->selling_price)
                      <li><del>₹{{ number_format($bBook->mrp_price, 0) }}/{{ $bBook->unit ?? 'pcs' }}</del></li>
                    @endif
                    <li>₹{{ number_format($bBook->selling_price, 0) }}/{{ $bBook->unit ?? 'pcs' }}</li>
                  </ul>
                </div>
                <span class="product-author"><strong>By:</strong> {{ $bBook->author_publisher ?? 'SmartNotes Publication' }}</span>
                <span class="product-author"><strong>Stream:</strong> {{ $bBook->medium ?? ($bBook->category->category_name ?? 'English Medium') }}</span>
                <h2 class="product-title"><a href="{{ route('front.product.show', $bBook->id) }}">{{ $bBook->product_name }}</a></h2>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted py-4">No series books listed.</div>
        @endforelse
      </div>
      <div class="arraw-area mt-40">
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
  </section>

  <!--==============================
    Our Services & Academic Solutions (Dynamic from DB)
  ==============================-->
  @if(isset($services) && $services->count() > 0)
  <section class="space bg-smoke" style="background-color: #f8f9fa;">
    <div class="container">
      <div class="title-area text-center animation-style1 title-anime">
        <span class="sec-subtitle left-shape justify-content-center title-anime__title">What We Offer</span>
        <h2 class="sec-title title-anime__title">Our Comprehensive Services &amp; Solutions</h2>
        <p class="sec-text" style="max-width: 680px; margin: 0 auto 35px;">Empowering schools, educators, and young minds with custom curriculum publishing, digital interactive tools, and reliable institutional distribution.</p>
      </div>
      <div class="row g-4 justify-content-center">
        @foreach($services as $sIndex => $service)
        <div class="col-xl-3 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="{{ 0.20 + ($sIndex * 0.10) }}s">
          <div class="service-card text-center" style="background: #ffffff; border-radius: 14px; padding: 32px 24px; box-shadow: 0 5px 20px rgba(0,0,0,0.04); height: 100%; display: flex; flex-direction: column; justify-content: space-between; border: 1px solid #f0f0f4;">
            <div>
              <div class="service-icon mb-3" style="width: 70px; height: 70px; margin: 0 auto 18px; border-radius: 50%; background: #eef2ff; color: #ff5722; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                <i class="{{ $service->icon ?? 'fa-solid fa-graduation-cap' }}"></i>
              </div>
              @if($service->badge)
                <span class="badge bg-primary text-white mb-2" style="font-size: 11px; padding: 4px 10px; border-radius: 20px;">{{ $service->badge }}</span>
              @endif
              <h3 style="font-size: 19px; font-weight: 700; margin-bottom: 12px; color: #1e293b; line-height: 1.35;">
                <a href="{{ route('front.service') }}#service-{{ $service->id }}" style="color: inherit; text-decoration: none;">{{ $service->title }}</a>
              </h3>
              <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 16px;">
                {{ Str::limit($service->lead ?? strip_tags($service->content), 110) }}
              </p>
              @if(!empty($service->features_list) && count($service->features_list) > 0)
              <ul class="text-start list-unstyled mb-4" style="font-size: 13px; color: #475569; padding: 0 5px;">
                @foreach(array_slice($service->features_list, 0, 2) as $feat)
                <li style="margin-bottom: 6px; display: flex; align-items: flex-start; gap: 8px;">
                  <i class="fa-solid fa-circle-check text-success mt-1" style="font-size: 12px;"></i>
                  <span>{{ $feat }}</span>
                </li>
                @endforeach
              </ul>
              @endif
            </div>
            <div class="mt-auto pt-2">
              <a href="{{ route('front.service') }}#service-{{ $service->id }}" class="vs-btn style4" style="padding: 10px 22px; font-size: 13px; border-radius: 30px;">Learn More <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="text-center mt-5">
        <a href="{{ route('front.service') }}" class="vs-btn">Explore All Services &amp; Solutions <i class="fa-solid fa-arrow-right ms-2"></i></a>
      </div>
    </div>
  </section>
  @endif

  <!--==============================
    Testimonial Area (Dynamic from DB)
  ==============================-->
  <section class="vs-testi__layout1 space">
    <div class="container">
      <div class="row g-5">
        <div class="col-xl-5 col-lg-4">
          <div class="banner-img">
            <img src="{{ asset('assets/img/others/banner1.jpg') }}" alt="banner image">
            <div class="banner-content">
              <a class="vs-btn" href="{{ url('contact') }}">Contact Us</a>
            </div>
          </div>
        </div>
        <div class="col-xl-7 col-lg-8">
          <div class="vs-testi__inner">
            <div class="title-area text-left wow animate__fadeInUp title-anime animation-style5" data-wow-delay="0.25s">
              <span class="sec-subtitle left-shape justify-content-center title-anime__title">Testimonials</span>
              <h2 class="sec-title title-anime__title">What Our Clients Say &amp; Review</h2>
              <p class="sec-text">Trusted by Educators. Valued by Schools. This publication delivers vibrant visuals, practical exercises, and invaluable teacher support materials.</p>
            </div>
            <div class="vs-testi__items wow animate__fadeInUp" data-wow-delay="0.35s">
              <div class="vs-carousel testi-slider" data-autoplay="true" data-fade="true">
                @forelse($testimonials ?? [] as $t)
                <div class="vs-testi__style1">
                  <span class="vs-testi__icon"><img src="{{ asset('assets/img/icons/quote-icon.svg') }}" alt="icon"></span>
                  <div class="vs-testi__top">
                    <div class="vs-testi__image">
                      @if($t->image && file_exists(public_path($t->image)))
                        <img class="img1" src="{{ asset($t->image) }}" alt="{{ $t->name }}">
                      @else
                        <img class="img1" src="{{ asset('assets/img/testimonial/testi-1-1.jpg') }}" alt="{{ $t->name }}">
                      @endif
                    </div>
                    <div class="vs-testi__author">
                      <div class="star-rating">
                        @for($r = 1; $r <= 5; $r++)
                          @if($r <= ($t->rating ?? 5))
                            <i class="fa-solid fa-star"></i>
                          @else
                            <i class="fa-regular fa-star"></i>
                          @endif
                        @endfor
                      </div>
                      <h3 class="vs-testi__title">{{ $t->name }}</h3>
                      <span class="vs-testi__desi">{{ $t->designation ? $t->designation . ($t->school_name ? ' - ' . $t->school_name : '') : ($t->school_name ?? 'Educator') }}</span>
                    </div>
                  </div>
                  <div class="vs-testi__content">
                    <p class="vs-testi__text">
                      “ {{ $t->review }} ”
                    </p>
                  </div>
                </div>
                @empty
                <div class="vs-testi__style1">
                  <span class="vs-testi__icon"><img src="{{ asset('assets/img/icons/quote-icon.svg') }}" alt="icon"></span>
                  <div class="vs-testi__top">
                    <div class="vs-testi__image">
                      <img class="img1" src="{{ asset('assets/img/testimonial/testi-1-1.jpg') }}" alt="testi">
                    </div>
                    <div class="vs-testi__author">
                      <div class="star-rating">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                      </div>
                      <h3 class="vs-testi__title">Principal, Pre-Primary School</h3>
                      <span class="vs-testi__desi">Surat, Gujarat</span>
                    </div>
                  </div>
                  <div class="vs-testi__content">
                    <p class="vs-testi__text">
                      “ Smart Notes Publication books provide structured worksheets and vibrant illustrations that our teachers love using daily! ”
                    </p>
                  </div>
                </div>
                @endforelse
              </div>
            </div>
            <div class="custom-arraw wow animate__fadeInUp" data-wow-delay="0.45s">
              <div class="icon-arraw slick-prev" data-slick-prev=".testi-slider">
                <button class="icon-btn">
                  <i class="fa-regular fa-arrow-right"></i>
                </button>
              </div>
              <div class="icon-arraw slick-next" data-slick-next=".testi-slider">
                <button class="icon-btn">
                  <i class="fa-regular fa-arrow-left"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--==============================
    Feature Highlights Area
  ==============================-->
  <div class="feature-layout1 space-top space-bottom">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4 col-md-6 text-center wow animate__fadeInUp" data-wow-delay="0.20s">
          <div class="feature-style1">
            <span class="feature-icon">
              <img class="icon-1" src="{{ asset('assets/img/feature/feature-icon-1-1.png') }}" alt="feature icon">
              <img class="icon-2" src="{{ asset('assets/img/feature/feature-icon-2-1.png') }}" alt="feature icon">
            </span>
            <div class="feature-body">
              <h2 class="feature-title"><a href="{{ route('front.product.index') }}">Free Delivery</a></h2>
              <p class="feature-text">Fast, reliable book delivery across Gujarat & India.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 text-center wow animate__fadeInUp" data-wow-delay="0.45s">
          <div class="feature-style1">
            <span class="feature-icon">
              <img class="icon-1" src="{{ asset('assets/img/feature/feature-icon-1-3.png') }}" alt="feature icon">
              <img class="icon-2" src="{{ asset('assets/img/feature/feature-icon-2-3.png') }}" alt="feature icon">
            </span>
            <div class="feature-body">
              <h2 class="feature-title"><a href="{{ url('contact') }}">Support 24/7</a></h2>
              <p class="feature-text">Dedicated customer care & school order desk.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12 text-center wow animate__fadeInUp" data-wow-delay="0.65s">
          <div class="feature-style1">
            <span class="feature-icon">
              <img class="icon-1" src="{{ asset('assets/img/feature/feature-icon-1-2.png') }}" alt="feature icon">
              <img class="icon-2" src="{{ asset('assets/img/feature/feature-icon-2-2.png') }}" alt="feature icon">
            </span>
            <div class="feature-body">
              <h2 class="feature-title"><a href="{{ route('front.product.index') }}">Secure Orders</a></h2>
              <p class="feature-text">Instant online inquiry & hassle-free CRM order booking.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page_script')
@endsection
