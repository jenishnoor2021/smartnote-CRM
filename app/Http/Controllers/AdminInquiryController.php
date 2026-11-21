<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Inquiry;
use App\Models\InquiryItem;
use App\Models\InquiryNote;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminInquiryController extends Controller
{
    /**
     * Display a listing of inquiries.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Inquiry::with(['items.product', 'assignedSeller', 'creator'])
            ->orderBy('id', 'DESC');

        // Access Control: Seller sees only their assigned inquiries
        if ($user->isSeller()) {
            $query->where(function ($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('created_by', $user->id);
            });
        } elseif ($request->filled('seller_id')) {
            // Superadmin filtering by seller
            if ($request->seller_id === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $request->seller_id);
            }
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search Filter (Phone, Customer Name, Inquiry No)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('inquiry_no', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $limit = intval($request->get('limit', 15));
        if (!in_array($limit, [10, 15, 25, 50, 100])) {
            $limit = 15;
        }

        $inquiries = $query->paginate($limit)->appends($request->all());
        $sellers = User::where('role', 'seller')->where('is_active', 1)->orderBy('name', 'ASC')->get();

        // Count stats for quick tabs/badges
        $countsQuery = Inquiry::query();
        if ($user->isSeller()) {
            $countsQuery->where(function ($q) use ($user) {
                $q->where('assigned_to', $user->id)->orWhere('created_by', $user->id);
            });
        }
        $statusCounts = [
            'all' => (clone $countsQuery)->count(),
            'pending' => (clone $countsQuery)->where('status', 'pending')->count(),
            'contacted' => (clone $countsQuery)->where('status', 'contacted')->count(),
            'confirmed' => (clone $countsQuery)->where('status', 'confirmed')->count(),
            'cancelled' => (clone $countsQuery)->where('status', 'cancelled')->count(),
            'converted' => (clone $countsQuery)->where('status', 'converted')->count(),
        ];

        return view('admin.inquiry.index', compact('inquiries', 'sellers', 'statusCounts'));
    }

    /**
     * Show the form for creating a new inquiry.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('is_active', 1)->orderBy('product_name', 'ASC')->get();
        $sellers = User::where('role', 'seller')->where('is_active', 1)->orderBy('name', 'ASC')->get();

        return view('admin.inquiry.create', compact('products', 'sellers'));
    }

    /**
     * Store a newly created inquiry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'assigned_to' => 'nullable|integer|exists:users,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'general_note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            // Determine assigned seller
            $assignedTo = null;
            if ($user->isSeller()) {
                $assignedTo = $user->id; // Seller creating inquiry is auto-assigned
            } elseif ($request->filled('assigned_to')) {
                $assignedTo = $request->assigned_to;
            }

            // Generate unique inquiry number
            $inquiryNo = 'INQ-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            while (Inquiry::where('inquiry_no', $inquiryNo)->exists()) {
                $inquiryNo = 'INQ-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }

            $inquiry = Inquiry::create([
                'inquiry_no' => $inquiryNo,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'assigned_to' => $assignedTo,
                'created_by' => $user->id,
                'source' => $user->isSeller() ? 'seller' : 'admin',
                'status' => 'pending',
                'general_note' => $request->general_note,
                'subtotal' => 0,
                'discount_amount' => 0,
                'total_amount' => 0,
            ]);

            // Save items
            $subtotal = 0;
            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                $price = floatval($item['price']);
                $qty = intval($item['quantity']);
                $itemSubtotal = $price * $qty;
                $subtotal += $itemSubtotal;

                InquiryItem::create([
                    'inquiry_id' => $inquiry->id,
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'price' => $price,
                    'quantity' => $qty,
                    'subtotal' => $itemSubtotal,
                ]);
            }

            $inquiry->subtotal = $subtotal;
            $inquiry->total_amount = $subtotal;
            $inquiry->save();

            // Initial log note
            $logText = "Inquiry created by " . $user->name . " (" . ucfirst($user->role) . ").";
            if ($assignedTo && $assignedTo != $user->id) {
                $assignedSeller = User::find($assignedTo);
                $logText .= " Assigned to seller " . ($assignedSeller->name ?? '') . ".";
            }
            if ($request->filled('general_note')) {
                $logText .= " Note: " . $request->general_note;
            }

            InquiryNote::create([
                'inquiry_id' => $inquiry->id,
                'user_id' => $user->id,
                'note' => $logText,
            ]);

            DB::commit();

            return redirect()->route('admin.inquiry.show', $inquiry->id)
                ->with('success', "Inquiry {$inquiry->inquiry_no} created successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withInput($request->all())->with('error', 'Error creating inquiry: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified inquiry and interaction hub.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $inquiry = Inquiry::with(['items.product', 'notes.user', 'assignedSeller', 'creator', 'coupon', 'order'])
            ->findOrFail($id);

        // Security check for seller
        if ($user->isSeller() && $inquiry->assigned_to !== $user->id && $inquiry->created_by !== $user->id) {
            abort(403, 'Unauthorized access to this inquiry.');
        }

        // Check if this customer has any other active/pending inquiries with the same phone number!
        $otherInquiries = Inquiry::with('items')
            ->where('customer_phone', $inquiry->customer_phone)
            ->where('id', '!=', $inquiry->id)
            ->whereIn('status', ['pending', 'contacted', 'confirmed'])
            ->get();

        $sellers = User::where('role', 'seller')->where('is_active', 1)->orderBy('name', 'ASC')->get();

        return view('admin.inquiry.show', compact('inquiry', 'otherInquiries', 'sellers'));
    }

    /**
     * Show the form for editing the specified inquiry.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $inquiry = Inquiry::with('items')->findOrFail($id);

        if ($user->isSeller() && $inquiry->assigned_to !== $user->id && $inquiry->created_by !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        if ($inquiry->status === 'converted') {
            return redirect()->route('admin.inquiry.show', $id)
                ->with('error', 'This inquiry has already been converted to an order and cannot be edited.');
        }

        $products = Product::where('is_active', 1)->orderBy('product_name', 'ASC')->get();
        $sellers = User::where('role', 'seller')->where('is_active', 1)->orderBy('name', 'ASC')->get();

        return view('admin.inquiry.edit', compact('inquiry', 'products', 'sellers'));
    }

    /**
     * Update the specified inquiry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $inquiry = Inquiry::findOrFail($id);

        if ($user->isSeller() && $inquiry->assigned_to !== $user->id && $inquiry->created_by !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'assigned_to' => 'nullable|integer|exists:users,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $updateData = [
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'general_note' => $request->general_note,
            ];

            if ($user->isSuperAdmin() && $request->has('assigned_to')) {
                $updateData['assigned_to'] = $request->assigned_to;
            }

            $inquiry->update($updateData);

            // Re-sync items
            InquiryItem::where('inquiry_id', $inquiry->id)->delete();
            $subtotal = 0;

            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                $price = floatval($item['price']);
                $qty = intval($item['quantity']);
                $itemSubtotal = $price * $qty;
                $subtotal += $itemSubtotal;

                InquiryItem::create([
                    'inquiry_id' => $inquiry->id,
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'price' => $price,
                    'quantity' => $qty,
                    'subtotal' => $itemSubtotal,
                ]);
            }

            $inquiry->subtotal = $subtotal;
            $inquiry->recalculateTotals();

            InquiryNote::create([
                'inquiry_id' => $inquiry->id,
                'user_id' => $user->id,
                'note' => "Inquiry details and products updated by " . $user->name . ".",
            ]);

            DB::commit();

            return redirect()->route('admin.inquiry.show', $inquiry->id)
                ->with('success', 'Inquiry updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withInput($request->all())->with('error', 'Error updating inquiry: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified inquiry from storage (Superadmin only).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return response()->json(['status' => false, 'message' => 'Inquiry not found.'], 404);
        }

        $inquiry->delete();

        return response()->json(['status' => true, 'message' => 'Inquiry deleted successfully.']);
    }

    /**
     * Bulk assign multiple selected inquiries to a seller (Superadmin only).
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
            'ids.*' => 'integer|exists:inquiries,id',
            'seller_id' => 'required|integer|exists:users,id',
        ]);

        $seller = User::where('role', 'seller')->findOrFail($request->seller_id);

        DB::beginTransaction();
        try {
            Inquiry::whereIn('id', $request->ids)->update([
                'assigned_to' => $seller->id,
            ]);

            foreach ($request->ids as $inqId) {
                InquiryNote::create([
                    'inquiry_id' => $inqId,
                    'user_id' => $user->id,
                    'note' => "Inquiry assigned to seller " . $seller->name . " by " . $user->name . ".",
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => count($request->ids) . " inquiries assigned to " . $seller->name . " successfully!"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Add a call note or interaction remark.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
            'update_status' => 'nullable|string|in:pending,contacted,confirmed,cancelled',
        ]);

        $user = Auth::user();
        $inquiry = Inquiry::findOrFail($id);

        if ($user->isSeller() && $inquiry->assigned_to !== $user->id && $inquiry->created_by !== $user->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized.'], 403);
        }

        DB::beginTransaction();
        try {
            $note = InquiryNote::create([
                'inquiry_id' => $inquiry->id,
                'user_id' => $user->id,
                'note' => $request->note,
            ]);

            // If seller called, we can transition from pending to contacted automatically or as selected
            if ($request->filled('update_status')) {
                $inquiry->status = $request->update_status;
                $inquiry->save();
            } elseif ($inquiry->status === 'pending') {
                $inquiry->status = 'contacted';
                $inquiry->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Call note recorded successfully!',
                'note' => [
                    'id' => $note->id,
                    'user_name' => $user->name,
                    'note' => $note->note,
                    'created_at' => $note->created_at->format('d-m-Y H:i A'),
                ],
                'new_status' => $inquiry->status
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update inquiry status directly (Pending, Contacted, Confirmed, Cancelled).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,confirmed,cancelled',
            'cancel_reason' => 'required_if:status,cancelled|nullable|string|max:500',
        ]);

        $user = Auth::user();
        $inquiry = Inquiry::findOrFail($id);

        if ($user->isSeller() && $inquiry->assigned_to !== $user->id && $inquiry->created_by !== $user->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized.'], 403);
        }

        DB::beginTransaction();
        try {
            $oldStatus = $inquiry->status;
            $inquiry->status = $request->status;

            if ($request->status === 'cancelled') {
                $inquiry->cancel_reason = $request->cancel_reason;
            } else {
                $inquiry->cancel_reason = null;
            }

            $inquiry->save();

            $logText = "Status changed from " . ucfirst($oldStatus) . " to " . ucfirst($request->status) . " by " . $user->name . ".";
            if ($request->status === 'cancelled' && $request->filled('cancel_reason')) {
                $logText .= " Reason: " . $request->cancel_reason;
            }

            InquiryNote::create([
                'inquiry_id' => $inquiry->id,
                'user_id' => $user->id,
                'note' => $logText,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Inquiry status updated to ' . ucfirst($request->status) . '.',
                'new_status' => $inquiry->status
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * AJAX endpoint to validate a coupon code and return discount amounts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $code = strtoupper(trim($request->code));
        $subtotal = floatval($request->subtotal);

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon code does not exist.'
            ], 404);
        }

        if (!$coupon->is_active) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon is currently inactive.'
            ], 422);
        }

        if ($coupon->is_used) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon has already been used in another order.'
            ], 422);
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon expired on ' . $coupon->expires_at->format('d-m-Y') . '.'
            ], 422);
        }

        if ($coupon->min_order_amount > 0 && $subtotal < $coupon->min_order_amount) {
            return response()->json([
                'status' => false,
                'message' => 'Minimum order amount for this coupon is ₹' . number_format($coupon->min_order_amount, 2) . '.'
            ], 422);
        }

        $discount = $coupon->calculateDiscount($subtotal);
        $finalTotal = max(0, $subtotal - $discount);

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully!',
            'coupon_id' => $coupon->id,
            'coupon_code' => $coupon->code,
            'type' => $coupon->type,
            'amount' => $coupon->amount,
            'discount_amount' => $discount,
            'final_total' => $finalTotal,
        ]);
    }

    /**
     * Merge multiple customer inquiries into this single inquiry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mergeInquiries(Request $request, $id)
    {
        $request->validate([
            'merge_inquiry_ids' => 'required|array|min:1',
            'merge_inquiry_ids.*' => 'integer|exists:inquiries,id',
        ]);

        $user = Auth::user();
        $targetInquiry = Inquiry::findOrFail($id);

        DB::beginTransaction();
        try {
            $mergedNos = [];
            foreach ($request->merge_inquiry_ids as $sourceId) {
                if ($sourceId == $targetInquiry->id) {
                    continue;
                }

                $sourceInquiry = Inquiry::with('items')->find($sourceId);
                if (!$sourceInquiry || $sourceInquiry->status === 'converted' || $sourceInquiry->status === 'merged') {
                    continue;
                }

                // Copy all items from source to target
                foreach ($sourceInquiry->items as $item) {
                    InquiryItem::create([
                        'inquiry_id' => $targetInquiry->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->subtotal,
                    ]);
                }

                // Mark source as merged
                $sourceInquiry->status = 'merged';
                $sourceInquiry->merged_into_id = $targetInquiry->id;
                $sourceInquiry->save();

                InquiryNote::create([
                    'inquiry_id' => $sourceInquiry->id,
                    'user_id' => $user->id,
                    'note' => "Inquiry merged into {$targetInquiry->inquiry_no} by {$user->name}.",
                ]);

                $mergedNos[] = $sourceInquiry->inquiry_no;
            }

            // Recalculate totals on target
            $targetInquiry->recalculateTotals();

            // Log note on target
            InquiryNote::create([
                'inquiry_id' => $targetInquiry->id,
                'user_id' => $user->id,
                'note' => "Merged items from inquiries: " . implode(', ', $mergedNos) . " by {$user->name}.",
            ]);

            DB::commit();

            return redirect()->route('admin.inquiry.show', $targetInquiry->id)
                ->with('success', "Inquiries successfully merged into {$targetInquiry->inquiry_no}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.inquiry.show', $targetInquiry->id)
                ->with('error', 'Error merging inquiries: ' . $e->getMessage());
        }
    }

    /**
     * Convert confirmed inquiry into an Order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function convertToOrder(Request $request, $id)
    {
        $user = Auth::user();
        $inquiry = Inquiry::with(['items', 'coupon'])->findOrFail($id);

        if ($inquiry->status === 'converted') {
            return Redirect::back()->with('error', 'This inquiry has already been converted to an order.');
        }

        if ($inquiry->items->count() === 0) {
            return Redirect::back()->with('error', 'Cannot convert an inquiry with no products.');
        }

        DB::beginTransaction();
        try {
            $subtotal = $inquiry->items->sum('subtotal');
            $discountAmount = 0;
            $couponId = null;
            $couponCode = null;

            // Handle coupon application if supplied in the confirmation form
            if ($request->filled('coupon_code')) {
                $couponCodeInput = strtoupper(trim($request->coupon_code));
                $coupon = Coupon::where('code', $couponCodeInput)->first();

                if ($coupon && $coupon->is_active && !$coupon->is_used) {
                    $discountAmount = $coupon->calculateDiscount($subtotal);
                    $couponId = $coupon->id;
                    $couponCode = $coupon->code;
                }
            } elseif ($inquiry->coupon) {
                // If coupon was already attached to inquiry
                $coupon = $inquiry->coupon;
                if ($coupon->is_active && !$coupon->is_used) {
                    $discountAmount = $coupon->calculateDiscount($subtotal);
                    $couponId = $coupon->id;
                    $couponCode = $coupon->code;
                }
            }

            $totalAmount = max(0, $subtotal - $discountAmount);

            // Generate unique Order Number
            $orderNo = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            while (Order::where('order_no', $orderNo)->exists()) {
                $orderNo = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            }

            // Create Order
            $order = Order::create([
                'order_no' => $orderNo,
                'inquiry_id' => $inquiry->id,
                'customer_name' => $request->customer_name ?? $inquiry->customer_name,
                'customer_phone' => $request->customer_phone ?? $inquiry->customer_phone,
                'customer_email' => $request->customer_email ?? $inquiry->customer_email,
                'shipping_address' => $request->address ?? $inquiry->address,
                'city' => $request->city ?? $inquiry->city,
                'state' => $request->state ?? $inquiry->state,
                'pincode' => $request->pincode ?? $inquiry->pincode,
                'seller_id' => $inquiry->assigned_to ?? $user->id,
                'created_by' => $user->id,
                'order_source' => 'inquiry',
                'subtotal' => $subtotal,
                'coupon_id' => $couponId,
                'coupon_code' => $couponCode,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'order_status' => 'confirmed',
                'payment_status' => $request->payment_status ?? 'pending',
                'payment_method' => $request->payment_method ?? 'razorpay_link',
                'notes' => $request->order_notes ?? $inquiry->general_note,
            ]);

            // Create Order Items
            foreach ($inquiry->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);
            }

            // Mark coupon as used
            if ($couponId) {
                Coupon::where('id', $couponId)->update([
                    'is_used' => 1,
                    'order_id' => $order->id,
                    'inquiry_id' => $inquiry->id,
                ]);
            }

            // Update Inquiry status to converted
            $inquiry->status = 'converted';
            $inquiry->coupon_id = $couponId;
            $inquiry->coupon_code = $couponCode;
            $inquiry->discount_amount = $discountAmount;
            $inquiry->total_amount = $totalAmount;
            $inquiry->save();

            // Log note
            InquiryNote::create([
                'inquiry_id' => $inquiry->id,
                'user_id' => $user->id,
                'note' => "Inquiry confirmed and converted to Order #{$order->order_no} by {$user->name}. Total: ₹" . number_format($totalAmount, 2) . ($discountAmount > 0 ? " (Discount: ₹" . number_format($discountAmount, 2) . " via coupon {$couponCode})" : ""),
            ]);

            DB::commit();

            return redirect()->route('admin.order.show', $order->id)
                ->with('success', "Inquiry converted to Order {$order->order_no} successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error converting to order: ' . $e->getMessage());
        }
    }

    /**
     * Generate and download or stream quotation PDF for an inquiry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadQuotationPdf(Request $request, $id)
    {
        $user = Auth::user();
        $inquiry = Inquiry::with(['items.product', 'assignedSeller', 'creator', 'coupon'])
            ->findOrFail($id);

        // Security check for seller
        if ($user->isSeller() && $inquiry->assigned_to !== $user->id && $inquiry->created_by !== $user->id) {
            abort(403, 'Unauthorized access to this quotation.');
        }

        // Fetch site settings for branding and contact
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        // Prepare Base64 logo for robust rendering in DomPDF
        $logoPath = public_path($settings['header_logo'] ?? 'assets/img/logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.inquiry.quotation_pdf', compact('inquiry', 'settings', 'logoBase64'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'Quotation-' . ($inquiry->inquiry_no ?: $inquiry->id) . '.pdf';

        if ($request->get('action') === 'view') {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }
}

