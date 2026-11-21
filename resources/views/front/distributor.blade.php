@extends('layouts.front')

@section('title', 'Literary Trader / Distributor - SMART NOTES PUBLICATION PVT. LTD.')

@section('page_style')
<style>
  .distributor-data .feature-style2 {
    background: #ffffff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
  }
  .distributor-data .feature-style2:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  }
  .distributor-card-wrapper {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06);
    border: 1px solid #e2e8f0;
    padding: 40px;
  }
  @media (max-width: 767px) {
    .distributor-card-wrapper {
      padding: 24px 16px;
    }
  }
  .distributor-form .form-group {
    margin-bottom: 20px;
  }
  .distributor-form .form-label {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b !important;
    margin-bottom: 8px;
    display: block;
  }
  .distributor-form .form-label .text-danger {
    color: #ef4444 !important;
  }
  /* Force dark text and clean white background on inputs and textareas */
  .distributor-form input.form-control,
  .distributor-form select.form-control,
  .distributor-form textarea.form-control {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 12px 16px !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    height: 48px;
    line-height: normal;
    box-shadow: none !important;
    -webkit-text-fill-color: #0f172a !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }
  .distributor-form input.form-control:focus,
  .distributor-form select.form-control:focus,
  .distributor-form textarea.form-control:focus {
    background-color: #ffffff !important;
    color: #0f172a !important;
    -webkit-text-fill-color: #0f172a !important;
    border-color: #0284c7 !important;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18) !important;
    outline: none !important;
  }
  .distributor-form input.form-control::placeholder,
  .distributor-form textarea.form-control::placeholder {
    color: #94a3b8 !important;
    -webkit-text-fill-color: #94a3b8 !important;
    opacity: 1 !important;
  }
  .distributor-form textarea.form-control {
    height: auto !important;
    min-height: 95px !important;
    line-height: 1.5 !important;
    resize: vertical;
  }
  /* Nice Select style override inside distributor form */
  .distributor-form .nice-select {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 8px !important;
    height: 48px !important;
    line-height: 44px !important;
    padding-left: 16px !important;
    padding-right: 36px !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    width: 100% !important;
    box-shadow: none !important;
  }
  .distributor-form .nice-select:focus,
  .distributor-form .nice-select.open {
    border-color: #0284c7 !important;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18) !important;
    background-color: #ffffff !important;
  }
  .distributor-form .nice-select .current {
    color: #0f172a !important;
    font-weight: 500 !important;
  }
  .distributor-form .nice-select .list {
    border-radius: 8px !important;
    border: 1px solid #cbd5e1 !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    background-color: #ffffff !important;
    max-height: 250px;
    overflow-y: auto;
    width: 100%;
  }
  .distributor-form .nice-select .option {
    color: #1e293b !important;
    font-size: 14px;
    padding: 10px 16px;
    line-height: 24px;
  }
  .distributor-form .nice-select .option:hover,
  .distributor-form .nice-select .option.focus,
  .distributor-form .nice-select .option.selected.focus {
    background-color: #f1f5f9 !important;
    color: #0284c7 !important;
  }
  .distributor-form #btnSubmitDistributor {
    min-width: 260px;
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
        <h1 class="breadcumb-title">Literary Trader & Distributors</h1>
        <div class="breadcumb-menu-wrap">
          <div class="breadcumb-menu">
            <span><a href="{{ url('/') }}">Home</a></span>
            <span>About</span>
            <span>Literary Trader</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!--==============================
  Author Area start
==============================-->
  <section class="vs-blog-wrapper distributor-data space-top space-extra-bottom">
    <div class="container">
      <div class="title-area text-center wow animate__fadeInUp title-anime animation-style5" data-wow-delay="0.25s">
        <span class="sec-subtitle left-shape justify-content-center title-anime__title">Our Partners</span>
        <h2 class="sec-title title-anime__title">Key Distribution Associates</h2>
        <p class="main-sub-title blue-title">Our dedicated partners helping deliver educational excellence across regions</p>
      </div>

      <div class="row g-4">
        <div class="row g-4 justify-content-center">
          <div class="col-xl-4 col-lg-4 col-md-4 col-12 wow animate__fadeInUp" data-wow-delay="0.40s">
            <div class="feature-style2">
              <span class="feature-img">
              <img src="{{ asset('assets/img/page/chhaganbhai-katariya.jpeg') }}" alt="Mr. Chhaganbhai Katariya">
            </span>
              <h2 class="feature-title"><a href="#">Mr. Chhaganbhai Katariya</a></h2>
			  <p class="distributer-designation"> Distribution Associate </p>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4 col-12 wow animate__fadeInUp" data-wow-delay="0.50s">
            <div class="feature-style2">
              <span class="feature-img">
              <img src="{{ asset('assets/img/page/govindbhai-katariya.jpeg') }}" alt="Mr. Govindbhai Katariya">
            </span>
              <h2 class="feature-title"><a href="#">Mr. Govindbhai Katariya</a></h2>
			  <p class="distributer-designation"> Distribution Associate </p>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4 col-12 wow animate__fadeInUp" data-wow-delay="0.60s">
            <div class="feature-style2">
              <span class="feature-img">
              <img src="{{ asset('assets/img/page/mukeshbhai-katariya.jpeg') }}" alt="Mr. Mukeshbhai Katariya">
            </span>
              <h2 class="feature-title"><a href="#">Mr. Mukeshbhai Katariya</a></h2>
			  <p class="distributer-designation"> Distribution Associate </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Distributor Application Form -->
      <div class="row mt-5 pt-4">
        <div class="col-lg-10 mx-auto">
          <div class="distributor-card-wrapper">
            <div class="title-area text-center mb-4">
              <span class="sec-subtitle"><i class="fa-solid fa-handshake"></i> Partner With Us</span>
              <h2 class="sec-title">Apply to Become a Smart Notes Distributor</h2>
              <p class="lead text-muted">Join our growing network of educational book distributors and dealers across India.</p>
            </div>

            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show text-start" role="alert" style="border-radius: 8px; padding: 14px 20px; margin-bottom: 25px;">
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

            <form action="{{ route('front.distributor.submit') }}" method="POST" id="distributor_form" class="distributor-form">
              @csrf
              <div class="row gx-20">
                <div class="col-md-6 form-group">
                  <label class="form-label text-semibold">Trader / Proprietor Name <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="trader_name" value="{{ old('trader_name') }}" placeholder="Full Name of Trader" required>
                </div>
                <div class="col-md-6 form-group">
                  <label class="form-label text-semibold">Firm / Company / Agency Name</label>
                  <input class="form-control" type="text" name="firm_name" value="{{ old('firm_name') }}" placeholder="e.g. Saraswati Book Store">
                </div>
                <div class="col-md-6 form-group">
                  <label class="form-label text-semibold">Mobile / Phone Number <span class="text-danger">*</span></label>
                  <input class="form-control" type="tel" name="phone" value="{{ old('phone') }}" placeholder="Mobile Number" required>
                </div>
                <div class="col-md-6 form-group">
                  <label class="form-label text-semibold">Email Address</label>
                  <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Email Address">
                </div>
                <div class="col-md-6 form-group">
                  <label class="form-label text-semibold">City / District <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" name="city" value="{{ old('city') }}" placeholder="e.g. Surat, Ahmedabad, Rajkot..." required>
                </div>
                <div class="col-md-6 form-group">
                  <label class="form-label text-semibold">Business Type</label>
                  <select name="business_type" class="form-control">
                    <option value="Book Wholesaler" {{ old('business_type') == 'Book Wholesaler' ? 'selected' : '' }}>Book Wholesaler</option>
                    <option value="Retail Book Store" {{ old('business_type') == 'Retail Book Store' ? 'selected' : '' }}>Retail Book Store</option>
                    <option value="School Supplier" {{ old('business_type') == 'School Supplier' ? 'selected' : '' }}>School Supplier</option>
                    <option value="Educational Stationery" {{ old('business_type') == 'Educational Stationery' ? 'selected' : '' }}>Educational Stationery</option>
                    <option value="Other" {{ old('business_type') == 'Other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>
                <div class="col-md-6 form-group">
                  <label class="form-label text-semibold">Experience in Book Trade (Years)</label>
                  <input class="form-control" type="number" name="experience_years" value="{{ old('experience_years') }}" placeholder="e.g. 5" min="0">
                </div>
                <div class="col-md-6 form-group">
                  <label class="form-label text-semibold">GST / Tax Number (if applicable)</label>
                  <input class="form-control" type="text" name="gst_number" value="{{ old('gst_number') }}" placeholder="GST Number">
                </div>
                <div class="col-md-12 form-group">
                  <label class="form-label text-semibold">Shop / Firm Full Address</label>
                  <textarea name="address" rows="2" class="form-control" placeholder="Complete address with pincode">{{ old('address') }}</textarea>
                </div>
                <div class="col-md-12 form-group">
                  <label class="form-label text-semibold">Message / Preferred Territories / Brands Handled</label>
                  <textarea name="message" rows="3" class="form-control" placeholder="Any specific requirements, target schools, questions...">{{ old('message') }}</textarea>
                </div>
                <div class="col-md-12 form-group text-start">
                  @include('partial.bot_protection', ['formKey' => 'distributor'])
                </div>
                <div class="col-md-12 form-group text-center mt-3">
                  <button class="vs-btn justify-content-center" id="btnSubmitDistributor" type="submit">Submit Distributor Application</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </section>
  <!--==============================
    Author Area End
==============================-->
@endsection

@section('page_script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('distributor_form');
  const btn = document.getElementById('btnSubmitDistributor');

  if (form && btn) {
    form.addEventListener('submit', function(e) {
      if (!form.checkValidity()) {
        return;
      }
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Submitting Application...';
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
