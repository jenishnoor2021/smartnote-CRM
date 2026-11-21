<footer class="footer-layout1 style2 z-index-common">
    <style>
        .footer-widget .widget_title {
            word-break: break-word;
        }
        .footer-widget.widget_nav_menu a {
            word-break: break-word;
        }
        @media (min-width: 1200px) and (max-width: 1399px) {
            .footer-layout1 .footer-menu {
                gap: 25px !important;
            }
        }
    </style>
    <!-- Cta Area -->
    <div class="container">
        <div class="cta-layout1 style2 z-index-common blog-title">
            <div class="row gx-60 align-items-center">
                <div class="col-lg-3">
                    <div class="cta-logo">
                        <a href="{{ url('/') }}">
                            @if(isset($siteSettings['site_footer_logo']) && $siteSettings['site_footer_logo'])
                                <img src="{{ asset($siteSettings['site_footer_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo">
                            @else
                                <img src="{{ asset('assets/img/footer-logo.png') }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo">
                            @endif
                        </a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row justify-content-xl-between justify-content-center align-items-center">
                        <div class="col-lg-5">
                            <div class="newsletter-inner">
                                <span class="newsletter-icon"><img src="{{ asset('assets/img/icons/mail-2.svg') }}" alt="icon"></span>
                                <div class="newsletter-content">
                                    <h4 class="newsletter_title">Get In Touch</h4>
                                    <p class="newsletter-text">Subscribe for more Update</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <form action="{{ route('front.newsletter.subscribe') }}" method="POST" id="newsletter_form" class="newsletter-form">
                                @csrf
                                <div style="display:none!important; position:absolute; left:-9999px; z-index:-1; opacity:0; pointer-events:none;" aria-hidden="true">
                                    <input type="text" name="newsletter_hp" id="newsletter_hp" tabindex="-1" autocomplete="off" value="">
                                </div>
                                <input type="hidden" name="_form_time" id="newsletter_form_time" value="{{ encrypt(time()) }}">
                                <div class="search-btn">
                                    <input class="form-control" type="email" name="email" id="newsletter_email" placeholder="Your Email Address" required>
                                    <button type="submit" class="vs-btn" id="newsletter_btn"><i class="fa-solid fa-paper-plane"></i> Subscribe</button>
                                </div>
                                <div id="newsletter_feedback" style="margin-top: 6px; font-size: 13px; font-weight: 500; display: none;"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cta Area End -->
    <div class="footer-top">
        <div class="container">
            <div class="row g-4 g-xl-5 justify-content-between">
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2 col-margin col-width-left">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">Explore Us<span class="title-shape"><img
                                    src="{{ asset('assets/img/shapes/footer-line-shape.svg') }}" alt="Shape Image"></span></h3>
                        <ul class="menu">
                            <li><a href="{{ url('/') }}"><i class="far fa-angle-right"></i> Home</a></li>
                            <li><a href="{{ url('about') }}"><i class="far fa-angle-right"></i> About Us</a></li>
                            <li><a href="{{ url('team') }}"><i class="far fa-angle-right"></i> Team</a></li>
                            <li><a href="{{ url('service') }}"><i class="far fa-angle-right"></i> Services</a></li>
                            <li><a href="{{ url('gallery') }}"><i class="far fa-angle-right"></i> Gallery</a></li>
                            <li><a href="{{ url('distributor') }}"><i class="far fa-angle-right"></i> Literary Trader</a></li>
                            <li><a href="{{ url('contact') }}"><i class="far fa-angle-right"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-6 col-sm-7 col-md-4 col-lg-4 col-xl-4 col-margin col-width-right">
                    @if(isset($headerCategories) && $headerCategories->count() > 0)
                        @foreach($headerCategories->take(2) as $fCat)
                            <div class="widget widget_nav_menu footer-widget {{ !$loop->last ? 'mb-4' : '' }}">
                                <h3 class="widget_title" style="font-size: 19px; line-height: 1.35; margin-bottom: 20px;">{{ $fCat->category_name }} <span class="title-shape"><img
                                            src="{{ asset('assets/img/shapes/footer-line-shape.svg') }}" alt="Shape Image"></span></h3>
                                <ul class="menu">
                                    @foreach($fCat->subcategories->take(4) as $fSub)
                                        <li>
                                            <a href="{{ route('front.product.index', ['subcategory' => $fSub->id]) }}">
                                                <i class="far fa-angle-right"></i> {{ $fSub->subcategory_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="{{ route('front.product.index', ['category' => $fCat->id]) }}" style="font-weight: 600; color: #ff5722;">
                                            <i class="far fa-arrow-right"></i> Explore All {{ Str::limit($fCat->category_name, 22) }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="col-12 col-md-4 col-lg-5 col-xl-6 col-margin">
                    <div class="widget widget_nav_menu footer-widget">
                        <h3 class="widget_title">Our Branches<span class="title-shape"><img
                                    src="{{ asset('assets/img/shapes/footer-line-shape.svg') }}" alt="Shape Image"></span></h3>

                        <ul class="menu footer-menu txt-email">
                            <li>
                                <h6>MUMBAI</h6>
                                <div class="list-style1 pd-right-listing">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-map-marked-alt"></i> <a href="#">{{ $siteSettings['address_mumbai'] ?? '33, Pragati Icon, A. S. Gawade Marg, Pant Nagar, Mumbai, Maharashtra-400075' }}</a></li>
                                        <li><i class="fas fa-envelope"></i><a href="mailto:{{ $siteSettings['email_support'] ?? 'Sevenhigheducationpvtltd@gmail.com' }}">{{ $siteSettings['email_support'] ?? 'Sevenhigheducationpvtltd@gmail.com' }}</a></li>
                                        <li><i class="fa-solid fa-headset"></i> <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['phone_secondary'] ?? '+91 9213005642') }}">{{ $siteSettings['phone_secondary'] ?? '+91 9213005642' }}</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <h6 class="pd-top-3">SURAT</h6>
                                <div class="list-style1">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-map-marked-alt"></i> <a href="#">{{ $siteSettings['address_surat'] ?? '222 to 224, Prime Shoppers, Opp. Safal Square, Udhna-magdalla Road, Vesu, Surat - 395007' }}</a></li>
                                        <li><i class="fas fa-envelope"></i><a href="mailto:{{ $siteSettings['email_primary'] ?? 'smartnotespublication@gmail.com' }}">{{ $siteSettings['email_primary'] ?? 'smartnotespublication@gmail.com' }}</a></li>
                                        <li><i class="fa-solid fa-headset"></i> <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['phone_primary'] ?? '+91 9979865666') }}">{{ $siteSettings['phone_primary'] ?? '+91 9979865666' }}</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-info">
        <div class="container">
            <div class="row g-6 justify-content-lg-around align-items-center justify-content-center">
                <div class="col-lg-4">
                    <div class="contact-body">
                        <ul class="social-links">
                            @if(!empty($siteSettings['facebook_url']))
                                <li><a href="{{ $siteSettings['facebook_url'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            @endif
                            @if(!empty($siteSettings['linkedin_url']) && $siteSettings['linkedin_url'] !== '#')
                                <li><a href="{{ $siteSettings['linkedin_url'] }}" target="_blank"><i class="fa-brands fa-linkedin"></i></a></li>
                            @endif
                            @if(!empty($siteSettings['instagram_url']))
                                <li><a href="{{ $siteSettings['instagram_url'] }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            @endif
                            @if(!empty($siteSettings['youtube_url']))
                                <li><a href="{{ $siteSettings['youtube_url'] }}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 justify-content-lg-end align-items-end justify-content-end text-end">
                    <div class="copyright-menu">
                        <ul class="list-unstyled">
                            <li><a href="{{ url('book-publishing-house') }}">Book Publishing House</a></li>
                            <li><a href="{{ url('book-publication') }}">Book Publication</a></li>
                            <li><a href="{{ url('book-publisher') }}">Book Publisher </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrap">
        <div class="container">
            <p class="copyright-text">Copyright <i class="fal fa-copyright"></i>
                <script>
                    document.write(new Date().getFullYear())
                </script> <a href="{{ url('/') }}">{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}</a>.
                All Rights Reserved By <a href="{{ url('/') }}">{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}</a>
            </p>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('newsletter_form');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var email = document.getElementById('newsletter_email').value;
        var btn = document.getElementById('newsletter_btn');
        var feedback = document.getElementById('newsletter_feedback');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Subscribing...';
        
        fetch("{{ route('front.newsletter.subscribe') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email, newsletter_hp: document.getElementById('newsletter_hp')?.value || '', _form_time: document.getElementById('newsletter_form_time')?.value || '' })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            feedback.style.display = 'block';
            if (data.status === 'success') {
                feedback.style.color = '#10b981';
                feedback.textContent = data.message;
                form.reset();
            } else {
                feedback.style.color = '#ef4444';
                feedback.textContent = data.message || 'Something went wrong. Please try again.';
            }
        })
        .catch(function(err) {
            feedback.style.display = 'block';
            feedback.style.color = '#ef4444';
            feedback.textContent = 'Messge sent to admin, Could not subscribe right now. Please try again.';
        })
        .finally(function() {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Subscribe';
        });
    });
});
</script>
