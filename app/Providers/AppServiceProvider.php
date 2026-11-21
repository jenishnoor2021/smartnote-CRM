<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use App\Models\SiteSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.bootstrap-3');
        Paginator::defaultSimpleView('vendor.pagination.bootstrap-3');

        if (config('app.env') === 'production' || (!empty($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'invent-infotech.com')) || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
            URL::forceScheme('https');
        }
        try {
            View::composer('*', function ($view) {
                // 1. Site Settings
                $settings = Schema::hasTable('site_settings')
                    ? SiteSetting::pluck('value', 'key')->toArray()
                    : [];

                // 2. Active Categories with Active Subcategories (Ordered by sort_order)
                $categories = collect();
                if (Schema::hasTable('categories')) {
                    $categories = \App\Models\Category::where('is_active', 1)
                        ->with(['subcategories' => function ($q) {
                            $q->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC');
                        }])
                        ->orderBy('sort_order', 'ASC')
                        ->orderBy('id', 'ASC')
                        ->get();
                }

                // 3. Featured / Recent Products
                $products = collect();
                if (Schema::hasTable('products')) {
                    $products = \App\Models\Product::where('is_active', 1)
                        ->with(['category', 'subcategory'])
                        ->orderBy('id', 'DESC')
                        ->take(6)
                        ->get();
                }

                // 4. Cart Info
                $cart = session()->get('cart', []);
                $cartCount = is_array($cart) ? array_sum(array_column($cart, 'quantity')) : 0;

                $view->with([
                    'siteSettings'     => $settings,
                    'headerCategories' => $categories,
                    'headerProducts'   => $products,
                    'cartCount'        => $cartCount,
                    'cartItems'        => $cart,
                ]);
            });
        } catch (\Throwable $e) {
            // Fallback during migrations or CLI commands
        }
    }
}
