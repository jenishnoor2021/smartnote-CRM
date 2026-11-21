<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Service;
use App\Models\Gallery;
use App\Models\Testimonial;
use App\Models\ContactLead;
use App\Models\DistributorApplication;
use App\Models\NewsletterSubscriber;
use App\Services\BotProtectionService;

class FrontController extends Controller
{
    /**
     * Home Page
     */
    public function index()
    {
        $sliders = Slider::where('is_active', 1)->orderBy('sort_order', 'ASC')->get();

        // Main Categories for Explore Categories slider
        $exploreCategories = Category::where('is_active', 1)
            ->where('category_name', '!=', 'CATEGORY1')
            ->withCount('products')
            ->orderBy('id', 'ASC')
            ->get();

        // Trending Products for frontside
        $trendingProducts = Product::where('is_active', 1)
            ->with(['category', 'subcategory'])
            ->orderBy('id', 'ASC')
            ->take(6)
            ->get();

        // English Medium Subjects / Subcategories (Dynamic by Category Name)
        $englishSubjects = SubCategory::whereHas('category', function ($query) {
                $query->where(function ($q) {
                    $q->where('category_name', 'like', '%English%')
                      ->orWhere('category_name', 'like', '%Workbook%');
                })->where('is_active', 1);
            })
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->take(12)
            ->get();

        if ($englishSubjects->isEmpty()) {
            $englishSubjects = SubCategory::whereHas('products', function ($query) {
                    $query->where('medium', 'like', '%English%')->where('is_active', 1);
                })
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->orderBy('id', 'ASC')
                ->take(12)
                ->get();
        }

        // Gujarati Medium Subjects / Subcategories (Dynamic by Category Name)
        $gujaratiSubjects = SubCategory::whereHas('category', function ($query) {
                $query->where('category_name', 'like', '%Gujarati%')
                      ->where('is_active', 1);
            })
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->take(12)
            ->get();

        if ($gujaratiSubjects->isEmpty()) {
            $gujaratiSubjects = SubCategory::whereHas('products', function ($query) {
                    $query->where('medium', 'like', '%Gujarati%')->where('is_active', 1);
                })
                ->where('is_active', 1)
                ->orderBy('sort_order', 'ASC')
                ->orderBy('id', 'ASC')
                ->take(12)
                ->get();
        }

        // Best Selling Series Books Carousel
        $seriesBooks = Product::where('is_active', 1)
            ->with(['category', 'subcategory'])
            ->orderBy('id', 'DESC')
            ->take(10)
            ->get();

        // Featured spotlight book and thumbnails
        $featuredBook = Product::where('is_active', 1)->orderBy('selling_price', 'DESC')->first();
        $sideBooks = Product::where('is_active', 1)
            ->where('id', '!=', $featuredBook ? $featuredBook->id : 0)
            ->take(4)
            ->get();

        $testimonials = Testimonial::where('is_active', 1)->orderBy('sort_order', 'ASC')->get();
        $services = Service::where('is_active', 1)->orderBy('sort_order', 'ASC')->take(6)->get();
        $team = TeamMember::where('is_active', 1)->orderBy('sort_order', 'ASC')->take(4)->get();

        return view('front.index', compact(
            'sliders',
            'exploreCategories',
            'trendingProducts',
            'englishSubjects',
            'gujaratiSubjects',
            'seriesBooks',
            'featuredBook',
            'sideBooks',
            'testimonials',
            'services',
            'team'
        ));
    }

    /**
     * About Us Page
     */
    public function about()
    {
        $team = TeamMember::where('is_active', 1)->orderBy('sort_order', 'ASC')->take(6)->get();
        $testimonials = Testimonial::where('is_active', 1)->orderBy('sort_order', 'ASC')->get();
        $totalBooks = Product::where('is_active', 1)->count();
        $totalTeam = TeamMember::where('is_active', 1)->count();

        return view('front.about', compact('team', 'testimonials', 'totalBooks', 'totalTeam'));
    }

    /**
     * Chairman's Perspective
     */
    public function chairman()
    {
        $chairman = TeamMember::where('is_active', 1)
            ->where(function ($q) {
                $q->where('designation', 'like', '%Chairman%')
                  ->orWhere('id', 1);
            })
            ->first();

        return view('front.chairman', compact('chairman'));
    }

    /**
     * Our Team Page
     */
    public function team()
    {
        $team = TeamMember::where('is_active', 1)->orderBy('sort_order', 'ASC')->get();

        return view('front.team', compact('team'));
    }

    /**
     * Senior Executive Administrator / From The Admin Desk
     */
    public function seniorExecutiveAdministrator()
    {
        $adminDesk = TeamMember::where('is_active', 1)
            ->where(function ($q) {
                $q->where('designation', 'like', '%Administrator%')
                  ->orWhere('id', 2);
            })
            ->first();

        return view('front.senior-executive-administrator', compact('adminDesk'));
    }

    /**
     * Services Page
     */
    public function service()
    {
        $services = Service::where('is_active', 1)->orderBy('sort_order', 'ASC')->get();

        return view('front.service', compact('services'));
    }

    /**
     * Gallery Page
     */
    public function gallery()
    {
        $galleries = Gallery::where('is_active', 1)->orderBy('sort_order', 'ASC')->get();

        return view('front.gallery', compact('galleries'));
    }

    /**
     * Contact Us Page
     */
    public function contact()
    {
        return view('front.contact');
    }

    /**
     * Distributor / Literary Trader Page
     */
    public function distributor()
    {
        return view('front.distributor');
    }

    /**
     * Book Publication Page
     */
    public function bookPublication()
    {
        return view('front.book-publication');
    }

    /**
     * Book Publisher Page
     */
    public function bookPublisher()
    {
        return view('front.book-publisher');
    }

    /**
     * Book Publishing House Page
     */
    public function bookPublishingHouse()
    {
        return view('front.book-publishing-house');
    }

    /**
     * English Medium Pre-Primary Page
     */
    public function engPrePrimary()
    {
        return redirect()->route('front.product.index', ['category' => 9]);
    }

    /**
     * English Workbook Listing Page (Redirects to Common Books Page)
     */
    public function engWorkbook()
    {
        return redirect()->route('front.product.index', ['category' => 13]);
    }

    /**
     * English Workbook Detail Page (Redirects to Common Product Detail Page)
     */
    public function engWorkbookDetail()
    {
        $product = Product::where('is_active', 1)->where('product_name', 'like', '%Workbook%')->first();
        return redirect()->route('front.product.show', $product ? $product->id : 11);
    }

    /**
     * Alphabet Book Page (Redirects to Common Product Detail Page)
     */
    public function pgAlphabetBook()
    {
        $product = Product::where('is_active', 1)->where('product_name', 'like', '%Alphabet%')->first();
        return redirect()->route('front.product.show', $product ? $product->id : 3);
    }

    /**
     * Playgroup Premium Set Page (Redirects to Common Books Page)
     */
    public function playgroupPremium()
    {
        return redirect()->route('front.product.index', ['subcategory' => 5]);
    }

    /**
     * Pre-Primary English Premium Set Page (Redirects to Common Books Page)
     */
    public function prePrimaryEnglishPremiumSet()
    {
        return redirect()->route('front.product.index', ['category' => 9]);
    }

    /**
     * Shopping Cart Page (Disabled - Redirects to Books)
     */
    public function cart()
    {
        return redirect()->route('front.product.index');
    }

    /**
     * Checkout Page (Disabled - Redirects to Books)
     */
    public function checkout()
    {
        return redirect()->route('front.product.index');
    }

    /**
     * Wishlist Page (Disabled - Redirects to Books)
     */
    public function wishlist()
    {
        return redirect()->route('front.product.index');
    }

    /**
     * Handle Contact Form Submission
     */

    /**
     * Refresh anti-bot math verification challenge via AJAX
     */
    public function refreshCaptcha(Request $request)
    {
        $key = $request->input('key', 'default');
        $challenge = BotProtectionService::generateChallenge($key);

        return response()->json([
            'success' => true,
            'question' => $challenge['question'],
            'token' => $challenge['token'],
            'rendered_at' => $challenge['rendered_at'],
        ]);
    }

    public function submitContact(Request $request)
    {
        // Anti-Bot / Anti-Spam Shield
        $botCheck = BotProtectionService::validate($request, 'contact', true);
        if (!$botCheck['success']) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $botCheck['message']], 422);
            }
            return redirect()->back()->withInput()->with('error', $botCheck['message']);
        }
        // Anti-Bot / Anti-Spam Shield
        $botCheck = BotProtectionService::validate($request, 'contact', true);
        if (!$botCheck['success']) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $botCheck['message']], 422);
            }
            return redirect()->back()->withInput()->with('error', $botCheck['message']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withInput()->withErrors($validator);
        }

        ContactLead::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => $request->subject,
            'book_category' => $request->subject,
            'message' => $request->message,
            'source_page' => $request->source_page ?? 'Contact Us',
            'status' => 'new',
        ]);

        $msg = 'Thank you for reaching out! Our team will contact you shortly.';

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Handle Distributor Application Submission
     */
    public function submitDistributor(Request $request)
    {
        // Anti-Bot / Anti-Spam Shield
        $botCheck = BotProtectionService::validate($request, 'distributor', true);
        if (!$botCheck['success']) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $botCheck['message']], 422);
            }
            return redirect()->back()->withInput()->with('error', $botCheck['message']);
        }
        // Anti-Bot / Anti-Spam Shield
        $botCheck = BotProtectionService::validate($request, 'distributor', true);
        if (!$botCheck['success']) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $botCheck['message']], 422);
            }
            return redirect()->back()->withInput()->with('error', $botCheck['message']);
        }
        $validator = Validator::make($request->all(), [
            'trader_name' => 'required|string|max:150',
            'firm_name' => 'nullable|string|max:200',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string',
            'business_type' => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer',
            'gst_number' => 'nullable|string|max:50',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withInput()->withErrors($validator);
        }

        DistributorApplication::create([
            'trader_name' => $request->trader_name,
            'firm_name' => $request->firm_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'business_type' => $request->business_type,
            'experience_years' => $request->experience_years,
            'current_brands' => $request->current_brands,
            'gst_number' => $request->gst_number,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        $msg = 'Your distributor application has been submitted successfully! Our representative will contact you soon.';

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Handle Newsletter Subscription
     */
    public function submitNewsletter(Request $request)
    {
        // Anti-Bot / Anti-Spam Shield (honeypot + time lock + rate limiter)
        $botCheck = BotProtectionService::validate($request, 'newsletter', false);
        if (!$botCheck['success']) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $botCheck['message']], 422);
            }
            return redirect()->back()->with('error', $botCheck['message']);
        }
        // Anti-Bot / Anti-Spam Shield (honeypot + time lock + rate limiter)
        $botCheck = BotProtectionService::validate($request, 'newsletter', false);
        if (!$botCheck['success']) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $botCheck['message']], 422);
            }
            return redirect()->back()->with('error', $botCheck['message']);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:150',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Please enter a valid email address.'], 422);
            }
            return redirect()->back()->withErrors($validator);
        }

        NewsletterSubscriber::updateOrCreate(
            ['email' => strtolower(trim($request->email))],
            ['status' => 'subscribed', 'ip_address' => $request->ip()]
        );

        $msg = 'Thank you for subscribing to Smart Notes Publication newsletter!';

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Fallback dynamic page loader for any future pages added to resources/views/front/
     */
    public function dynamicPage($page)
    {
        $clean = preg_replace('/\.php$/', '', $page);
        $underscore = str_replace('-', '_', $clean);

        if (view()->exists("front.$clean")) {
            return view("front.$clean");
        }

        if (view()->exists("front.$underscore")) {
            return view("front.$underscore");
        }

        abort(404);
    }
}
