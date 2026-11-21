@extends('layouts.front')

@section('title', 'Contact Us - SMART NOTES PUBLICATION PVT. LTD.')

@section('page_style')
<style>
  .contact-layout2 .form-style1 .form-control {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border: 1.5px solid #cbd5e1 !important;
    font-size: 15px !important;
  }
  .contact-layout2 .form-style1 .form-control:focus {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border-color: #0284c7 !important;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18) !important;
    outline: none !important;
  }
  .contact-layout2 .form-style1 .form-control::placeholder {
    color: #94a3b8 !important;
    opacity: 1 !important;
  }
  .contact-layout2 .form-style1 .nice-select,
  .contact-layout2 .form-style1 select.orderby {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border: 1.5px solid #cbd5e1 !important;
  }
  .contact-layout2 .form-style1 .nice-select .current {
    color: #0f172a !important;
  }
  .contact-layout2 .form-style1 #btnSubmitContact {
    min-width: 200px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.25s ease;
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
        <h1 class="breadcumb-title">Contact Us</h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span>Contact Us</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <section class="contact-layout2 space">
    <div class="container">
		<div class="title-area text-center wow animate__fadeInUp title-anime animation-style5" data-wow-delay="0.25s">
		  <span class="sec-subtitle left-shape justify-content-center title-anime__title">Corporate Branch</span>
		  <h2 class="sec-title title-anime__title">Our Branches</h2>
		  <p class="main-sub-title blue-title">SURAT Regional Office</p>
		</div>
      <div class="row g-4 space-bottom">
        <div class="col-xl-4 col-lg-6 col-md-6">
          <div class="contact-media wow animate__fadeInUp" data-wow-delay="0.25s">
            <div class="media-style1">
              <div class="media-info">
                <h3 class="media-title">Office Address:</h3>
                <div class="media-icon"><img src="{{ asset('assets/img/icons/location.svg') }}" alt="icon"></div>
              </div>
              <p class="media-text"><a href="https://maps.app.goo.gl/GkqDZApPwJnuhNgA9" target="_blank">{{ $siteSettings['address_surat'] ?? '222-224, Second floor, Prime Shoppers, Opp. Safal Square, Udhna-magdalla Road, Vesu, Surat - 395007' }}</a></p>
            </div>
          </div>
        </div>
		 <div class="col-xl-4 col-lg-6 col-md-6">
          <div class="contact-media wow animate__fadeInUp" data-wow-delay="0.45s">
            <div class="media-style1">
              <div class="media-info">
                <h3 class="media-title">Contact Number:</h3>
                <div class="media-icon"><img src="{{ asset('assets/img/icons/call.svg') }}" alt="icon"></div>
              </div>
			  <p class="media-text mb-2">Call us today to connect with our team and get the support you need.</p>
              <p class="media-text"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['phone_primary'] ?? '+919979865666') }}"><strong>{{ $siteSettings['phone_primary'] ?? '(+91) 99798-65666' }}</strong></a></p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12">
          <div class="contact-media wow animate__fadeInUp" data-wow-delay="0.65s">
            <div class="media-style1">
              <div class="media-info">
                <h3 class="media-title">Email Address:</h3>
                <div class="media-icon"><img src="{{ asset('assets/img/icons/mail.svg') }}" alt="icon"></div>
              </div>
			  <p class="media-text mb-2">Get in touch with our team quickly and easily for expert assistance.</p>
              <p class="media-text"><a href="mailto:{{ $siteSettings['email_primary'] ?? 'smartnotespublication@gmail.com' }}"><strong>{{ $siteSettings['email_primary'] ?? 'smartnotespublication@gmail.com' }}</strong></a></p>
            </div>
          </div>
        </div>
      </div>
	  
	  <div class="title-area text-center wow animate__fadeInUp title-anime animation-style5" data-wow-delay="0.25s">
		  <p class="main-sub-title">MUMBAI Regional Office</p>
		</div>
      <div class="row g-4 space-bottom mumbai-text">
        <div class="col-xl-4 col-lg-6 col-md-6">
          <div class="contact-media wow animate__fadeInUp" data-wow-delay="0.25s">
            <div class="media-style1 contact-style-2">
              <div class="media-info">
                <h3 class="media-title">Office Address:</h3>
                <div class="media-icon"><img src="{{ asset('assets/img/icons/location.svg') }}" alt="icon"></div>
              </div>
              <p class="media-text">{{ $siteSettings['address_mumbai'] ?? 'Office no.3, Building no.33, Pragati Icon, A. S. Gawade Marg, Pant Nagar, Ghatkopar East, Mumbai, Maharashtra-400075' }}</p>
            </div>
          </div>
        </div>
		 <div class="col-xl-4 col-lg-6 col-md-6">
          <div class="contact-media wow animate__fadeInUp" data-wow-delay="0.45s">
            <div class="media-style1 contact-style-2">
              <div class="media-info">
                <h3 class="media-title">Contact Number:</h3>
                <div class="media-icon"><img src="{{ asset('assets/img/icons/call.svg') }}" alt="icon"></div>
              </div>
			  <p class="media-text mb-2">Call us today to connect with our team and get the support you need.</p>
              <p class="media-text"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['phone_secondary'] ?? '+919213005642') }}"><strong>{{ $siteSettings['phone_secondary'] ?? '(+91) 92130-05642' }}</strong></a></p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12">
          <div class="contact-media wow animate__fadeInUp" data-wow-delay="0.65s">
            <div class="media-style1 contact-style-2">
              <div class="media-info">
                <h3 class="media-title">Email Address:</h3>
                <div class="media-icon"><img src="{{ asset('assets/img/icons/mail.svg') }}" alt="icon"></div>
              </div>
			  <p class="media-text mb-2">Get in touch with our team quickly and easily for expert assistance.</p>
              <p class="media-text"><a href="mailto:{{ $siteSettings['email_support'] ?? 'Sevenhigheducationpvtltd@gmail.com' }}"><strong>{{ $siteSettings['email_support'] ?? 'Sevenhigheducationpvtltd@gmail.com' }}</strong></a></p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12 text-center">

          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; padding: 16px 20px; font-size: 16px; margin-bottom: 25px;">
              <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; padding: 16px 20px; font-size: 16px; margin-bottom: 25px;">
              <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if(isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show text-start" role="alert" style="border-radius: 8px; padding: 14px 20px; margin-bottom: 25px;">
              <ul class="mb-0">
                @foreach($errors->all() as $err)
                  <li>{{ $err }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form class="form-style1 wow animate__fadeInUp" id="contact_form" data-wow-delay="0.35s" action="{{ route('front.contact.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="source_page" value="Contact Us Page">
            <div class="title-area animation-style1 title-anime">
              <h2 class="sec-title text-title title-anime__title">Get In Touch With SMARTNOTES PUBLICATION</h2>
            </div>
            <div class="row gx-20">
              <div class="col-md-6 form-group">
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Enter Full Name" required>
                <i class="fas fa-user"></i>
              </div>
              <div class="col-md-6 form-group">
                <input class="form-control" type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Enter Mobile Number" required>
                <i class="fas fa-phone"></i>
              </div>
              <div class="col-md-6 form-group">
                <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter Email ID">
                <i class="fas fa-envelope"></i>
              </div>
              <div class="col-md-6 form-group">
                <select name="subject" class="orderby" aria-label="Book Category or Subject">
                  <option value="" selected="selected">Select Category / Inquiry Type</option>
                  <option value="English Medium - Pre Primary Section" {{ old('subject') == 'English Medium - Pre Primary Section' ? 'selected' : '' }}>English Medium - Pre Primary Section</option>
                  <option value="English Medium - Primary Section" {{ old('subject') == 'English Medium - Primary Section' ? 'selected' : '' }}>English Medium - Primary Section</option>
                  <option value="Gujarati Medium - Pre Primary Section" {{ old('subject') == 'Gujarati Medium - Pre Primary Section' ? 'selected' : '' }}>Gujarati Medium - Pre Primary Section</option>
                  <option value="Gujarati Medium - Primary Section" {{ old('subject') == 'Gujarati Medium - Primary Section' ? 'selected' : '' }}>Gujarati Medium - Primary Section</option>
                  <option value="General School / Bulk Inquiry" {{ old('subject') == 'General School / Bulk Inquiry' ? 'selected' : '' }}>General School / Bulk Inquiry</option>
                </select>
              </div>
              <div class="col-md-12 form-group">
                <textarea name="message" class="form-control" placeholder="Message or inquiry details here..." required>{{ old('message') }}</textarea>
              </div>
              <div class="col-md-12 form-group text-start">
                @include('partial.bot_protection', ['formKey' => 'contact'])
              </div>
              <div class="col-md-12 form-group">
                <button class="vs-btn justify-content-center" id="btnSubmitContact" type="submit">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!--==============================
  Map Area
  ============================== -->
  <div class="map-layout1">
  <div class="row">
	<div class="col-12 col-md-6 col-lg-6">
    <div class="left-map ratio ratio-21x9 wow animate__fadeInUp" data-wow-delay="0.35s" style="height:500px;">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.061921990398!2d72.76733337520074!3d21.14993388360577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04dd17f1ec619%3A0x778512bbfeb9a5fa!2sSmartNotes%20Publication!5e0!3m2!1sen!2sin!4v1791443904983!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
    </div>
	<div class="col-12 col-md-6 col-lg-6">
	<div class="right-map ratio ratio-21x9 wow animate__fadeInUp" data-wow-delay="0.35s" style="height:500px;">
		<iframe src="https://www.google.com/maps/embed?pb=!4v1791444306276!6m8!1m7!1sxgZx_8vZEKYJf_vxeSI2SQ!2m2!1d21.14993383208995!2d72.7698689727953!3f65.526764!4f0!5f0.7820865974627469" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
	</div>
	</div>
  </div>
  </div>
@endsection

@section('page_script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('contact_form');
  const btn = document.getElementById('btnSubmitContact');

  if (form && btn) {
    form.addEventListener('submit', function(e) {
      if (!form.checkValidity()) {
        return;
      }
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Sending Message...';
      btn.style.pointerEvents = 'none';
      btn.style.opacity = '0.8';
      setTimeout(function() {
        btn.disabled = true;
      }, 50);
    });
  }
});
</script>
@endsection
