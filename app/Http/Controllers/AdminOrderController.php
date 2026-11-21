<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Order::with(['items.product', 'seller', 'coupon', 'inquiry'])
            ->orderBy('id', 'DESC');

        if ($user->isSeller()) {
            $query->where('seller_id', $user->id);
        } elseif ($request->filled('seller_id')) {
            $query->where('seller_id', $request->seller_id);
        }

        if ($request->filled('order_status')) {
            $query->where('order_status', $request->order_status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('order_no', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $limit = intval($request->get('limit', 15));
        if (!in_array($limit, [10, 15, 25, 50, 100])) {
            $limit = 15;
        }

        $orders = $query->paginate($limit)->appends($request->all());
        $sellers = User::where('role', 'seller')->where('is_active', 1)->orderBy('name', 'ASC')->get();

        return view('admin.order.index', compact('orders', 'sellers'));
    }

    /**
     * Display the specified order invoice/details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $order = Order::with(['items.product', 'seller', 'coupon', 'inquiry'])
            ->findOrFail($id);

        if ($user->isSeller() && $order->seller_id !== $user->id) {
            abort(403, 'Unauthorized access to this order.');
        }

        $sellers = User::where('role', 'seller')->where('is_active', 1)->orderBy('name', 'ASC')->get();

        return view('admin.order.show', compact('order', 'sellers'));
    }

    /**
     * Update the order status and payment status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        $order = Order::findOrFail($id);

        if ($user->isSeller() && $order->seller_id !== $user->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'order_status' => 'required|in:pending,confirmed,processing,dispatched,delivered,cancelled',
            'payment_status' => 'required|in:pending,link_sent,paid,failed',
            'seller_id' => 'nullable|integer|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $updateData = [
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
            'notes' => $request->notes,
        ];

        // Superadmin can assign or change the seller
        if ($user->isSuperAdmin()) {
            $updateData['seller_id'] = $request->filled('seller_id') ? $request->seller_id : null;
        }

        $order->update($updateData);

        return redirect()->route('admin.order.show', $order->id)
            ->with('success', 'Order status & details updated successfully.');
    }

    /**
     * Bulk assign multiple selected orders to a seller (Superadmin only).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkAssign(Request $request)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:orders,id',
            'seller_id' => 'required|integer|exists:users,id',
        ]);

        $seller = User::where('role', 'seller')->findOrFail($request->seller_id);

        Order::whereIn('id', $request->ids)->update([
            'seller_id' => $seller->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => count($request->ids) . " orders assigned to " . $seller->name . " successfully!"
        ]);
    }

    /**
     * Apply a discount coupon to an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function applyCoupon(Request $request, $id)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        $user = Auth::user();

        if ($user->isSeller() && $order->seller_id !== $user->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized action.'], 403);
        }

        if ($order->coupon_id) {
            return response()->json(['status' => false, 'message' => 'A coupon is already applied to this order. Remove it first to apply a different coupon.'], 422);
        }

        $code = strtoupper(trim($request->coupon_code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['status' => false, 'message' => 'Coupon code does not exist.'], 404);
        }

        if (!$coupon->is_active) {
            return response()->json(['status' => false, 'message' => 'This coupon is currently inactive.'], 422);
        }

        if ($coupon->is_used) {
            return response()->json(['status' => false, 'message' => 'This coupon has already been used in another order.'], 422);
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json(['status' => false, 'message' => 'This coupon has expired on ' . $coupon->expires_at->format('d-m-Y') . '.'], 422);
        }

        if ($coupon->min_order_amount > 0 && $order->subtotal < $coupon->min_order_amount) {
            return response()->json(['status' => false, 'message' => 'Minimum order amount for this coupon is ₹' . number_format($coupon->min_order_amount, 2) . '.'], 422);
        }

        $discount = $coupon->calculateDiscount($order->subtotal);
        $newTotal = max(0, $order->subtotal - $discount);

        DB::beginTransaction();
        try {
            $order->update([
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'discount_amount' => $discount,
                'total_amount' => $newTotal,
            ]);

            $coupon->update([
                'is_used' => 1,
                'order_id' => $order->id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => "Coupon '{$coupon->code}' applied successfully! Discount of ₹" . number_format($discount, 2) . " given.",
                'discount_amount' => $discount,
                'new_total' => $newTotal
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Error applying coupon: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the applied coupon from an order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeCoupon($id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();

        if ($user->isSeller() && $order->seller_id !== $user->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized action.'], 403);
        }

        if (!$order->coupon_id) {
            return response()->json(['status' => false, 'message' => 'No coupon applied to this order.'], 422);
        }

        DB::beginTransaction();
        try {
            // Mark coupon unused
            Coupon::where('id', $order->coupon_id)->update([
                'is_used' => 0,
                'order_id' => null,
            ]);

            $order->update([
                'coupon_id' => null,
                'coupon_code' => null,
                'discount_amount' => 0,
                'total_amount' => $order->subtotal,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Coupon removed and order total reset to original amount.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Error removing coupon: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Generate Razorpay Standard Payment Link for an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function generatePaymentLink(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);
        $user = Auth::user();

        if ($user->isSeller() && $order->seller_id !== $user->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized action.'], 403);
        }

        if ($order->total_amount <= 0) {
            return response()->json(['status' => false, 'message' => 'Order total must be greater than zero.'], 422);
        }

        $keyId = trim(config('services.razorpay.key_id', ''));
        $keySecret = trim(config('services.razorpay.key_secret', ''));

        // If keys are missing in .env
        if (empty($keyId) || empty($keySecret)) {
            if ($request->boolean('allow_mock', false)) {
                $mockLink = route('front.payment_mock', ['order_no' => $order->order_no]);
                $mockId = 'mock_plink_' . strtolower(Str::random(12));

                $order->update([
                    'payment_link' => $mockLink,
                    'razorpay_payment_id' => $mockId,
                    'payment_status' => 'link_sent',
                    'payment_method' => 'razorpay_link',
                ]);

                return response()->json([
                    'status' => true,
                    'is_mock' => true,
                    'payment_link' => $mockLink,
                    'link_id' => $mockId,
                    'message' => 'Simulated Payment Link generated! To generate live Razorpay links, configure RAZORPAY_KEY_ID & RAZORPAY_KEY_SECRET in .env.',
                ]);
            }

            return response()->json([
                'status' => false,
                'missing_keys' => true,
                'message' => 'Razorpay API credentials are not set in .env! Please add RAZORPAY_KEY_ID and RAZORPAY_KEY_SECRET, or use simulated demo mode.',
            ], 422);
        }

        // Clean customer phone number
        $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
        if (strlen($cleanPhone) === 10) {
            $formattedPhone = '+91' . $cleanPhone;
        } elseif (strlen($cleanPhone) === 12 && substr($cleanPhone, 0, 2) === '91') {
            $formattedPhone = '+' . $cleanPhone;
        } else {
            $formattedPhone = '+91' . substr($cleanPhone, -10);
        }

        $customerData = [
            'name' => $order->customer_name ?: 'Customer',
            'contact' => $formattedPhone,
        ];

        $hasValidEmail = !empty($order->customer_email) && filter_var($order->customer_email, FILTER_VALIDATE_EMAIL);
        if ($hasValidEmail) {
            $customerData['email'] = $order->customer_email;
        }

        $notifySms = $request->boolean('notify_sms', true);
        $notifyEmail = $hasValidEmail && $request->boolean('notify_email', true);

        // Razorpay expects amount in paise (1 INR = 100 paise)
        $amountInPaise = intval(round(floatval($order->total_amount) * 100));

        $payload = [
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'accept_partial' => false,
            'description' => "Payment for Order #{$order->order_no} - SmartNote",
            'customer' => $customerData,
            'notify' => [
                'sms' => $notifySms,
                'email' => $notifyEmail,
            ],
            'reminder_enable' => true,
            'notes' => [
                'order_id' => (string) $order->id,
                'order_no' => (string) $order->order_no,
                'customer_name' => (string) $order->customer_name,
            ],
            'callback_url' => route('front.payment_callback', ['order_no' => $order->order_no]),
            'callback_method' => 'get',
        ];

        try {
            $response = Http::withBasicAuth($keyId, $keySecret)
                ->timeout(20)
                ->post('https://api.razorpay.com/v1/payment_links', $payload);

            if ($response->successful()) {
                $data = $response->json();
                $shortUrl = $data['short_url'] ?? null;
                $linkId = $data['id'] ?? null;

                $order->update([
                    'payment_link' => $shortUrl,
                    'razorpay_payment_id' => $linkId,
                    'payment_status' => 'link_sent',
                    'payment_method' => 'razorpay_link',
                ]);

                return response()->json([
                    'status' => true,
                    'is_mock' => false,
                    'payment_link' => $shortUrl,
                    'link_id' => $linkId,
                    'message' => "Razorpay Payment Link generated successfully! (Link ID: {$linkId})",
                ]);
            } else {
                $err = $response->json();
                $errMsg = $err['error']['description'] ?? ('HTTP ' . $response->status() . ': ' . $response->body());
                return response()->json([
                    'status' => false,
                    'message' => 'Razorpay Error: ' . $errMsg,
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Connection to Razorpay failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check live payment link status on Razorpay.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkPaymentStatus($id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();

        if ($user->isSeller() && $order->seller_id !== $user->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized action.'], 403);
        }

        if ($order->payment_status === 'paid') {
            return response()->json([
                'status' => true,
                'is_paid' => true,
                'payment_status' => 'paid',
                'message' => 'Order is already marked as Paid.',
            ]);
        }

        $linkId = $order->razorpay_payment_id;
        if (empty($linkId)) {
            return response()->json(['status' => false, 'message' => 'No Razorpay link has been generated yet for this order.'], 404);
        }

        // If mock link
        if (str_starts_with($linkId, 'mock_')) {
            return response()->json([
                'status' => true,
                'is_paid' => false,
                'payment_status' => 'link_sent',
                'message' => 'This is a simulated demo link. Click the link to complete simulated customer payment.',
            ]);
        }

        $keyId = trim(config('services.razorpay.key_id', ''));
        $keySecret = trim(config('services.razorpay.key_secret', ''));

        if (empty($keyId) || empty($keySecret)) {
            return response()->json(['status' => false, 'message' => 'Razorpay API credentials not set in .env.'], 422);
        }

        try {
            $response = Http::withBasicAuth($keyId, $keySecret)
                ->timeout(15)
                ->get("https://api.razorpay.com/v1/payment_links/{$linkId}");

            if ($response->successful()) {
                $data = $response->json();
                $linkStatus = strtolower($data['status'] ?? '');

                if ($linkStatus === 'paid') {
                    $order->update([
                        'payment_status' => 'paid',
                        'order_status' => ($order->order_status === 'pending') ? 'confirmed' : $order->order_status,
                    ]);

                    return response()->json([
                        'status' => true,
                        'is_paid' => true,
                        'payment_status' => 'paid',
                        'message' => 'Payment received! Razorpay verified the transaction. Order marked as PAID.',
                    ]);
                } else {
                    return response()->json([
                        'status' => true,
                        'is_paid' => false,
                        'payment_status' => $linkStatus,
                        'message' => "Payment link status is '{$linkStatus}'. Customer has not completed payment yet.",
                    ]);
                }
            } else {
                $err = $response->json();
                $errMsg = $err['error']['description'] ?? $response->body();
                return response()->json(['status' => false, 'message' => 'Razorpay Error: ' . $errMsg], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Unable to check status: ' . $e->getMessage()], 500);
        }
    }
}

