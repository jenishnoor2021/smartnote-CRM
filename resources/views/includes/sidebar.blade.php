<div class="sidebar sidebar-main">
    <div class="sidebar-content">
        <!-- User menu -->
        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <div class="media-body">
                        <span class="media-heading text-semibold">
                            {{ __('Welcome') }}, {{ Auth::user()->name ?? 'User' }}
                            <a style="color: white;" href="/logout"
                                align="padding-right"><i class="icon-switch2" data-popup="tooltip"
                                    data-placement="top" title="{{ __('Logout') }}"></i></a>
                        </span>
                        <div class="text-size-mini text-muted" style="margin-top: 5px;">
                            <span class="label {{ (Auth::user() && Auth::user()->isSuperAdmin()) ? 'label-danger' : 'label-success' }}" style="font-size: 10px; padding: 2px 6px;">
                                {{ (Auth::user() && Auth::user()->isSuperAdmin()) ? 'Super Admin' : 'Seller' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /User menu -->
        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">
                    <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}">
                        <a href="/admin/dashboard"><i class="icon-home4"></i>
                            <span>{{ __('Dashboard') }}</span></a>
                    </li>
                    @if(Auth::check() && Auth::user()->isSuperAdmin())
                    <li class="{{ (request()->segment(2) == 'seller') ? 'active' : '' }}">
                        <a href="{{ route('admin.seller.index') }}">
                            <i class="icon-users4"></i>
                            <span>{{ __('Sellers') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'category') ? 'active' : '' }}">
                        <a href="{{ route('admin.category.index') }}">
                            <i class="icon-grid"></i>
                            <span>{{ __('Category') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'subcategory') ? 'active' : '' }}">
                        <a href="{{ route('admin.subcategory.index') }}">
                            <i class="icon-grid5"></i>
                            <span>{{ __('Sub Category') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'product') ? 'active' : '' }}">
                        <a href="{{ route('admin.product.index') }}">
                            <i class="icon-books"></i>
                            <span>{{ __('Products') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'coupon') ? 'active' : '' }}">
                        <a href="{{ route('admin.coupon.index') }}">
                            <i class="icon-price-tag2"></i>
                            <span>{{ __('Discount Coupons') }}</span>
                        </a>
                    </li>
                    @endif

                    <li class="{{ (request()->segment(2) == 'inquiry') ? 'active' : '' }}">
                        <a href="{{ route('admin.inquiry.index') }}">
                            <i class="icon-bubbles4"></i>
                            <span>{{ __('Product Inquiries') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'order') ? 'active' : '' }}">
                        <a href="{{ route('admin.order.index') }}">
                            <i class="icon-cart5"></i>
                            <span>{{ __('Orders') }}</span>
                        </a>
                    </li>

                    @if(Auth::check() && Auth::user()->isSuperAdmin())
                    <li class="navigation-header"><span>{{ __('Website CMS & Inquiries') }}</span> <i class="icon-menu" title="Website CMS"></i></li>
                    <li class="{{ (request()->segment(2) == 'setting') ? 'active' : '' }}">
                        <a href="{{ route('admin.setting.index') }}">
                            <i class="icon-gear"></i>
                            <span>{{ __('Website Settings') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'slider') ? 'active' : '' }}">
                        <a href="{{ route('admin.slider.index') }}">
                            <i class="icon-images2"></i>
                            <span>{{ __('Home Sliders') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'team') ? 'active' : '' }}">
                        <a href="{{ route('admin.team.index') }}">
                            <i class="icon-users2"></i>
                            <span>{{ __('Team Members') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'service') ? 'active' : '' }}">
                        <a href="{{ route('admin.service.index') }}">
                            <i class="icon-briefcase"></i>
                            <span>{{ __('Services') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'gallery') ? 'active' : '' }}">
                        <a href="{{ route('admin.gallery.index') }}">
                            <i class="icon-image3"></i>
                            <span>{{ __('Photo Gallery') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'testimonial') ? 'active' : '' }}">
                        <a href="{{ route('admin.testimonial.index') }}">
                            <i class="icon-star-full2"></i>
                            <span>{{ __('Reviews / Testimonials') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'contact-lead') ? 'active' : '' }}">
                        <a href="{{ route('admin.contact-lead.index') }}">
                            <i class="icon-envelop5"></i>
                            <span>{{ __('Contact Leads') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'distributor-application') ? 'active' : '' }}">
                        <a href="{{ route('admin.distributor.index') }}">
                            <i class="icon-address-book"></i>
                            <span>{{ __('Distributor Apps') }}</span>
                        </a>
                    </li>
                    <li class="{{ (request()->segment(2) == 'newsletter') ? 'active' : '' }}">
                        <a href="{{ route('admin.newsletter.index') }}">
                            <i class="icon-mail-read"></i>
                            <span>{{ __('Newsletter Subscribers') }}</span>
                        </a>
                    </li>
                    @endif
                    <!-- <li class="{{ (request()->segment(2) == 'party') ? 'active' : '' }}">
                        <a href="/admin/party">
                            <i class="icon-menu6"></i>
                            <span>{{ __('Party') }}</span>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
        <!-- /Main navigation -->
    </div>
</div>
