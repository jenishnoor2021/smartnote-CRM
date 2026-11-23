<div class="vs-menu-wrapper">
        <div class="vs-menu-area text-center">
            <div class="mobile-logo">
                <a href="{{ url('/') }}">
                    @if(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                        <img src="{{ asset($siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo">
                    @else
                        <img src="{{ asset('assets/img/logo-mobile.png') }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo">
                    @endif
                </a>
                <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
            </div>
            <div class="vs-mobile-menu">
                <ul>
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="{{ url('about') }}">About Us</a>
                        <ul class="sub-menu">
                            <li><a href="{{ url('about') }}">About</a></li>
                            <li><a href="{{ url('chairman') }}">Chairman's Perspective</a></li>
                            <li><a href="{{ url('senior-executive-administrator') }}">From The Admin Desk</a></li>
                            <li><a href="{{ url('distributor') }}">Literary Trader</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ url('team') }}">Team</a>
                    </li>
                    <li class="menu-item-has-children mega-menu-wrap">
                        <a href="{{ route('front.product.index') }}">Educational Books</a>
                        <ul class="mega-menu">
                            @if(isset($headerCategories) && $headerCategories->count() > 0)
                                @foreach($headerCategories->where('category_name', '!=', 'Books by Series') as $hCat)
                                    <li>
                                        <a href="{{ route('front.product.index', ['category' => $hCat->id]) }}">
                                            <strong>{{ $hCat->category_name }}</strong>
                                        </a>
                                        @if($hCat->subcategories && $hCat->subcategories->count() > 0)
                                            <ul>
                                                @foreach($hCat->subcategories as $hSub)
                                                    <li>
                                                        <a href="{{ route('front.product.index', ['subcategory' => $hSub->id]) }}">
                                                            {{ $hSub->subcategory_name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    @php
                        $seriesCat = isset($headerCategories) ? $headerCategories->firstWhere('category_name', 'Books by Series') : null;
                    @endphp
                    @if($seriesCat && $seriesCat->subcategories && $seriesCat->subcategories->count() > 0)
                    <li class="menu-item-has-children book-series mega-menu-wrap">
                        <a href="{{ route('front.product.index', ['category' => $seriesCat->id]) }}">Books by Series</a>
                        <ul class="mega-menu">
                            @foreach($seriesCat->subcategories->chunk(6) as $chunkIndex => $subChunk)
                                <li>
                                    <a href="{{ route('front.product.index', ['category' => $seriesCat->id]) }}">
                                        <strong>{{ $chunkIndex == 0 ? 'Core Subjects' : 'Activity & Languages' }}</strong>
                                    </a>
                                    <ul>
                                        @foreach($subChunk as $sSub)
                                            <li>
                                                <a href="{{ route('front.product.index', ['subcategory' => $sSub->id]) }}">
                                                    {{ $sSub->subcategory_name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a href="{{ url('service') }}">Service</a>
                    </li>
                    <li>
                        <a href="{{ url('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
    Popup Search Box
    ============================== -->
    <div class="popup-search-box d-block d-lg-none">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="{{ route('front.product.index') }}" method="GET">
            <input type="text" name="search" class="border-theme" placeholder="What are you looking for" value="{{ request('search') }}">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>
    <!--==============================
        Header Area
    ==============================-->
    <header class="vs-header header-layout1 style2">
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-md-between justify-content-center align-items-center">
                    <div class="col-auto">
                        <div class="header-links d-md-inline d-none">
                            <ul>
                                <li><i class="fa-solid fa-truck-fast"></i>Fastest Delivery In Your City</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-right">

                            <div class="header-social">
                                @if(!empty($siteSettings['facebook_url']))
                                    <a href="{{ $siteSettings['facebook_url'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if(!empty($siteSettings['linkedin_url']) && $siteSettings['linkedin_url'] !== '#')
                                    <a href="{{ $siteSettings['linkedin_url'] }}" target="_blank"><i class="fab fa-linkedin"></i></a>
                                @endif
                                @if(!empty($siteSettings['instagram_url']))
                                    <a href="{{ $siteSettings['instagram_url'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                @endif
                                @if(!empty($siteSettings['youtube_url']))
                                    <a href="{{ $siteSettings['youtube_url'] }}" target="_blank"><i class="fab fa-youtube"></i></a>
                                @endif
                            </div>
                            <div class="user-login">
                                <a href="#sn-signup" data-sn-signup-open aria-label="Sign up" aria-haspopup="dialog" aria-controls="sn-signup"><i class="fa-solid fa-user" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="row justify-content-between align-items-center gx-sm-0">
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="{{ url('/') }}" class="d-none d-lg-block">
                                @if(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                                    <img src="{{ asset($siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo logo-web">
                                @else
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo logo-web">
                                @endif
                            </a>
                            <a href="{{ url('/') }}" class="d-lg-none">
                                @if(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                                    <img src="{{ asset($siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo logo-mobile">
                                @else
                                    <img src="{{ asset('assets/img/logo-mobile.png') }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo logo-mobile">
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-inner">
                            @php
                                $selectedCategoryName = 'Categories';
                                if(request('category') && isset($headerCategories)) {
                                    $matchedCat = $headerCategories->firstWhere('id', request('category'));
                                    if($matchedCat) {
                                        $selectedCategoryName = $matchedCat->category_name;
                                    }
                                }
                            @endphp
                            <form class="header-search d-none d-lg-flex" action="{{ route('front.product.index') }}" method="GET">
                                <div class="search-input-wrap d-flex align-items-center flex-grow-1">
                                    <div class="dropdown search-cat-dropdown">
                                        <div class="search-cat-toggler" id="snSearchCatDropdown" role="button" tabindex="0" aria-expanded="false" title="Filter by Category">
                                            <span class="selected-cat-label">{{ $selectedCategoryName }}</span>
                                        </div>
                                        <input type="hidden" name="category" id="snSearchCategoryInput" value="{{ request('category', '') }}">
                                        <ul class="dropdown-menu search-cat-menu" aria-labelledby="snSearchCatDropdown">
                                            <li>
                                                <a class="dropdown-item search-cat-item {{ empty(request('category')) ? 'active' : '' }}" href="{{ route('front.product.index') }}" data-cat-id="">
                                                    <i class="fa-solid fa-layer-group text-primary me-2"></i> All Categories
                                                </a>
                                            </li>
                                            @if(isset($headerCategories) && $headerCategories->count() > 0)
                                                @foreach($headerCategories as $cat)
                                                    <li>
                                                        <a class="dropdown-item search-cat-item {{ request('category') == $cat->id ? 'active' : '' }}"
                                                           href="{{ route('front.product.index', ['category' => $cat->id]) }}"
                                                           data-cat-id="{{ $cat->id }}">
                                                            @if(!empty($cat->image))
                                                                <img src="{{ asset($cat->image) }}" alt="icon" style="width: 18px; height: 18px; object-fit: contain; margin-right: 8px;" onerror="this.onerror=null;this.src='{{ asset('assets/img/hero/english-group-img.png') }}';">
                                                            @else
                                                                <i class="fa-solid fa-book-open text-primary me-2"></i>
                                                            @endif
                                                            {{ $cat->category_name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <input type="text" name="search" placeholder="Search your Product’s....." value="{{ request('search') }}" autocomplete="off">
                                </div>
                                <button class="search-submit-btn" aria-label="search-button" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                            <div class="header-buttons">
                                <button type="button" class="searchBoxTggler vs-icon d-block d-lg-none" aria-label="search-button">
                                    <i class="fa-brands fa-searchengin"></i>
                                </button>
                                <div class="header-info">
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['phone_primary'] ?? '+919979865666') }}" class="header-info_icon" title="Call Us">
                                        <i class="fas fa-phone"></i>
                                    </a>
                                    <div class="media-body call-info">
                                        <span class="header-info_label">Call Us 24/7</span>
                                        <div class="header-info_link"><a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['phone_primary'] ?? '+919979865666') }}">{{ $siteSettings['phone_primary'] ?? '(+91) 99798-65666' }}</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper header-bottom">
            <div class="sticky-active">
                <div class="container">
                    <div class="menu-top">
                        <div class="row justify-content-between align-items-center gx-sm-0 sn-navigation-row">
                            <div class="col sn-navigation-main">
                                <div class="menu-inner">
                                    <div class="header-category">
                                        <button class="category-toggler" type="button"><i class="fa-solid fa-bars-staggered"></i>Categories</button>
                                        <div class="vs-box-nav">
                                            <ul>
                                                @if(isset($headerCategories) && $headerCategories->count() > 0)
                                                    @foreach($headerCategories as $cat)
                                                        <li>
                                                            <a href="{{ route('front.product.index', ['category' => $cat->id]) }}">
                                                                @if(!empty($cat->image))
                                                                    <img src="{{ asset($cat->image) }}" alt="icon" style="width: 20px; height: 20px; object-fit: contain; margin-right: 8px;" onerror="this.onerror=null;this.src='{{ asset('assets/img/hero/english-group-img.png') }}';">
                                                                @else
                                                                    <i class="fa-solid fa-book-open text-primary" style="margin-right: 8px;"></i>
                                                                @endif
                                                                {{ $cat->category_name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="header-logo">
                                        <a href="{{ url('/') }}">
                                            @if(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                                                <img src="{{ asset($siteSettings['site_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo">
                                            @else
                                                <img src="{{ asset('assets/img/logo.png') }}" alt="{{ $siteSettings['site_name'] ?? 'SMART NOTES PUBLICATION' }}" class="logo">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="menu-area">
                                        <nav class="main-menu menu-style1 d-none d-lg-block">
                                            <ul>
                                                <li>
                                                    <a href="{{ url('/') }}">Home</a>
                                                </li>
                                                <li class="menu-item-has-children">
                                                    <a href="{{ url('about') }}">About Us</a>
                                                    <ul class="sub-menu">
                                                        <li><a href="{{ url('about') }}">About</a></li>
                                                        <li><a href="{{ url('chairman') }}">Chairman's Perspective</a></li>
                                                        <li><a href="{{ url('senior-executive-administrator') }}">From The Admin Desk</a></li>
                                                        <li><a href="{{ url('distributor') }}">Literary Trader</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="{{ url('team') }}">Team</a>
                                                </li>
                                                <li class="menu-item-has-children mega-menu-wrap">
                                                    <a href="{{ route('front.product.index') }}">Educational Books</a>
                                                    <ul class="mega-menu">
                                                        @if(isset($headerCategories) && $headerCategories->count() > 0)
                                                            @foreach($headerCategories->where('category_name', '!=', 'Books by Series') as $hCat)
                                                                <li>
                                                                    <a href="{{ route('front.product.index', ['category' => $hCat->id]) }}">
                                                                        <strong>{{ $hCat->category_name }}</strong>
                                                                    </a>
                                                                    @if($hCat->subcategories && $hCat->subcategories->count() > 0)
                                                                        <ul>
                                                                            @foreach($hCat->subcategories as $hSub)
                                                                                <li>
                                                                                    <a href="{{ route('front.product.index', ['subcategory' => $hSub->id]) }}">
                                                                                        {{ $hSub->subcategory_name }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </li>
                                                @php
                                                    $desktopSeriesCat = isset($headerCategories) ? $headerCategories->firstWhere('category_name', 'Books by Series') : null;
                                                @endphp
                                                @if($desktopSeriesCat && $desktopSeriesCat->subcategories && $desktopSeriesCat->subcategories->count() > 0)
                                                <li class="menu-item-has-children book-series mega-menu-wrap">
                                                    <a href="{{ route('front.product.index', ['category' => $desktopSeriesCat->id]) }}">Books by Series</a>
                                                    <ul class="mega-menu">
                                                        @foreach($desktopSeriesCat->subcategories->chunk(6) as $chunkIndex => $subChunk)
                                                            <li>
                                                                <a href="{{ route('front.product.index', ['category' => $desktopSeriesCat->id]) }}">
                                                                    <strong>{{ $chunkIndex == 0 ? 'Core Subjects' : 'Activity & Languages' }}</strong>
                                                                </a>
                                                                <ul>
                                                                    @foreach($subChunk as $sSub)
                                                                        <li>
                                                                            <a href="{{ route('front.product.index', ['subcategory' => $sSub->id]) }}">
                                                                                {{ $sSub->subcategory_name }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @endif
                                                <li>
                                                    <a href="{{ url('service') }}">Service</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('contact') }}">Contact</a>
                                                </li>
                                            </ul>
                                        </nav>
                                        <button class="vs-menu-toggle d-inline-block d-lg-none"><i class="fal fa-bars"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto sn-navigation-cart">
                                <div class="header-cart">
                                    <a href="{{ route('front.cart') }}" class="vs-icon has-badge" aria-label="View Shopping Cart">
                                        <i class="fa-solid fa-basket-shopping" aria-hidden="true"></i>
                                        <span class="badge headerCartCountBadge" id="headerCartCount">{{ $cartCount ?? 0 }}</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
