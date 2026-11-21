@extends('layouts.front')

@section('title', 'About Us - SMART NOTES PUBLICATION PVT. LTD.')

@section('content')
<!--==============================
    Breadcrumb
============================== -->
<div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg-4.png') }}">
  <div class="container z-index-common">
    <div class="breadcumb-content">
      <h1 class="breadcumb-title">About Us</h1>
      <div class="breadcumb-menu-wrap">
        <div class="breadcumb-menu">
          <span><a href="{{ url('/') }}">Home</a></span>
          <span>About Us</span>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- About Area  -->
<section class="about-layout1 space-top">
  <div class="container space-bottom">
    <div class="row g-5 justify-content-center align-items-center">
      <div class="col-lg-4">
        <div class="about-img wow animate__fadeInUp" data-wow-delay="0.45s">
          <img src="{{ asset('assets/img/about/about-us-img1.png') }}" alt="about image">
        </div>
      </div>
      <div class="col-lg-8">
        <div class="about-content">
          <div class="wow animate__fadeInUp" data-wow-delay="0.35s">
            <div class="title-area animation-style1 title-anime">
              <h2 class="sec-title text-title title-anime__title">SmartNotes Publications — Defining Success for Generations.</h2>
            </div>
            <p class="about-text wow animate__fadeInUp mt-3" data-wow-delay="0.30s">
              <strong>Smart Notes Publication</strong> is a dedicated educational publishing organization committed to <strong>empowering students, supporting educators,
                and making quality education</strong> accessible to every learner.
            </p>
            <p class="about-text wow animate__fadeInUp mt-3" data-wow-delay="0.30s">
              With a <strong>passion for knowledge</strong> and a commitment to <strong>academic excellence</strong>, we specialize in developing <strong>high-quality educational books,
                study materials, reference guides, and examination-oriented resources</strong> that simplify learning and enhance academic performance.
            </p>

          </div>
          <div class="list-style1 wow animate__fadeInUp" data-wow-delay="0.50s">
            <h6 class="blog-inner-title title-shep about-sub-title">Smart Books. Digital Learning. Brighter Futures</h6>
            <ul class="list-unstyled">
              <li><i class="fa-solid fa-badge-check"></i>QR Code-enabled educational books with digital learning support.</li>
              <li><i class="fa-solid fa-badge-check"></i>Interactive animated videos for better conceptual understanding.</li>
              <li><i class="fa-solid fa-badge-check"></i>Teacher-guided digital lessons and multimedia learning resources.</li>
              <li><i class="fa-solid fa-badge-check"></i>Game-based educational activities for engaging and enjoyable learning.</li>
              <li><i class="fa-solid fa-badge-check"></i>Creative worksheets and activity-based skill development materials.</li>
              <li><i class="fa-solid fa-badge-check"></i>Integrated print and digital learning solutions for modern education.</li>
            </ul>
          </div>
          <div class="about-content wow animate__fadeInUp" data-wow-delay="0.75s">
            <div class="about-box">
              <div class="about-img wow animate__fadeInUp" data-wow-delay="0.55s">
                <img src="{{ asset('assets/img/about/about-img-1-2.png') }}" alt="about image">
              </div>
              <div class="about-inner mb-0 wow animate__fadeInUp" data-wow-delay="0.95s">
                <h6 class="blog-inner-title title-shep about-sub-title mb-2">Building Knowledge, Inspiring Success</h6>
                <p class="about-text mb-10">
                  At Smart Notes Publication, we believe that every student deserves <strong>access to clear, reliable, and effective educational resources.</strong>
                </p>
                <p class="about-text mb-10">
                  Our publications are thoughtfully developed to bridge the gap between <strong>classroom teaching and independent learning.</strong>
                  By combining <strong>academic expertise, simplified explanations, and practical examination strategies, </strong>
                  we aim to make education more <strong>engaging, accessible, and result-oriented.</strong>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- About Area End -->

<!-- Video Area Start -->
<div class="video-style1" data-bg-src="{{ asset('assets/img/bg/video-bg1.png') }}">
  <div class="container">
    <div class="title-area text-center animation-style1 title-anime">
      <h2 class="sec-title text-white title-anime__title">Smart Notes Publication – Simplifying Learning, Empowering Minds, Inspiring Futures.</h2>
    </div>
    <div class="video-btn text-center">
      <a href="https://www.youtube.com/watch?v=moYayPRgaY0" class="play-btn popup-video">
        <i class="fas fa-play"></i>
      </a>
    </div>
  </div>
</div>
<!-- Video Area End -->

<!-- Counter Area Start -->
<section class="counter-layout1 bg-theme">
  <div class="container">
    <div class="row g-5 align-items-center">
      <div class="counter-style1">
        <div class="media-inner wow animate__fadeInUp" data-wow-delay="0.35s">
          <div class="media-counter text-center">
            <div class="media-count">
              <h2 class="media-title counter-number" data-count="{{ max(100, $totalBooks ?? 250) }}">00</h2>
              <span class="count-icon">+</span>
            </div>
            <p class="media-text">New Series Book Collection</p>
          </div>
          <span class="counter-line">
            <img class="icon" src="{{ asset('assets/img/shapes/round-ring.svg') }}" alt="line shape">
          </span>
        </div>
        <div class="media-inner wow animate__fadeInUp" data-wow-delay="0.35s">
          <div class="media-counter text-center">
            <div class="media-count">
              <h2 class="media-title counter-number" data-count="10">00</h2>
              <span class="count-icon">+</span>
            </div>
            <p class="media-text">Award Wins</p>
          </div>
          <span class="counter-line">
            <img class="icon" src="{{ asset('assets/img/shapes/round-ring.svg') }}" alt="line shape">
          </span>
        </div>
        <div class="media-inner wow animate__fadeInUp" data-wow-delay="0.35s">
          <div class="media-counter text-center">
            <div class="media-count">
              <h2 class="media-title counter-number" data-count="{{ max(15, ($totalTeam ?? 0) * 8) }}">00</h2>
              <span class="count-icon">+</span>
            </div>
            <p class="media-text">Team Members &amp; Experts</p>
          </div>
          <span class="counter-line">
            <img class="icon" src="{{ asset('assets/img/shapes/round-ring.svg') }}" alt="line shape">
          </span>
        </div>
        <div class="media-inner wow animate__fadeInUp" data-wow-delay="0.35s">
          <div class="media-counter text-center">
            <div class="media-count">
              <h2 class="media-title counter-number" data-count="10">00</h2>
              <span class="count-icon">k+</span>
            </div>
            <p class="media-text">Trusted Clients &amp; Schools</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Facts Area End -->

<section class="about-layout1 space-top">
  <div class="container space-bottom">
    <div class="row g-5 justify-content-center align-items-center">
      <div class="col-lg-12">
        <div class="about-content">
          <div class="about-content wow animate__fadeInUp" data-wow-delay="0.75s">
            <div class="about-box">
              <h6 class="blog-inner-title title-shep about-sub-title mb-2">
                With dedication, innovation, and a passion for education, we create learning resources that inspire success.
              </h6>
              <div class="about-inner mb-0 wow animate__fadeInUp" data-wow-delay="0.95s">
                <p class="about-text wow animate__fadeInUp mt-3" data-wow-delay="0.30s">
                  At Smart Notes Publication, we believe that education is the <strong>foundation of a brighter future</strong>.
                  Our mission is to transform complex concepts into <strong>simple, structured, and student-friendly learning experiences, </strong>
                  helping students build <strong>confidence</strong>, <strong>strengthen</strong> their understanding, and achieve their <strong>academic goals.</strong>
                </p>
                <p class="about-text mb-10">
                  We continuously strive to improve the <strong>quality of our educational content </strong>while adapting to the evolving needs of <strong>students, teachers, and
                    educational institutions.</strong>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Dynamic Our Team Preview Section -->
@if(isset($team) && $team->count() > 0)
<section class="space-top space-extra-bottom" style="background: #fbfbfd;">
  <div class="container">
    <div class="title-area text-center animation-style1 title-anime">
      <span class="sec-subtitle left-shape justify-content-center title-anime__title">Our Team</span>
      <h2 class="sec-title title-anime__title">Dedicated Minds Behind Smart Notes</h2>
      <p class="sec-text" style="max-width: 650px; margin: 0 auto 35px;">Meet our leadership, editorial experts, and educators committed to revolutionizing modern educational publishing.</p>
    </div>
    <div class="row g-4 justify-content-center">
      @foreach($team as $mIndex => $member)
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 wow animate__fadeInUp" data-wow-delay="{{ 0.15 + ($mIndex * 0.10) }}s">
        <div class="feature-style2" style="background: #fff; border-radius: 12px; padding: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; height: 100%;">
          <span class="feature-img" style="display: block; margin-bottom: 15px;">
            @if($member->image && file_exists(public_path($member->image)))
              <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" style="width: 100%; height: 240px; object-fit: cover; border-radius: 8px;">
            @else
              <img src="{{ asset('assets/img/page/' . (($mIndex % 8) + 1) . '.jpg') }}" alt="{{ $member->name }}" style="width: 100%; height: 240px; object-fit: cover; border-radius: 8px;">
            @endif
          </span>
          <h3 class="feature-title" style="font-size: 18px; font-weight: 700; margin-bottom: 5px;">
            <a href="{{ url('team') }}">{{ $member->name }}</a>
          </h3>
          <p class="distributer-designation text-primary mb-0" style="font-size: 14px; font-weight: 600;">{{ $member->designation }}</p>
        </div>
      </div>
      @endforeach
    </div>
    <div class="text-center mt-4">
      <a href="{{ url('team') }}" class="vs-btn">View Full Team &amp; Leadership <i class="fa-solid fa-arrow-right ms-2"></i></a>
    </div>
  </div>
</section>
@endif

<!-- Dynamic Testimonials Section -->
@if(isset($testimonials) && $testimonials->count() > 0)
<section class="vs-testi__layout1 space" style="background: #ffffff;">
  <div class="container">
    <div class="title-area text-center wow animate__fadeInUp title-anime animation-style5" data-wow-delay="0.25s">
      <span class="sec-subtitle left-shape justify-content-center title-anime__title">What People Say</span>
      <h2 class="sec-title title-anime__title">Loved by Teachers, Schools &amp; Students</h2>
      <p class="sec-text" style="max-width: 600px; margin: 0 auto;">Read how our educational books and classroom resources are transforming early childhood learning across institutions.</p>
    </div>
    <div class="row g-4 mt-2 justify-content-center">
      @foreach($testimonials->take(3) as $tIndex => $t)
      <div class="col-lg-4 col-md-6 wow animate__fadeInUp" data-wow-delay="{{ 0.20 + ($tIndex * 0.15) }}s">
        <div class="vs-testi__style1" style="height: 100%; background: #fdfbf7; border: 1px solid #f0eae1; border-radius: 12px; padding: 26px;">
          <div class="vs-testi__top mb-3">
            <div class="vs-testi__image">
              @if($t->image && file_exists(public_path($t->image)))
                <img class="img1" src="{{ asset($t->image) }}" alt="{{ $t->name }}" style="width: 55px; height: 55px; border-radius: 50%; object-fit: cover;">
              @else
                <img class="img1" src="{{ asset('assets/img/testimonial/testi-1-1.jpg') }}" alt="{{ $t->name }}" style="width: 55px; height: 55px; border-radius: 50%; object-fit: cover;">
              @endif
            </div>
            <div class="vs-testi__author ps-3">
              <div class="star-rating mb-1 text-warning">
                @for($r = 1; $r <= 5; $r++)
                  @if($r <= ($t->rating ?? 5))
                    <i class="fa-solid fa-star"></i>
                  @else
                    <i class="fa-regular fa-star"></i>
                  @endif
                @endfor
              </div>
              <h4 class="vs-testi__title" style="font-size: 16px; margin: 0; font-weight: 700;">{{ $t->name }}</h4>
              <span class="vs-testi__desi" style="font-size: 13px; color: #6c757d;">{{ $t->designation ? $t->designation . ($t->school_name ? ' - ' . $t->school_name : '') : ($t->school_name ?? 'Educator') }}</span>
            </div>
          </div>
          <div class="vs-testi__content">
            <p class="vs-testi__text" style="font-size: 14px; line-height: 1.6; color: #495057; margin-bottom: 0;">
              “ {{ $t->review }} ”
            </p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- feature area Start -->
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
            <p class="feature-text">Fast and secure educational book delivery for schools.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 text-center wow animate__fadeInUp" data-wow-delay="0.45s">
        <div class="feature-style1">
          <span class="feature-icon">
            <img class="icon-1" src="{{ asset('assets/img/feature/feature-icon-1-2.png') }}" alt="feature icon">
            <img class="icon-2" src="{{ asset('assets/img/feature/feature-icon-2-2.png') }}" alt="feature icon">
          </span>
          <div class="feature-body">
            <h2 class="feature-title"><a href="{{ route('front.product.index') }}">Secure Payments</a></h2>
            <p class="feature-text">Verified, convenient payment methods for online orders.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 text-center wow animate__fadeInUp" data-wow-delay="0.65s">
        <div class="feature-style1">
          <span class="feature-icon">
            <img class="icon-1" src="{{ asset('assets/img/feature/feature-icon-1-3.png') }}" alt="feature icon">
            <img class="icon-2" src="{{ asset('assets/img/feature/feature-icon-2-3.png') }}" alt="feature icon">
          </span>
          <div class="feature-body">
            <h2 class="feature-title"><a href="{{ url('contact') }}">Support 24/7</a></h2>
            <p class="feature-text">Providing reliable, expert guidance for schools &amp; parents.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- feature area End -->
@endsection

@section('page_script')
@endsection
