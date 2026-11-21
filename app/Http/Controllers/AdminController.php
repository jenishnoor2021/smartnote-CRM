<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\ContactLead;
use App\Models\DistributorApplication;
use App\Models\NewsletterSubscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login(Request $req)
    {
        $user = User::where(['username' => $req->username])->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return redirect()->back()->with('alert', 'Username or password does not matched');
        } else {
            if (!$user->is_active) {
                return redirect()->back()->with('alert', 'Your account has been deactivated. Please contact admin.');
            }
            Auth::loginUsingId($user->id);
            $req->session()->put('user', $user);
            return redirect('/admin/dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $isSuperAdmin = $user && $user->isSuperAdmin();

        // Orders base query (SuperAdmin sees all, Seller sees assigned only)
        $orderQuery = Order::query();
        if (!$isSuperAdmin) {
            $orderQuery->where('seller_id', $user->id);
        }

        // Inquiries base query (SuperAdmin sees all, Seller sees assigned only)
        $inquiryQuery = Inquiry::query();
        if (!$isSuperAdmin) {
            $inquiryQuery->where('assigned_to', $user->id);
        }

        // Orders metrics
        $totalOrders = (clone $orderQuery)->count();
        $ordersToday = (clone $orderQuery)->whereDate('created_at', Carbon::today())->count();
        $totalRevenue = (clone $orderQuery)->where('payment_status', 'paid')->sum('total_amount');
        $totalOrderValue = (clone $orderQuery)->whereNotIn('order_status', ['cancelled'])->sum('total_amount');

        $orderStatusCounts = [
            'pending' => (clone $orderQuery)->where('order_status', 'pending')->count(),
            'confirmed' => (clone $orderQuery)->where('order_status', 'confirmed')->count(),
            'processing' => (clone $orderQuery)->where('order_status', 'processing')->count(),
            'delivered' => (clone $orderQuery)->where('order_status', 'delivered')->count(),
            'cancelled' => (clone $orderQuery)->where('order_status', 'cancelled')->count(),
        ];

        // Inquiries metrics
        $totalInquiries = (clone $inquiryQuery)->count();
        $inquiriesToday = (clone $inquiryQuery)->whereDate('created_at', Carbon::today())->count();

        $inquiryStatusCounts = [
            'pending' => (clone $inquiryQuery)->where('status', 'pending')->count(),
            'contacted' => (clone $inquiryQuery)->where('status', 'contacted')->count(),
            'confirmed' => (clone $inquiryQuery)->where('status', 'confirmed')->count(),
            'converted' => (clone $inquiryQuery)->where('status', 'converted')->count(),
            'cancelled' => (clone $inquiryQuery)->where('status', 'cancelled')->count(),
        ];

        // Catalog Stats (Products, Categories, Subcategories, Coupons)
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', 1)->count();
        $lowStockProducts = Product::where('is_active', 1)->where('stock_quantity', '<=', 10)->count();
        $outOfStockProducts = Product::where('is_active', 1)->where('is_in_stock', 0)->count();
        $totalCategories = Category::where('is_active', 1)->count();
        $totalSubcategories = SubCategory::where('is_active', 1)->count();
        $activeCoupons = Coupon::where('is_active', 1)->count();

        // Website Leads & Applications (SuperAdmin)
        $totalSellers = User::where('role', 'seller')->where('is_active', 1)->count();
        $totalContactLeads = ContactLead::count();
        $newContactLeads = ContactLead::where('status', 'new')->count();
        $totalDistributorApps = DistributorApplication::count();
        $pendingDistributorApps = DistributorApplication::where('status', 'pending')->count();
        $totalNewsletterSubs = NewsletterSubscriber::count();

        // Recent Orders (with items and seller)
        $recentOrders = (clone $orderQuery)
            ->with(['seller', 'items'])
            ->orderBy('created_at', 'DESC')
            ->take(6)
            ->get();

        // Recent Inquiries (with assigned seller)
        $recentInquiries = (clone $inquiryQuery)
            ->with(['assignedSeller'])
            ->orderBy('created_at', 'DESC')
            ->take(6)
            ->get();

        // Recent Website Leads (SuperAdmin only)
        $recentLeads = $isSuperAdmin ? ContactLead::orderBy('created_at', 'DESC')->take(5)->get() : collect();

        // Recent Distributor Applications (SuperAdmin only)
        $recentDistributorApps = $isSuperAdmin ? DistributorApplication::orderBy('created_at', 'DESC')->take(5)->get() : collect();

        // Stock alerts list
        $stockAlertProducts = Product::where('is_active', 1)
            ->where(function ($q) {
                $q->where('stock_quantity', '<=', 10)->orWhere('is_in_stock', 0);
            })
            ->with('category')
            ->orderBy('stock_quantity', 'ASC')
            ->take(5)
            ->get();

        return view('admin.index', compact(
            'isSuperAdmin',
            'totalOrders',
            'ordersToday',
            'totalRevenue',
            'totalOrderValue',
            'orderStatusCounts',
            'totalInquiries',
            'inquiriesToday',
            'inquiryStatusCounts',
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalCategories',
            'totalSubcategories',
            'activeCoupons',
            'totalSellers',
            'totalContactLeads',
            'newContactLeads',
            'totalDistributorApps',
            'pendingDistributorApps',
            'totalNewsletterSubs',
            'recentOrders',
            'recentInquiries',
            'recentLeads',
            'recentDistributorApps',
            'stockAlertProducts'
        ));
    }

    public function profiledit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.profile.edit', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $sessionUser = Session::get('user');

        if (!$sessionUser) {
            return redirect()->back()->with('error', 'User session not found.');
        }

        $user = User::find($sessionUser->id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Check current password
        if (!(Hash::check($request->get('current_password'), $user->password))) {
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        // Change Password
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        // Update session user
        Session::put('user', $user);

        return redirect()->back()->with("success", "Password changed successfully !");
    }
}
