@extends('layouts.front')

@section('title', 'From The Admin Desk - SMART NOTES PUBLICATION PVT. LTD.')

@section('content')
<!--==============================
    Breadcrumb
============================== -->
  <div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg-4.png">
    <div class="container z-index-common">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">Senior Executive Administrator</h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span>About</span>
            <span>Senior Executive Administrator</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
  <!--==============================
    Author Details Start
==============================-->
  <section class="author-details space">
    <div class="container space-bottom position-relative">
      <div class="row align-items-start gx-60 g-4">
        <div class="col-xl-4 col-lg-6 wow animate__fadeInDown" data-wow-delay="0.70s">
          <div class="author-img">
            @php
              $aImg = !empty($adminDesk->image) && file_exists(public_path($adminDesk->image)) ? asset($adminDesk->image) : asset('assets/img/admin.jpeg');
              $aName = $adminDesk->name ?? 'Ms. Sonali S. Das';
              $aDesig = $adminDesk->designation ?? 'Senior Executive Administrator';
              $aPhone = $adminDesk->phone ?? '(+91) 99798-65666';
              $aEmail = $adminDesk->email ?? 'Sevenhigheducationpvtltd@gmail.com';
            @endphp
            <img src="{{ $aImg }}" alt="{{ $aName }}">
          </div>
		  <div class="vs-blog blog-style1">
			<div class="blog-content">
              <div class="blog-meta">
				{{ $aDesig }}
              </div>
              <h2 class="blog-title">
                <a href="#">{{ $aName }}</a>
              </h2>
              <div class="btn-area">
				<h6><u>Phone Number :</u></h6>
                <p><a href="tel:{{ preg_replace('/[^0-9+]/', '', $aPhone) }}">{{ $aPhone }}</a></p>
                @if($aEmail)
                  <p><a href="mailto:{{ $aEmail }}"><i class="fa-solid fa-envelope me-1"></i> {{ $aEmail }}</a></p>
                @endif
				<p>(Smart Notes Publication)</p>
              </div>
            </div>
		  </div>
        </div>
        <div class="col-xl-8 col-lg-6 wow animate__fadeInUp" data-wow-delay="0.65s">
          <div class="author-content">
            <h2 class="author-title">Meet Our Senior Executive Administrator</h2>
            <h5 class="author-title author-sub-title">Where Every Book Begins with Knowledge, Quality, and Trust</h5>
            <p class="text">
				At <strong>SmartNotes Publication,</strong> , every educational book is more than just printed pages—it is a valuable source of knowledge, inspiration, 
				and academic growth for students, teachers, and future generations.
			</p>
            <p class="text">
				My role as an administrator is to ensure that every stage of our publishing journey is supported by <strong>effective coordination, professional excellence, quality management, and timely execution.</strong>
			</p>
			
			<div class="leadership-section mb-4">
				<h2>My Leadership Philosophy</h2>
				<div class="philosophy">
					<div class="philosophy-item">
						<h3>Think Strategically.</h3>
					</div>
					<div class="philosophy-item">
						<h3>Execute Precisely.</h3>
					</div>
					<div class="philosophy-item">
						<h3>Lead Responsibly.</h3>
					</div>
				</div>
			</div>
			
			<p class="text">
				I believe that strong administration is the foundation of a successful educational publishing organization. It is about bringing together people, ideas, creativity, and processes to deliver high-quality educational resources.
			</p>
			
			<p class="text">
				Through strategic planning, effective communication, organized documentation, and continuous improvement, I work to ensure that every publication reflects our commitment to educational excellence.
			</p>
			
			
			
			<blockquote class="vs-quote">
				<p>"{{ !empty($adminDesk->quote) ? $adminDesk->quote : 'Education is the most powerful weapon which you can use to change the world. We make learning seamless, engaging, and impactful.' }}&nbsp;"</p>
				<span class="quote-icon"><img src="{{ asset('assets/img/icons/quote-icon.svg') }}" alt="icon"></span>
			</blockquote>

            @if(!empty($adminDesk->bio))
              <div class="well well-sm my-3 p-3 bg-light rounded border-start border-4 border-primary" style="font-size: 15px; line-height: 1.8; color: #374151;">
                {!! nl2br(e($adminDesk->bio)) !!}
              </div>
            @endif
			
			<h6>Our Vision</h6>
			<p class="text">
				My goal is not simply to manage daily operations, but to strengthen organizational systems, improve coordination, support publishing excellence, and help our team create educational resources that make learning easier and more effective.
			</p>
			
			<p class="text txt-msg">
				“Because When Quality Education Meets Dedicated Administration, Every Book Becomes a Step Towards a Brighter Future.”
			</p>
			
			<h6>Driving Excellence in Educational Publishing.</h6>
			<p class="text">
				At <strong>Smart Notes Publication</strong>, I contribute to the coordination and administration of educational book development, academic content management, printing, publication, and distribution processes.
			</p>
			<p class="text">
				My focus is to support our editorial, academic, design, production, and distribution teams through clear communication, organized workflows, efficient operations, and timely delivery.
			</p>	
			<p class="text">
				From school textbooks and reference books to study materials, academic guides, and competitive examination resources, I believe every publication should provide students with accurate knowledge, simplified learning, and meaningful educational value.
			</p>
			
            <!-- <div class="author-social">
              <h3 class="social-title">Social Media</h3>
              <ul class="social-links">
                <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
                <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
              </ul>
            </div> -->
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
