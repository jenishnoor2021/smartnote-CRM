<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminCouponController extends Controller
{
    /**
     * Display a listing of coupons.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Coupon::with(['creator', 'order'])->orderBy('id', 'DESC');

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', 0);
            } elseif ($request->status === 'used') {
                $query->where('is_used', 1);
            } elseif ($request->status === 'unused') {
                $query->where('is_used', 0);
            }
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('code', 'like', "%{$search}%");
        }

        $limit = intval($request->get('limit', 15));
        if (!in_array($limit, [10, 15, 25, 50, 100])) {
            $limit = 15;
        }

        $coupons = $query->paginate($limit)->appends($request->all());

        return view('admin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created coupon in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['code'] = strtoupper(trim($request->code));

        $rules = [
            'code' => 'required|string|max:50|unique:coupons,code',
            'type' => 'required|in:percentage,fixed',
            'amount' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ];

        if ($request->type === 'percentage') {
            $rules['amount'] .= '|max:100';
        }

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        Coupon::create([
            'code' => $input['code'],
            'type' => $request->type,
            'amount' => $request->amount,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount_amount' => $request->max_discount_amount ?? null,
            'expires_at' => $request->expires_at,
            'notes' => $request->notes,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.coupon.index')->with('success', 'Coupon created successfully.');
    }

    /**
     * Show the form for editing the specified coupon.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $input = $request->all();
        $input['code'] = strtoupper(trim($request->code));

        $rules = [
            'code' => 'required|string|max:50|unique:coupons,code,' . $id,
            'type' => 'required|in:percentage,fixed',
            'amount' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ];

        if ($request->type === 'percentage') {
            $rules['amount'] .= '|max:100';
        }

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        $coupon->update([
            'code' => $input['code'],
            'type' => $request->type,
            'amount' => $request->amount,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount_amount' => $request->max_discount_amount ?? null,
            'expires_at' => $request->expires_at,
            'notes' => $request->notes,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.coupon.index')->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified coupon from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json(['status' => false, 'message' => 'Coupon not found.'], 404);
        }

        if ($coupon->is_used) {
            return response()->json(['status' => false, 'message' => 'Used coupon cannot be deleted.'], 400);
        }

        $coupon->delete();

        return response()->json(['status' => true, 'message' => 'Coupon deleted successfully.']);
    }

    /**
     * Delete multiple selected coupons.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:coupons,id',
        ]);

        // Only delete coupons that are not used
        $count = Coupon::whereIn('id', $request->ids)->where('is_used', 0)->delete();


        return response()->json([
            'status' => true,
            'message' => $count . ' coupons deleted successfully.'
        ]);
    }

    /**
     * Update active status via AJAX switch.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request)
    {
        $request->validate([
            'coupon_id' => 'required|integer|exists:coupons,id',
            'is_active' => 'required|boolean',
        ]);

        $coupon = Coupon::find($request->coupon_id);

        if (!$coupon) {
            return response()->json(['status' => false, 'message' => 'Coupon not found.'], 404);
        }

        $coupon->is_active = $request->is_active;
        $coupon->save();

        return response()->json([
            'status' => true,
            'message' => $coupon->is_active ? 'Coupon Activated' : 'Coupon Deactivated'
        ]);
    }
}

