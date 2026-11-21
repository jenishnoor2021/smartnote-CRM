@extends('layouts.front')

@section('title', "Chairman's Perspective - SMART NOTES PUBLICATION PVT. LTD.")

@section('content')
<!--==============================
    Breadcrumb
============================== -->
  <div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg-4.png">
    <div class="container z-index-common">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">Chairman's Perspective</h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span>About</span>
            <span>Chairman's Perspective</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
  <!--==============================
    Author Details Start
==============================-->
  <section class="author-details chairman-msg space">
    <div class="container space-bottom position-relative">
      <div class="row align-items-start gx-60 g-4">
        <div class="col-xl-5 col-lg-6 wow animate__fadeInLeft" data-wow-delay="0.50s">
          <div class="author-img">
            @php
              $cImg = !empty($chairman->image) && file_exists(public_path($chairman->image)) ? asset($chairman->image) : asset('assets/img/sanjaysir.jpeg');
              $cName = $chairman->name ?? 'Mr. Sanjaybhai J. Baldaniya';
              $cDesig = $chairman->designation ?? 'Chairman & Managing Director';
              $cPhone = $chairman->phone ?? '(+91)98241-45453';
              $cEmail = $chairman->email ?? 'smartnotespublication@gmail.com';
            @endphp
            <img src="{{ $cImg }}" alt="{{ $cName }}">
          </div>
		  <div class="vs-blog blog-style1">
			<div class="blog-content">
              <div class="blog-meta">
				{{ $cDesig }}
              </div>
              <h2 class="blog-title">
                <a href="#">{{ $cName }}</a>
              </h2>
              <div class="btn-area">
				<h6><u>Phone Number :</u></h6>
                <p><a href="tel:{{ preg_replace('/[^0-9+]/', '', $cPhone) }}">{{ $cPhone }}</a></p>
                @if($cEmail)
                  <p><a href="mailto:{{ $cEmail }}"><i class="fa-solid fa-envelope me-1"></i> {{ $cEmail }}</a></p>
                @endif
				<p>(Smart Notes Publication)</p>
              </div>
            </div>
		  </div>
        </div>
        <div class="col-xl-7 col-lg-6 wow animate__fadeInRight" data-wow-delay="0.45s">
          <div class="author-content">
            <h2 class="author-title">A Vision for Better Education. A Commitment to Every Child.</h2>
            <p class="text">
				At <strong>SmartNotes Publication,</strong> we believe that education is not simply about completing a syllabus—it is about <strong>building strong foundations, 
				developing skills, inspiring curiosity, and preparing children for a brighter future.</strong>
			</p>
            <p class="text">
				With a clear vision and a deep commitment to quality education, we strive to create learning resources that make education <strong>simple, engaging, meaningful, 
				and accessible</strong> for every learner.
			</p>
			
			<p class="text txt-msg">
				“{{ !empty($chairman->quote) ? $chairman->quote : 'Education is the foundation upon which every successful future is built. At SmartNotes Publication, our commitment is to nurture young minds with knowledge, creativity, confidence, and values—because when we empower children to learn, we empower them to shape a better tomorrow.' }}”
			</p>

            @if(!empty($chairman->bio))
              <div class="well well-sm my-3 p-3 bg-light rounded border-start border-4 border-primary" style="font-size: 15px; line-height: 1.8; color: #374151;">
                {!! nl2br(e($chairman->bio)) !!}
              </div>
            @endif
			
			<h6>Our Legacy. Our Future.</h6>
			<p class="text">
				At SmartNotes Publication, we continuously work toward creating educational content that supports <strong>students, teachers, and schools.</strong>
			</p>
			<p class="text">
				We believe that quality education should be <strong>accessible, understandable, and inspiring</strong> for every child.
			</p>
			
			<h6>Inspired by Purpose. Driven by Excellence.</h6>
			<p class="text">
				Our success is not measured only by the books we publish, but by the <strong>difference those books make in a child's learning journey.</strong>
			</p>
			<blockquote class="vs-quote">
				<p>"A great book does more than teach a lesson; it opens a child's mind to possibilities, builds confidence, and inspires a lifelong love for learning.&nbsp;"</p>
				<!-- <cite>Rodja Heartmann</cite> -->
				<span class="quote-icon"><img src="assets/img/icons/quote-icon.svg" alt="icon"></span>
			</blockquote>
			
			<h6>Our Vision</h6>
			<p class="text">
			To make learning more meaningful, education more engaging, and every child's journey toward knowledge more confident and joyful.
			</p>
			
			<h6>Where Learning Meets Purpose</h6>
			<p class="text">
				Every child learns differently, and our goal is to make learning <strong>simple, engaging, and meaningful</strong> through thoughtfully designed resources that 
				build <strong>concept clarity, skills, creativity, confidence, and a love for learning.</strong>
			</p>
			
          </div>
        </div>
      </div>
      <span class="border-line"></span>
    </div>
  </section>
  <!--==============================
    Author Details End
    ==============================-->
@endsection

@section('page_script')
@endsection
