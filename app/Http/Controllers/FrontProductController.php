<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\InquiryItem;
use App\Models\InquiryNote;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Services\BotProtectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FrontProductController extends Controller
{
    /**
     * Display a product page (styled like app.invent-infotech.com/pg-alphabet-book.php).
     *
     * @param  int|null  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if ($id) {
            $product = Product::where('is_active', 1)
                ->with(['category', 'subcategory', 'images'])
                ->findOrFail($id);
        } else {
            // Default to first active product (e.g. Alphabet Book)
            $product = Product::where('is_active', 1)
                ->with(['category', 'subcategory', 'images'])
                ->firstOrFail();
        }

        // Other books in database for navigation / related section
        $otherProducts = Product::where('is_active', 1)
            ->where('id', '!=', $product->id)
            ->with(['category', 'subcategory'])
            ->get();

        return view('front.product.show', compact('product', 'otherProducts'));
    }

    /**
     * Display all products in catalog with optional category/subcategory/search filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', 1)->with(['category', 'subcategory']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }
        if ($request->filled('medium')) {
            $query->where('medium', 'like', "%{$request->medium}%");
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('standard_class', 'like', "%{$search}%")
                  ->orWhere('product_code', 'like', "%{$search}%");
            });
        }
        if ($request->filled('min_price')) {
            $query->where('selling_price', '>=', floatval($request->min_price));
        }
        if ($request->filled('max_price')) {
            $query->where('selling_price', '<=', floatval($request->max_price));
        }

        // Sorting
        $orderby = $request->get('orderby', 'latest');
        switch ($orderby) {
            case 'price':
            case 'price_asc':
                $query->orderBy('selling_price', 'ASC');
                break;
            case 'price-desc':
            case 'price_desc':
                $query->orderBy('selling_price', 'DESC');
                break;
            case 'name_asc':
                $query->orderBy('product_name', 'ASC');
                break;
            case 'oldest':
                $query->orderBy('id', 'ASC');
                break;
            case 'latest':
            default:
                $query->orderBy('id', 'DESC');
                break;
        }

        $perPage = intval($request->get('limit', 12));
        if (!in_array($perPage, [12, 24, 36, 48])) {
            $perPage = 12;
        }

        $products = $query->paginate($perPage)->appends($request->all());

        // For sidebar filters: fetch categories with active subcategories & product counts
        $filterCategories = \App\Models\Category::where('is_active', 1)
            ->where('category_name', '!=', 'CATEGORY1')
            ->with(['subcategories' => function($q) {
                $q->where('is_active', 1)->withCount(['products' => function($pq) {
                    $pq->where('is_active', 1);
                }]);
            }])
            ->withCount(['products' => function($pq) {
                $pq->where('is_active', 1);
            }])
            ->get();

        $currentCategory = $request->filled('category') ? \App\Models\Category::find($request->category) : null;
        $currentSubcategory = $request->filled('subcategory') ? \App\Models\SubCategory::find($request->subcategory) : null;

        return view('front.product.index', compact('products', 'filterCategories', 'currentCategory', 'currentSubcategory'));
    }

    /**
     * Add product to session cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Display Shopping Cart page.
     *
     * @return \Illuminate\Http\Response
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $totalItems = array_sum(array_column($cart, 'quantity'));

        return view('front.cart', compact('cart', 'subtotal', 'totalItems'));
    }

    /**
     * Add product to session cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $product = Product::where('is_active', 1)->findOrFail($request->product_id);
        $qty = max(5, intval($request->quantity ?? 5)); // Minimum 5 units per policy

        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cover = $product->cover_image;
            if (!$cover && $product->images && $product->images->count() > 0) {
                $cover = $product->images->first()->image_path;
            }

            $cart[$product->id] = [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'price' => floatval($product->selling_price),
                'mrp_price' => floatval($product->mrp_price ?? $product->selling_price),
                'quantity' => $qty,
                'cover_image' => $cover,
                'standard_class' => $product->standard_class,
                'medium' => $product->medium,
                'subject' => $product->subject,
            ];
        }

        session()->put('cart', $cart);

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;
        foreach ($cart as $it) {
            $subtotal += ($it['price'] * $it['quantity']);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Added "' . $product->product_name . '" to cart!',
                'cart_count' => $totalItems,
                'subtotal' => $subtotal,
                'subtotal_formatted' => '₹' . number_format($subtotal, 2),
                'item' => $cart[$product->id],
            ]);
        }

        return redirect()->route('front.cart')->with('success', 'Added "' . $product->product_name . '" to cart!');
    }

    /**
     * Update item quantity in session cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $cart = session()->get('cart', []);
        $id = $request->product_id;

        if (!isset($cart[$id])) {
            return response()->json(['success' => false, 'message' => 'Product not found in cart.'], 404);
        }

        // Stepping ±5, minimum 5
        $qty = max(5, intval($request->quantity));
        $cart[$id]['quantity'] = $qty;
        session()->put('cart', $cart);

        $lineTotal = $cart[$id]['price'] * $qty;
        $subtotal = 0;
        foreach ($cart as $it) {
            $subtotal += ($it['price'] * $it['quantity']);
        }
        $totalItems = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Cart quantity updated.',
            'product_id' => $id,
            'quantity' => $qty,
            'line_total' => $lineTotal,
            'line_total_formatted' => '₹' . number_format($lineTotal, 2),
            'subtotal' => $subtotal,
            'subtotal_formatted' => '₹' . number_format($subtotal, 2),
            'cart_count' => $totalItems,
        ]);
    }

    /**
     * Remove item from session cart.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $removedName = $cart[$id]['product_name'] ?? 'Product';
            unset($cart[$id]);
            session()->put('cart', $cart);
        } else {
            $removedName = 'Item';
        }

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;
        foreach ($cart as $it) {
            $subtotal += ($it['price'] * $it['quantity']);
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $removedName . ' removed from cart.',
                'cart_count' => $totalItems,
                'subtotal' => $subtotal,
                'subtotal_formatted' => '₹' . number_format($subtotal, 2),
                'is_empty' => empty($cart),
            ]);
        }
        return redirect()->route('front.cart')->with('success', $removedName . ' removed from cart.');
    }

    /**
     * Submit an Inquiry from the frontside product page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitInquiry(Request $request)
    {
        // Anti-Bot / Anti-Spam Shield
        $botCheck = BotProtectionService::validate($request, 'inquiry', true);
        if (!$botCheck['success']) {
            return response()->json([
                'success' => false,
                'message' => $botCheck['message']
            ], 422);
        }
        $input = $request->all();

        // Support both frontend camelCase and snake_case field names
        $productId = $input['product_id'] ?? $input['productId'] ?? null;
        if (!$productId && !empty($input['productName'])) {
            $p = Product::where('product_name', $input['productName'])->first();
            if ($p) {
                $productId = $p->id;
            }
        }
        $customerName = $input['customer_name'] ?? $input['customerName'] ?? null;
        $customerPhone = $input['customer_phone'] ?? $input['mobile'] ?? null;
        $customerEmail = $input['customer_email'] ?? $input['email'] ?? null;
        $quantity = $input['quantity'] ?? 1;
        $message = $input['message'] ?? null;

        $normalized = [
            'product_id' => $productId,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'customer_email' => $customerEmail,
            'quantity' => $quantity,
            'message' => $message,
        ];

        $validator = Validator::make($normalized, [
            'product_id' => 'required|integer|exists:products,id',
            'customer_name' => 'required|string|min:2|max:100',
            'customer_phone' => 'required|regex:/^[6-9][0-9]{9}$/',
            'customer_email' => 'required|email|max:255',
            'quantity' => 'required|integer|min:1|max:1000',
            'message' => 'required|string|min:5|max:1000',
        ], [
            'customer_phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'customer_name.required' => 'Please enter your full name.',
            'customer_email.required' => 'Please enter a valid email address.',
            'message.required' => 'Please enter your inquiry details or message.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($normalized['product_id']);
            $qty = intval($normalized['quantity']);
            $price = floatval($product->selling_price);
            $subtotal = $price * $qty;

            // Generate unique inquiry number
            $inquiryNo = 'INQ-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            while (Inquiry::where('inquiry_no', $inquiryNo)->exists()) {
                $inquiryNo = 'INQ-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }

            $inquiry = Inquiry::create([
                'inquiry_no' => $inquiryNo,
                'customer_name' => $normalized['customer_name'],
                'customer_phone' => $normalized['customer_phone'],
                'customer_email' => $normalized['customer_email'],
                'source' => 'website',
                'status' => 'pending',
                'general_note' => $normalized['message'],
                'subtotal' => $subtotal,
                'discount_amount' => 0,
                'total_amount' => $subtotal,
            ]);

            InquiryItem::create([
                'inquiry_id' => $inquiry->id,
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'price' => $price,
                'quantity' => $qty,
                'subtotal' => $subtotal,
            ]);

            InquiryNote::create([
                'inquiry_id' => $inquiry->id,
                'user_id' => null, // from website customer
                'note' => "Website Inquiry received for '{$product->product_name}' (Qty: {$qty}, Est. ₹" . number_format($subtotal, 2) . "). Message: {$normalized['message']}",
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'inquiry_no' => $inquiry->inquiry_no,
                'message' => "Your inquiry has been submitted successfully! Inquiry ID: {$inquiry->inquiry_no}. Our team will contact you shortly."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Unable to submit your inquiry at this moment. Please try again: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit a Direct Order from the frontside (Buy Now).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitOrder(Request $request)
    {
        // Anti-Bot / Anti-Spam Shield
        $botCheck = BotProtectionService::validate($request, 'order', true);
        if (!$botCheck['success']) {
            return response()->json([
                'success' => false,
                'message' => $botCheck['message']
            ], 422);
        }
        // Anti-Bot / Anti-Spam Shield
        $botCheck = BotProtectionService::validate($request, 'order', true);
        if (!$botCheck['success']) {
            return response()->json([
                'success' => false,
                'message' => $botCheck['message']
            ], 422);
        }
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'customer_name' => 'required|string|min:2|max:100',
            'customer_phone' => 'required|regex:/^[6-9][0-9]{9}$/',
            'customer_email' => 'nullable|email|max:255',
            'shipping_address' => 'required|string|min:5|max:500',
            'city' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'quantity' => 'required|integer|min:1|max:1000',
            'order_notes' => 'nullable|string|max:500',
        ], [
            'customer_phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'shipping_address.required' => 'Please enter complete delivery address.',
            'city.required' => 'Please enter your city.',
            'pincode.required' => 'Please enter pincode.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($request->product_id);
            $qty = intval($request->quantity);
            $price = floatval($product->selling_price);
            $subtotal = $price * $qty;

            // Generate unique order number
            $orderNo = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            while (Order::where('order_no', $orderNo)->exists()) {
                $orderNo = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }

            $order = Order::create([
                'order_no' => $orderNo,
                'inquiry_id' => null, // Direct website order
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'shipping_address' => $request->shipping_address,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'seller_id' => null, // Assigned later by Superadmin
                'order_source' => 'website',
                'subtotal' => $subtotal,
                'discount_amount' => 0,
                'total_amount' => $subtotal,
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'razorpay_link',
                'notes' => $request->order_notes,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'price' => $price,
                'quantity' => $qty,
                'subtotal' => $subtotal,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'order_no' => $order->order_no,
                'message' => "Order placed successfully! Order ID: {$order->order_no}. Our team will contact you shortly to confirm and process delivery."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Unable to place order at this moment. Please try again: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle payment success callback from Razorpay payment link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paymentCallback(Request $request)
    {
        $orderNo = $request->query('order_no');
        if (!$orderNo) {
            return redirect()->route('front.home')->with('error', 'Invalid payment callback request.');
        }

        $order = Order::with('items.product')->where('order_no', $orderNo)->firstOrFail();

        $paymentId = $request->query('razorpay_payment_id')
            ?? $request->query('razorpay_payment_link_id')
            ?? $order->razorpay_payment_id;

        $order->update([
            'payment_status' => 'paid',
            'order_status' => ($order->order_status === 'pending') ? 'confirmed' : $order->order_status,
            'razorpay_payment_id' => $paymentId,
        ]);

        return view('front.payment_success', compact('order'));
    }

    /**
     * Simulated Razorpay payment screen (for testing before live keys are configured).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $order_no
     * @return \Illuminate\Http\Response
     */
    public function mockPayment(Request $request, $order_no)
    {
        $order = Order::with('items.product')->where('order_no', $order_no)->firstOrFail();

        return view('front.payment_mock', compact('order'));
    }

    /**
     * Display Multi-product Checkout page.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('front.cart')->with('error', 'Your shopping cart is empty. Please select books before checkout.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $totalItems = array_sum(array_column($cart, 'quantity'));

        return view('front.checkout', compact('cart', 'subtotal', 'totalItems'));
    }

    /**
     * Handle submission of multi-product Checkout order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function submitCheckout(Request $request)
    {
        // 1. Anti-Bot / Anti-Spam Shield
        $botCheck = BotProtectionService::validate($request, 'checkout', true);
        if (!$botCheck['success']) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $botCheck['message']], 422);
            }
            return redirect()->back()->withInput()->with('error', $botCheck['message']);
        }

        // 2. Validate input fields
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|min:2|max:100',
            'customer_phone' => 'required|regex:/^[6-9][0-9]{9}$/',
            'customer_email' => 'nullable|email|max:255',
            'shipping_address' => 'required|string|min:5|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'required|string|min:6|max:10',
            'payment_method' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Please enter your full name.',
            'customer_phone.required' => 'Please enter your mobile number.',
            'customer_phone.regex' => 'Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9.',
            'shipping_address.required' => 'Please enter your complete delivery address.',
            'city.required' => 'Please enter your city.',
            'pincode.required' => 'Please enter your 6-digit area pincode.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => $validator->errors()->first()
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // 3. Ensure cart is not empty
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Your cart is empty. Please add books to proceed.'], 422);
            }
            return redirect()->route('front.cart')->with('error', 'Your cart is empty.');
        }

        // 4. Calculate total amount
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }

        DB::beginTransaction();
        try {
            // Generate unique order number
            $orderNo = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            while (Order::where('order_no', $orderNo)->exists()) {
                $orderNo = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }

            $paymentMethod = $request->input('payment_method') ?: 'razorpay_link';
            $paymentStatus = 'pending';

            $order = Order::create([
                'order_no' => $orderNo,
                'inquiry_id' => null,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'shipping_address' => $request->shipping_address,
                'city' => $request->city,
                'state' => $request->state ?? 'Gujarat',
                'pincode' => $request->pincode,
                'seller_id' => null,
                'order_source' => 'website',
                'subtotal' => $subtotal,
                'discount_amount' => 0,
                'total_amount' => $subtotal,
                'order_status' => 'pending',
                'payment_status' => $paymentStatus,
                'payment_method' => $paymentMethod,
                'notes' => $request->notes,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'] ?? null,
                    'product_name' => $item['product_name'] ?? 'Book',
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // Clear session cart
            session()->forget('cart');

            // Redirect destination - Directly to Order Success Confirmation screen
            $redirectUrl = route('front.order.success', $order->order_no);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully! Order #' . $order->order_no,
                    'order_no' => $order->order_no,
                    'redirect' => $redirectUrl,
                ]);
            }

            return redirect($redirectUrl)->with('success', 'Order placed successfully! Order #' . $order->order_no);
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to save order: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to place order. Please try again.');
        }
    }

    /**
     * Display Order Success / Confirmation screen.
     *
     * @param  string  $order_no
     * @return \Illuminate\Http\Response
     */
    public function orderSuccess($order_no)
    {
        $order = Order::with('items.product')->where('order_no', $order_no)->firstOrFail();

        return view('front.payment_success', compact('order'));
    }

    /**
     * Generate / Stream / Download Official Order Invoice PDF for customer
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $order_no
     * @return \Illuminate\Http\Response
     */
    public function generateOrderPdf(Request $request, $order_no)
    {
        $order = Order::with(['items.product', 'seller', 'inquiry', 'coupon'])
            ->where('order_no', $order_no)
            ->firstOrFail();

        $settings = SiteSetting::pluck('value', 'key')->toArray();

        $logoPath = public_path($settings['header_logo'] ?? 'assets/img/logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.order.invoice_pdf', compact('order', 'settings', 'logoBase64'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'Order-' . ($order->order_no ?: $order->id) . '.pdf';

        if ($request->get('action') === 'view') {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }
}

