@extends('layouts.front')

@section('title', 'Gallery - SMART NOTES PUBLICATION PVT. LTD.')

@section('content')
<main>

<!--==============================
    Breadcrumb
============================== -->
<div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg-4.png') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Gallery</h1>
            <div class="breadcumb-menu-wrap">
                <div class="breadcumb-menu">
                    <span><a href="{{ url('/') }}">Home</a></span>
                    <span>Gallery</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--==============================
    Gallery Area
==============================-->
  <section class="vs-blog-wrapper space-top space-extra-bottom">
    <div class="container">
      
      <div class="row g-4">
        @forelse($galleries as $gIndex => $gal)
        <div class="col-xl-4 col-lg-6 col-md-6 wow animate__fadeInUp" data-wow-delay="{{ 0.20 + (($gIndex % 3) * 0.10) }}s">
          <div class="vs-blog blog-style1">
            <div class="blog-img">
              <a href="{{ asset($gal->image) }}" class="popup-image">
                <img class="blog-img__img" src="{{ asset($gal->image) }}" alt="{{ $gal->title }}" style="width: 100%; height: 260px; object-fit: cover; border-radius: 8px;">
              </a>
              <a class="blog-date popup-image" href="{{ asset($gal->image) }}" aria-label="Enlarge gallery image">
                <span class="day"><strong><i class="fa-solid fa-magnifying-glass-plus" aria-hidden="true"></i></strong></span>
              </a>
            </div>
            @if($gal->title)
            <div style="padding: 12px 6px; font-weight: 600; font-size: 15px; color: #1f2937;">
                {{ $gal->title }}
            </div>
            @endif
          </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
            <p>No gallery images added yet.</p>
        </div>
        @endforelse
      </div>

    </div>
  </section>

</main>
@endsection
