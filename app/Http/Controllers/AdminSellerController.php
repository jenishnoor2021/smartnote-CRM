<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminSellerController extends Controller
{
    /**
     * Display a listing of sellers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = User::where('role', 'seller')
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.seller.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.seller.create');
    }

    /**
     * Store a newly created seller in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        $input['password'] = Hash::make($request->password);
        $input['role'] = 'seller';
        $input['is_active'] = $request->has('is_active') ? 1 : 0;
        $input['created_by'] = Auth::id();

        User::create($input);

        return redirect()->route('admin.seller.index')->with('success', 'Seller created successfully.');
    }

    /**
     * Show the form for editing the specified seller.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seller = User::where('role', 'seller')->findOrFail($id);
        return view('admin.seller.edit', compact('seller'));
    }

    /**
     * Update the specified seller in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seller = User::where('role', 'seller')->findOrFail($id);
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        $updateData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $seller->update($updateData);

        return redirect()->route('admin.seller.index')->with('success', 'Seller updated successfully.');
    }

    /**
     * Remove the specified seller from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = User::where('role', 'seller')->find($id);

        if (!$seller) {
            return response()->json(['status' => false, 'message' => 'Seller not found.'], 404);
        }

        $seller->delete();

        return response()->json(['status' => true, 'message' => 'Seller deleted successfully.']);
    }

    /**
     * Delete multiple selected sellers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,id',
        ]);

        User::where('role', 'seller')->whereIn('id', $request->ids)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Selected sellers deleted successfully!'
        ]);
    }

    /**
     * Update active/inactive status via AJAX switch.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|integer|exists:users,id',
            'is_active' => 'required|boolean',
        ]);

        $seller = User::where('role', 'seller')->find($request->seller_id);

        if (!$seller) {
            return response()->json(['status' => false, 'message' => 'Seller not found.'], 404);
        }

        $seller->is_active = $request->is_active;
        $seller->save();

        return response()->json([
            'status' => true,
            'message' => $seller->is_active ? 'Seller Activated' : 'Seller Deactivated'
        ]);
    }
}

