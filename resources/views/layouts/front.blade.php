<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'SMART NOTES PUBLICATION PVT. LTD. | School Books Publisher | Nursery to Class 8')</title>
    <meta name="author" content="SMART NOTES PUBLICATION PVT. LTD.">
    <meta name="description" content="@yield('meta_description', 'Explore educational school books for Nursery to Std. 8 in English and Gujarati Medium. Smart Notes Publication offers concept-based, activity-oriented, and student-friendly books for schools and learners.')">
    <meta name="keywords" content="@yield('meta_keywords', 'educational books, school books, book publisher, nursery to std 8 books, pre primary school books, primary school books')">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ url('/') }}/">

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('assets/img/favicons/favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('assets/img/favicons/favicon.png') }}" type="image/png" sizes="32x32">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicons/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicons/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&amp;family=Poppins:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">

    <!-- All CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nouislider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sn-header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sn-floating-order.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sn-floating-whatsapp.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sn-product-gallery.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sn-product-inquiry.css?v=2') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sn-mobile-filters.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sn-signup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sn-ordernow-modal.css?v=1') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
      .pagination svg, nav svg {
        max-width: 18px !important;
        max-height: 18px !important;
      }
    </style>
    @yield('page_style')
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-bg">
            <button class="vs-btn preloaderCls">Cancel Preloader </button>
            <div class="preloader-inner wow animate__animated animate__flip" data-wow-delay="0.50s">
                <img src="{{ asset('assets/img/logo-preloader.png') }}" class="loader_image" alt="logo">
                <span class="loader"></span>
            </div>
        </div>
    </div>
    <script>
        // Super-fast preloader dismiss - ensures page is never blocked
        (function() {
            function removeLoader() {
                var el = document.querySelector('.preloader');
                if (el && el.style.display !== 'none') {
                    el.style.opacity = '0';
                    el.style.transition = 'opacity 0.25s ease, transform 0.3s ease';
                    el.style.transform = 'translateY(-100%)';
                    setTimeout(function() { el.style.display = 'none'; }, 300);
                }
            }
            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                setTimeout(removeLoader, 200);
            } else {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(removeLoader, 200);
                });
            }
            setTimeout(removeLoader, 600);
        })();
    </script>

    <!-- Floating Buttons -->
    <a class="sn-floating-whatsapp" href="https://api.whatsapp.com/send?phone=919979865666&amp;text=Welcome%20to%20SMARTNOTES%20PUBLICATION." target="_blank" rel="noopener noreferrer" aria-label="Chat with Smart Notes Publication on WhatsApp (opens in a new tab)">
      <span class="sn-floating-whatsapp-icon" aria-hidden="true"><i class="fa-brands fa-whatsapp"></i></span>
    </a>
    <a class="sn-floating-order" href="{{ route('front.product.index') }}">
      <span class="sn-floating-order-icon" aria-hidden="true"><i class="fa-solid fa-bag-shopping"></i></span>
      <span>Order Now</span>
      <i class="fa-solid fa-arrow-right sn-floating-order-arrow" aria-hidden="true"></i>
    </a>
    <button class="back-to-top" id="backToTop" aria-label="Back to Top">
        <span class="progress-circle">
            <svg viewBox="0 0 100 100">
                <circle class="bg" cx="50" cy="50" r="40"></circle>
                <circle class="progress" cx="50" cy="50" r="40"></circle>
            </svg>
            <span class="progress-percentage" id="progressPercentage">0%</span>
        </span>
    </button>

    <!-- Header Area -->
    @include('partial.header')

    <!-- Main Content Area -->
    @yield('content')

    <!-- Footer Area -->
    @include('partial.footer')

    <!-- Sign-up / Login Popup -->
    @include('partial.signup-popup')

    <!-- All JS Files -->
    <script src="{{ asset('assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('assets/js/gsap-scroll-to-plugin.js') }}"></script>
    <script src="{{ asset('assets/js/SplitText.js') }}"></script>
    <script src="{{ asset('assets/js/lenis.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/sn-header-cart.js?v=2') }}"></script>
    <script src="{{ asset('assets/js/sn-product-gallery.js') }}"></script>
    <script src="{{ asset('assets/js/sn-product-inquiry.js?v=5') }}"></script>
    <script src="{{ asset('assets/js/sn-mobile-filters.js') }}"></script>
    <script src="{{ asset('assets/js/sn-signup.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('page_script')

    <script>
    document.addEventListener("click", function(e) {
        var btn = e.target.closest(".sn-btn-refresh-captcha");
        if (!btn) return;
        e.preventDefault();
        var key = btn.getAttribute("data-target") || "default";
        var container = btn.closest(".sn-bot-security-box") || document.getElementById("snBotBox_" + key);
        if (!container) return;
        var icon = btn.querySelector("i");
        if (icon) icon.classList.add("fa-spin");
        fetch("{{ route('front.refresh_captcha') }}?key=" + encodeURIComponent(key))
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    var qEl = container.querySelector(".sn-captcha-question-text");
                    if (qEl) qEl.textContent = data.question;
                    var tokenEl = container.querySelector(".sn-captcha-token");
                    if (tokenEl) tokenEl.value = data.token;
                    var inputEl = container.querySelector(".sn-captcha-input");
                    if (inputEl) { inputEl.value = ""; inputEl.focus(); }
                    var form = container.closest("form");
                    if (form && data.rendered_at) {
                        var timeEl = form.querySelector(".sn-form-time");
                        if (timeEl) timeEl.value = data.rendered_at;
                    }
                }
            })
            .catch(function(err) { console.error("Captcha refresh failed:", err); })
            .finally(function() {
                if (icon) icon.classList.remove("fa-spin");
            });
    });

    // Global Quick Add to Cart Handler
    document.addEventListener("click", function(e) {
        var btn = e.target.closest(".btn-add-to-cart-quick");
        if (!btn) return;
        e.preventDefault();
        var prodId = btn.getAttribute("data-id");
        if (!prodId) return;

        var icon = btn.querySelector("i");
        var origClass = icon ? icon.className : "";
        if (icon) icon.className = "fa-solid fa-spinner fa-spin";
        btn.disabled = true;

        var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || "{{ csrf_token() }}";

        fetch("{{ route('front.cart.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            },
            body: JSON.stringify({ product_id: prodId, quantity: 5 })
        })
        .then(function(res) {
            return res.json().then(function(data) {
                return { ok: res.ok, status: res.status, data: data };
            }).catch(function() {
                return { ok: res.ok, status: res.status, data: null };
            });
        })
        .then(function(result) {
            var data = result.data;
            if (result.ok && data && data.success) {
                document.querySelectorAll(".headerCartCountBadge, #headerCartCount").forEach(function(el) {
                    el.textContent = data.cart_count;
                });
                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        icon: "success",
                        title: "Added to Cart!",
                        text: data.message,
                        showCancelButton: true,
                        confirmButtonText: '<i class="fa-solid fa-basket-shopping me-1"></i> View Cart & Checkout',
                        cancelButtonText: "Continue Shopping",
                        confirmButtonColor: "#084b87",
                        cancelButtonColor: "#64748b"
                    }).then(function(res) {
                        if (res.isConfirmed) {
                            window.location.href = "{{ route('front.cart') }}";
                        }
                    });
                } else {
                    alert(data.message);
                }
            } else {
                var msg = (data && data.message) ? data.message : "Could not add to cart. Please try again.";
                if (typeof Swal !== "undefined") {
                    Swal.fire({ icon: "error", title: "Cart Error", text: msg, confirmButtonColor: "#dc3545" });
                } else {
                    alert(msg);
                }
            }
        })
        .catch(function(err) {
            console.error(err);
            alert("Error adding to cart: " + (err.message || "Network issue"));
        })
        .finally(function() {
            btn.disabled = false;
            if (icon) icon.className = origClass;
        });
    });
    </script>


</body>
</html>

