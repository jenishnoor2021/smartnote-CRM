<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPartyController;
use App\Http\Controllers\AdminSellerController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminSubCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCouponController;
use App\Http\Controllers\AdminInquiryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\FrontProductController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminSliderController;
use App\Http\Controllers\AdminTeamController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\AdminContactLeadController;
use App\Http\Controllers\AdminDistributorController;
use App\Http\Controllers\AdminNewsletterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Front Clean Website Routes (No .php)
Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/about', [FrontController::class, 'about'])->name('front.about');
Route::get('/chairman', [FrontController::class, 'chairman'])->name('front.chairman');
Route::get('/team', [FrontController::class, 'team'])->name('front.team');
Route::get('/senior-executive-administrator', [FrontController::class, 'seniorExecutiveAdministrator'])->name('front.senior_executive_administrator');
Route::get('/service', [FrontController::class, 'service'])->name('front.service');
Route::get('/services', [FrontController::class, 'service']);
Route::get('/gallery', [FrontController::class, 'gallery'])->name('front.gallery');
Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');
Route::get('/distributor', [FrontController::class, 'distributor'])->name('front.distributor');
Route::get('/book-publication', [FrontController::class, 'bookPublication'])->name('front.book_publication');
Route::get('/book-publisher', [FrontController::class, 'bookPublisher'])->name('front.book_publisher');
Route::get('/book-publishing-house', [FrontController::class, 'bookPublishingHouse'])->name('front.book_publishing_house');
Route::get('/eng-pre-primary', [FrontController::class, 'engPrePrimary'])->name('front.eng_pre_primary');
Route::get('/eng-workbook', [FrontController::class, 'engWorkbook'])->name('front.eng_workbook');
Route::get('/eng-workbook-detail', [FrontController::class, 'engWorkbookDetail'])->name('front.eng_workbook_detail');
Route::get('/pg-alphabet-book', [FrontController::class, 'pgAlphabetBook'])->name('front.pg_alphabet_book');
Route::get('/playgroup-premium', [FrontController::class, 'playgroupPremium'])->name('front.playgroup_premium');
Route::get('/pre-primary-english-premium-set', [FrontController::class, 'prePrimaryEnglishPremiumSet'])->name('front.pre_primary_english_premium_set');
Route::get('/cart', [FrontProductController::class, 'cart'])->name('front.cart');
Route::post('/cart/add', [FrontProductController::class, 'addToCart'])->name('front.cart.add');
Route::post('/cart/update', [FrontProductController::class, 'updateCart'])->name('front.cart.update');
Route::match(['delete', 'post'], '/cart/remove/{id}', [FrontProductController::class, 'removeFromCart'])->name('front.cart.remove');
Route::get('/checkout', [FrontProductController::class, 'checkout'])->name('front.checkout');
Route::post('/checkout/submit', [FrontProductController::class, 'submitCheckout'])->name('front.checkout.submit');
Route::get('/order/success/{order_no}', [FrontProductController::class, 'orderSuccess'])->name('front.order.success');
Route::get('/order/{order_no}/pdf', [FrontProductController::class, 'generateOrderPdf'])->name('front.order.pdf');
Route::get('/wishlist', [FrontController::class, 'wishlist'])->name('front.wishlist');

// Clean dynamic page loader for any future pages
Route::get('/page/{page}', [FrontController::class, 'dynamicPage'])->name('front.dynamic_page');

// Frontside Storefront / CRM Order & Inquiries
Route::get('/book/{id?}', [FrontProductController::class, 'show'])->name('front.product.show');
Route::get('/books', [FrontProductController::class, 'index'])->name('front.product.index');
Route::post('/front/inquiry/submit', [FrontProductController::class, 'submitInquiry'])->name('front.inquiry.submit');
Route::post('/front/order/submit', [FrontProductController::class, 'submitOrder'])->name('front.order.submit');
Route::post('/contact/submit', [FrontController::class, 'submitContact'])->name('front.contact.submit');
Route::post('/distributor/submit', [FrontController::class, 'submitDistributor'])->name('front.distributor.submit');
Route::post('/newsletter/subscribe', [FrontController::class, 'submitNewsletter'])->name('front.newsletter.subscribe');
Route::get('/refresh-captcha', [FrontController::class, 'refreshCaptcha'])->name('front.refresh_captcha');
Route::get('/payment/callback', [FrontProductController::class, 'paymentCallback'])->name('front.payment_callback');
Route::get('/payment/mock/{order_no}', [FrontProductController::class, 'mockPayment'])->name('front.payment_mock');

// Authentication Routes
Route::get('/admin/login', function () {
    return response()
        ->view('auth.login')
        ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
})->name('admin.login');

Route::get('/login', function () {
    return redirect()->route('admin.login');
});

Route::post('/login', [AdminController::class, 'login'])->name('login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'usersession']], function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('admin/party', [AdminPartyController::class, 'index'])->name('admin.party.index');
    Route::get('admin/party/create', [AdminPartyController::class, 'create'])->name('admin.party.create');
    Route::post('admin/party/store', [AdminPartyController::class, 'store'])->name('admin.party.store');
    Route::get('admin/party/edit/{id}', [AdminPartyController::class, 'edit'])->name('admin.party.edit');
    Route::patch('admin/party/update/{id}', [AdminPartyController::class, 'update'])->name('admin.party.update');
    Route::delete('admin/party/destroy/{id}', [AdminPartyController::class, 'destroy'])->name('admin.party.destroy');
    Route::post('admin/party/delete-multiple', [AdminPartyController::class, 'deleteMultiple'])->name('delete.multiple');
    Route::post('admin/party/delete_selected', [AdminPartyController::class, 'deleteMultiple']);
    Route::post('admin/party/update_status', [AdminPartyController::class, 'update_status'])->name('update_status');

    // Superadmin Only - Seller Management, Profile, Category & SubCategory Routes
    Route::group(['middleware' => ['role:superadmin']], function () {
        Route::get('/profile/{id}', [AdminController::class, 'profiledit'])->name('profile.edit');
        Route::patch('/profile/update', [AdminController::class, 'profileUpdate'])->name('profile.update');

        // Seller Management Routes
        Route::get('admin/seller', [AdminSellerController::class, 'index'])->name('admin.seller.index');
        Route::get('admin/seller/create', [AdminSellerController::class, 'create'])->name('admin.seller.create');
        Route::post('admin/seller/store', [AdminSellerController::class, 'store'])->name('admin.seller.store');
        Route::get('admin/seller/edit/{id}', [AdminSellerController::class, 'edit'])->name('admin.seller.edit');
        Route::patch('admin/seller/update/{id}', [AdminSellerController::class, 'update'])->name('admin.seller.update');
        Route::delete('admin/seller/destroy/{id}', [AdminSellerController::class, 'destroy'])->name('admin.seller.destroy');
        Route::post('admin/seller/delete-multiple', [AdminSellerController::class, 'deleteMultiple'])->name('admin.seller.delete.multiple');
        Route::post('admin/seller/update_status', [AdminSellerController::class, 'update_status'])->name('admin.seller.update_status');

        // Category Routes
        Route::get('admin/category', [AdminCategoryController::class, 'index'])->name('admin.category.index');
        Route::get('admin/category/create', [AdminCategoryController::class, 'create'])->name('admin.category.create');
        Route::post('admin/category/store', [AdminCategoryController::class, 'store'])->name('admin.category.store');
        Route::get('admin/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
        Route::patch('admin/category/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('admin/category/destroy/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.category.destroy');
        Route::post('admin/category/delete-multiple', [AdminCategoryController::class, 'deleteMultiple'])->name('admin.category.delete.multiple');
        Route::post('admin/category/delete_selected', [AdminCategoryController::class, 'deleteMultiple']);
        Route::post('admin/category/update_status', [AdminCategoryController::class, 'update_status'])->name('admin.category.update_status');
        Route::post('admin/category/reorder', [AdminCategoryController::class, 'reorder'])->name('admin.category.reorder');

        // Sub Category Routes
        Route::get('admin/subcategory', [AdminSubCategoryController::class, 'index'])->name('admin.subcategory.index');
        Route::get('admin/subcategory/create', [AdminSubCategoryController::class, 'create'])->name('admin.subcategory.create');
        Route::post('admin/subcategory/store', [AdminSubCategoryController::class, 'store'])->name('admin.subcategory.store');
        Route::get('admin/subcategory/edit/{id}', [AdminSubCategoryController::class, 'edit'])->name('admin.subcategory.edit');
        Route::patch('admin/subcategory/update/{id}', [AdminSubCategoryController::class, 'update'])->name('admin.subcategory.update');
        Route::delete('admin/subcategory/destroy/{id}', [AdminSubCategoryController::class, 'destroy'])->name('admin.subcategory.destroy');
        Route::post('admin/subcategory/delete-multiple', [AdminSubCategoryController::class, 'deleteMultiple'])->name('admin.subcategory.delete.multiple');
        Route::post('admin/subcategory/delete_selected', [AdminSubCategoryController::class, 'deleteMultiple']);
        Route::post('admin/subcategory/update_status', [AdminSubCategoryController::class, 'update_status'])->name('admin.subcategory.update_status');
        Route::post('admin/subcategory/reorder', [AdminSubCategoryController::class, 'reorder'])->name('admin.subcategory.reorder');

        // Product Routes
        Route::get('admin/product', [AdminProductController::class, 'index'])->name('admin.product.index');
        Route::get('admin/product/create', [AdminProductController::class, 'create'])->name('admin.product.create');
        Route::get('admin/product/get-subcategories', [AdminProductController::class, 'getSubcategories'])->name('admin.product.get_subcategories');
        Route::post('admin/product/store', [AdminProductController::class, 'store'])->name('admin.product.store');
        Route::get('admin/product/edit/{id}', [AdminProductController::class, 'edit'])->name('admin.product.edit');
        Route::patch('admin/product/update/{id}', [AdminProductController::class, 'update'])->name('admin.product.update');
        Route::delete('admin/product/destroy/{id}', [AdminProductController::class, 'destroy'])->name('admin.product.destroy');
        Route::delete('admin/product/delete-gallery-image/{id}', [AdminProductController::class, 'deleteGalleryImage'])->name('admin.product.delete_gallery_image');
        Route::post('admin/product/delete-multiple', [AdminProductController::class, 'deleteMultiple'])->name('admin.product.delete.multiple');
        Route::post('admin/product/delete_selected', [AdminProductController::class, 'deleteMultiple']);
        Route::post('admin/product/update_status', [AdminProductController::class, 'update_status'])->name('admin.product.update_status');

        // Coupon Routes (Superadmin Only)
        Route::get('admin/coupon', [AdminCouponController::class, 'index'])->name('admin.coupon.index');
        Route::get('admin/coupon/create', [AdminCouponController::class, 'create'])->name('admin.coupon.create');
        Route::post('admin/coupon/store', [AdminCouponController::class, 'store'])->name('admin.coupon.store');
        Route::get('admin/coupon/edit/{id}', [AdminCouponController::class, 'edit'])->name('admin.coupon.edit');
        Route::patch('admin/coupon/update/{id}', [AdminCouponController::class, 'update'])->name('admin.coupon.update');
        Route::delete('admin/coupon/destroy/{id}', [AdminCouponController::class, 'destroy'])->name('admin.coupon.destroy');
        Route::post('admin/coupon/delete-multiple', [AdminCouponController::class, 'deleteMultiple'])->name('admin.coupon.delete.multiple');
        Route::post('admin/coupon/update_status', [AdminCouponController::class, 'update_status'])->name('admin.coupon.update_status');

        // Website Settings (Superadmin Only)
        Route::get('admin/setting', [AdminSettingController::class, 'index'])->name('admin.setting.index');
        Route::patch('admin/setting/update', [AdminSettingController::class, 'update'])->name('admin.setting.update');

        // Home Sliders (Superadmin Only)
        Route::get('admin/slider', [AdminSliderController::class, 'index'])->name('admin.slider.index');
        Route::get('admin/slider/create', [AdminSliderController::class, 'create'])->name('admin.slider.create');
        Route::post('admin/slider/store', [AdminSliderController::class, 'store'])->name('admin.slider.store');
        Route::get('admin/slider/edit/{id}', [AdminSliderController::class, 'edit'])->name('admin.slider.edit');
        Route::patch('admin/slider/update/{id}', [AdminSliderController::class, 'update'])->name('admin.slider.update');
        Route::match(['delete', 'post'], 'admin/slider/destroy/{id}', [AdminSliderController::class, 'destroy'])->name('admin.slider.destroy');
        Route::post('admin/slider/delete-multiple', [AdminSliderController::class, 'deleteMultiple'])->name('admin.slider.delete_multiple');
        Route::post('admin/slider/delete_selected', [AdminSliderController::class, 'deleteMultiple'])->name('admin.slider.delete.multiple');
        Route::post('admin/slider/update_status', [AdminSliderController::class, 'update_status'])->name('admin.slider.update_status');
        Route::post('admin/slider/reorder', [AdminSliderController::class, 'reorder'])->name('admin.slider.reorder');

        // Team Members (Superadmin Only)
        Route::get('admin/team', [AdminTeamController::class, 'index'])->name('admin.team.index');
        Route::get('admin/team/create', [AdminTeamController::class, 'create'])->name('admin.team.create');
        Route::post('admin/team/store', [AdminTeamController::class, 'store'])->name('admin.team.store');
        Route::get('admin/team/edit/{id}', [AdminTeamController::class, 'edit'])->name('admin.team.edit');
        Route::patch('admin/team/update/{id}', [AdminTeamController::class, 'update'])->name('admin.team.update');
        Route::match(['delete', 'post'], 'admin/team/destroy/{id}', [AdminTeamController::class, 'destroy'])->name('admin.team.destroy');
        Route::post('admin/team/delete-multiple', [AdminTeamController::class, 'deleteMultiple'])->name('admin.team.delete_multiple');
        Route::post('admin/team/delete_selected', [AdminTeamController::class, 'deleteMultiple'])->name('admin.team.delete.multiple');
        Route::post('admin/team/update_status', [AdminTeamController::class, 'update_status'])->name('admin.team.update_status');
        Route::post('admin/team/reorder', [AdminTeamController::class, 'reorder'])->name('admin.team.reorder');

        // Gallery (Superadmin Only)
        Route::get('admin/gallery', [AdminGalleryController::class, 'index'])->name('admin.gallery.index');
        Route::get('admin/gallery/create', [AdminGalleryController::class, 'create'])->name('admin.gallery.create');
        Route::post('admin/gallery/store', [AdminGalleryController::class, 'store'])->name('admin.gallery.store');
        Route::get('admin/gallery/edit/{id}', [AdminGalleryController::class, 'edit'])->name('admin.gallery.edit');
        Route::patch('admin/gallery/update/{id}', [AdminGalleryController::class, 'update'])->name('admin.gallery.update');
        Route::match(['delete', 'post'], 'admin/gallery/destroy/{id}', [AdminGalleryController::class, 'destroy'])->name('admin.gallery.destroy');
        Route::post('admin/gallery/delete-multiple', [AdminGalleryController::class, 'deleteMultiple'])->name('admin.gallery.delete_multiple');
        Route::post('admin/gallery/delete_selected', [AdminGalleryController::class, 'deleteMultiple'])->name('admin.gallery.delete.multiple');
        Route::post('admin/gallery/update_status', [AdminGalleryController::class, 'update_status'])->name('admin.gallery.update_status');
        Route::post('admin/gallery/reorder', [AdminGalleryController::class, 'reorder'])->name('admin.gallery.reorder');

        // Services (Superadmin Only)
        Route::get('admin/service', [AdminServiceController::class, 'index'])->name('admin.service.index');
        Route::get('admin/service/create', [AdminServiceController::class, 'create'])->name('admin.service.create');
        Route::post('admin/service/store', [AdminServiceController::class, 'store'])->name('admin.service.store');
        Route::get('admin/service/edit/{id}', [AdminServiceController::class, 'edit'])->name('admin.service.edit');
        Route::patch('admin/service/update/{id}', [AdminServiceController::class, 'update'])->name('admin.service.update');
        Route::match(['delete', 'post'], 'admin/service/destroy/{id}', [AdminServiceController::class, 'destroy'])->name('admin.service.destroy');
        Route::post('admin/service/delete-multiple', [AdminServiceController::class, 'deleteMultiple'])->name('admin.service.delete_multiple');
        Route::post('admin/service/delete_selected', [AdminServiceController::class, 'deleteMultiple'])->name('admin.service.delete.multiple');
        Route::post('admin/service/update_status', [AdminServiceController::class, 'update_status'])->name('admin.service.update_status');
        Route::post('admin/service/reorder', [AdminServiceController::class, 'reorder'])->name('admin.service.reorder');

        // Testimonials / Reviews (Superadmin Only)
        Route::get('admin/testimonial', [AdminTestimonialController::class, 'index'])->name('admin.testimonial.index');
        Route::get('admin/testimonial/create', [AdminTestimonialController::class, 'create'])->name('admin.testimonial.create');
        Route::post('admin/testimonial/store', [AdminTestimonialController::class, 'store'])->name('admin.testimonial.store');
        Route::get('admin/testimonial/edit/{id}', [AdminTestimonialController::class, 'edit'])->name('admin.testimonial.edit');
        Route::patch('admin/testimonial/update/{id}', [AdminTestimonialController::class, 'update'])->name('admin.testimonial.update');
        Route::match(['delete', 'post'], 'admin/testimonial/destroy/{id}', [AdminTestimonialController::class, 'destroy'])->name('admin.testimonial.destroy');
        Route::post('admin/testimonial/delete-multiple', [AdminTestimonialController::class, 'deleteMultiple'])->name('admin.testimonial.delete_multiple');
        Route::post('admin/testimonial/delete_selected', [AdminTestimonialController::class, 'deleteMultiple'])->name('admin.testimonial.delete.multiple');
        Route::post('admin/testimonial/update_status', [AdminTestimonialController::class, 'update_status'])->name('admin.testimonial.update_status');
        Route::post('admin/testimonial/reorder', [AdminTestimonialController::class, 'reorder'])->name('admin.testimonial.reorder');

        // Contact Leads & Inquiries (Superadmin Only)
        Route::get('admin/contact-lead', [AdminContactLeadController::class, 'index'])->name('admin.contact-lead.index');
        Route::get('admin/contact-lead/{id}', [AdminContactLeadController::class, 'show'])->name('admin.contact-lead.show');
        Route::patch('admin/contact-lead/{id}/status', [AdminContactLeadController::class, 'updateStatus'])->name('admin.contact-lead.update_status');
        Route::match(['delete', 'post'], 'admin/contact-lead/{id}', [AdminContactLeadController::class, 'destroy'])->name('admin.contact-lead.destroy');
        Route::post('admin/contact-lead/delete-multiple', [AdminContactLeadController::class, 'deleteMultiple'])->name('admin.contact-lead.delete_multiple');

        // Distributor Applications (Superadmin Only)
        Route::get('admin/distributor-application', [AdminDistributorController::class, 'index'])->name('admin.distributor.index');
        Route::get('admin/distributor-application/{id}', [AdminDistributorController::class, 'show'])->name('admin.distributor.show');
        Route::patch('admin/distributor-application/{id}/status', [AdminDistributorController::class, 'updateStatus'])->name('admin.distributor.update_status');
        Route::match(['delete', 'post'], 'admin/distributor-application/{id}', [AdminDistributorController::class, 'destroy'])->name('admin.distributor.destroy');
        Route::post('admin/distributor-application/delete-multiple', [AdminDistributorController::class, 'deleteMultiple'])->name('admin.distributor.delete_multiple');

        // Newsletter Subscribers (Superadmin Only)
        Route::get('admin/newsletter', [AdminNewsletterController::class, 'index'])->name('admin.newsletter.index');
        Route::match(['delete', 'post'], 'admin/newsletter/{id}', [AdminNewsletterController::class, 'destroy'])->name('admin.newsletter.destroy');
        Route::post('admin/newsletter/delete-multiple', [AdminNewsletterController::class, 'deleteMultiple'])->name('admin.newsletter.delete_multiple');
        Route::get('admin/newsletter/export', [AdminNewsletterController::class, 'export'])->name('admin.newsletter.export');
    });

    // Inquiries Routes (Both Superadmin & Seller)
    Route::get('admin/inquiry', [AdminInquiryController::class, 'index'])->name('admin.inquiry.index');
    Route::get('admin/inquiry/create', [AdminInquiryController::class, 'create'])->name('admin.inquiry.create');
    Route::post('admin/inquiry/store', [AdminInquiryController::class, 'store'])->name('admin.inquiry.store');
    Route::get('admin/inquiry/show/{id}', [AdminInquiryController::class, 'show'])->name('admin.inquiry.show');
    Route::get('admin/inquiry/{id}/quotation-pdf', [AdminInquiryController::class, 'downloadQuotationPdf'])->name('admin.inquiry.quotation.pdf');
    Route::get('admin/inquiry/edit/{id}', [AdminInquiryController::class, 'edit'])->name('admin.inquiry.edit');
    Route::patch('admin/inquiry/update/{id}', [AdminInquiryController::class, 'update'])->name('admin.inquiry.update');
    Route::delete('admin/inquiry/destroy/{id}', [AdminInquiryController::class, 'destroy'])->name('admin.inquiry.destroy');
    Route::post('admin/inquiry/bulk-assign', [AdminInquiryController::class, 'bulkAssign'])->name('admin.inquiry.bulk_assign');
    Route::post('admin/inquiry/{id}/add-note', [AdminInquiryController::class, 'addNote'])->name('admin.inquiry.add_note');
    Route::post('admin/inquiry/{id}/update-status', [AdminInquiryController::class, 'updateStatus'])->name('admin.inquiry.update_status');
    Route::post('admin/inquiry/validate-coupon', [AdminInquiryController::class, 'validateCoupon'])->name('admin.inquiry.validate_coupon');
    Route::post('admin/inquiry/{id}/merge', [AdminInquiryController::class, 'mergeInquiries'])->name('admin.inquiry.merge');
    Route::post('admin/inquiry/{id}/convert-order', [AdminInquiryController::class, 'convertToOrder'])->name('admin.inquiry.convert_order');

    // Orders Routes (Both Superadmin & Seller)
    Route::get('admin/order', [AdminOrderController::class, 'index'])->name('admin.order.index');
    Route::get('admin/order/show/{id}', [AdminOrderController::class, 'show'])->name('admin.order.show');
    Route::get('admin/order/{id}/pdf', [AdminOrderController::class, 'generateOrderPdf'])->name('admin.order.pdf');
    Route::patch('admin/order/update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.order.update_status');
    Route::post('admin/order/bulk-assign', [AdminOrderController::class, 'bulkAssign'])->name('admin.order.bulk_assign');
    Route::post('admin/order/{id}/apply-coupon', [AdminOrderController::class, 'applyCoupon'])->name('admin.order.apply_coupon');
    Route::delete('admin/order/{id}/remove-coupon', [AdminOrderController::class, 'removeCoupon'])->name('admin.order.remove_coupon');
    Route::post('admin/order/{id}/generate-payment-link', [AdminOrderController::class, 'generatePaymentLink'])->name('admin.order.generate_payment_link');
    Route::get('admin/order/{id}/check-payment-status', [AdminOrderController::class, 'checkPaymentStatus'])->name('admin.order.check_payment_status');
});

// Clear Cache facade value:
Route::get('/admin/clear-cache', function () {
    Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

// Reoptimized class loader:
Route::get('/admin/optimize', function () {
    Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

// Route cache:
Route::get('/admin/route-cache', function () {
    Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

// Clear Route cache:
Route::get('/admin/route-clear', function () {
    Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

// Clear View cache:
Route::get('/admin/view-clear', function () {
    Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

// Clear Config cache:
Route::get('/admin/config-cache', function () {
    Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
