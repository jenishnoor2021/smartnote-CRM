@extends('layouts.front')

@section('title', 'Our Team - SMART NOTES PUBLICATION PVT. LTD.')

@section('content')
<!--==============================
    Breadcrumb
============================== -->
  <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg-4.png') }}">
    <div class="container z-index-common">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">Team</h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span>Team</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  @php
      $leadership = $team->where('is_leadership', 1);
      $regularTeam = $team->where('is_leadership', 0);
      if ($leadership->count() == 0 && $regularTeam->count() == 0) {
          $regularTeam = $team;
      }
  @endphp

  @if($leadership->count() > 0)
  <section class="books-layout1 team-list space-top space-extra-bottom">
    <div class="container">
      <div class="row g-4">
        <div class="col-xl-12 col-lg-12">
          @foreach($leadership as $leaderIndex => $leader)
          <div class="vendor-item space-bottom">
            <div class="row vendor-style1 style2 wow animate__fadeInUp" data-wow-delay="{{ 0.50 + ($leaderIndex * 0.20) }}s">
                
                @if($leaderIndex % 2 == 0)
                <div class="col-xl-4 col-lg-4 pe-0">
                    <div class="vendor-image wow animate__fadeInRight" data-wow-delay="0.50s">
                        @if($leader->image)
                            <img src="{{ asset($leader->image) }}" alt="{{ $leader->name }}">
                        @else
                            <img src="{{ asset('assets/img/sanjaysir.jpeg') }}" alt="{{ $leader->name }}">
                        @endif
                    </div>
                </div>
              
                <div class="col-xl-8 col-lg-8 ps-0">
                  <div class="vendor-body vendor-body-right wow animate__fadeInLeft" data-wow-delay="0.50s">
                    <div class="vendor-inner">
                        <div>
                            <h6 class="vendor-title"><a href="#">{{ $leader->name }}</a></h6>
                            <div class="designation">
                              {{ $leader->designation }}
                            </div>
                        </div>
                    </div>
                    
                    @if($leader->bio)
                        <div style="font-size: 15px; line-height: 1.7; color: #4b5563;">
                            {!! nl2br(e($leader->bio)) !!}
                        </div>
                    @endif
                    
                    <div class="list-style1 list-bottom-content">
                      <ul class="list-unstyled">
                        @if($leader->phone)
                            <li><i class="fa-solid fa-headset"></i> <a href="tel:{{ $leader->phone }}">{{ $leader->phone }}</a></li>
                        @endif
                        <li><i class="fa-solid fa-book"></i><a href="#">(Smart Notes Publication)</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                @else
                <div class="col-xl-8 col-lg-8 pe-0">
                  <div class="vendor-body vendor-body-left wow animate__fadeInRight" data-wow-delay="0.70s">
                    <div class="vendor-inner">
                        <div>
                            <h6 class="vendor-title"><a href="#">{{ $leader->name }}</a></h6>
                            <div class="designation">
                              {{ $leader->designation }}
                            </div>
                        </div>
                    </div>
                    
                    @if($leader->bio)
                        <div style="font-size: 15px; line-height: 1.7; color: #4b5563;">
                            {!! nl2br(e($leader->bio)) !!}
                        </div>
                    @endif
                    
                    <div class="list-style1 list-bottom-content">
                      <ul class="list-unstyled">
                        @if($leader->phone)
                            <li><i class="fa-solid fa-headset"></i> <a href="tel:{{ $leader->phone }}">{{ $leader->phone }}</a></li>
                        @endif
                        <li><i class="fa-solid fa-book"></i><a href="#">(Smart Notes Publication)</a></li>
                      </ul>
                    </div>
                  </div>
                </div> 
                
                <div class="col-xl-4 col-lg-4 ps-0">
                    <div class="vendor-image wow animate__fadeInLeft" data-wow-delay="0.70s">
                        @if($leader->image)
                            <img src="{{ asset($leader->image) }}" alt="{{ $leader->name }}">
                        @else
                            <img src="{{ asset('assets/img/admin.jpeg') }}" alt="{{ $leader->name }}">
                        @endif
                    </div>
                </div>
                @endif
              
            </div>
          </div>
          @endforeach

          <h3 class="vendor-details-title title-shep">Our Team </h3>
        </div>
      </div>
    </div>
  </section>
  @endif
  
  <!--==============================
  Author Area start
==============================-->
  @if($regularTeam->count() > 0)
  <section class="vs-blog-wrapper space-top space-extra-bottom">
    <div class="container">
      <div class="row g-4">
        @foreach($regularTeam as $mIndex => $member)
        <div class="col-xl-3 col-lg-3 col-md-4 col-6 wow animate__fadeInUp" data-wow-delay="{{ 0.20 + (($mIndex % 4) * 0.10) }}s">
          <div class="feature-style2">
            <span class="feature-img">
              @if($member->image)
                  <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" style="width: 100%; height: 260px; object-fit: cover; border-radius: 8px;">
              @else
                  <img src="{{ asset('assets/img/page/' . (($mIndex % 8) + 1) . '.jpg') }}" alt="{{ $member->name }}" style="width: 100%; height: 260px; object-fit: cover; border-radius: 8px;">
              @endif
            </span>
            <h2 class="feature-title"><a href="#">{{ $member->name }}</a></h2>
            <p class="distributer-designation">{{ $member->designation }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  @include('partial.products')

@endsection
