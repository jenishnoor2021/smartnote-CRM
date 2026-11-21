<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminPartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partys = Party::orderBy('id', 'DESC')->get();
        return view('admin.party.index', compact('partys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.party.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'party_code' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        $input['round_1'] = $input['round_1'] ?? '1';
        $input['round_2'] = $input['round_2'] ?? '1';
        $input['round_3'] = $input['round_3'] ?? '1';
        $input['fancy_1'] = $input['fancy_1'] ?? '1';
        $input['fancy_2'] = $input['fancy_2'] ?? '1';
        $input['fancy_3'] = $input['fancy_3'] ?? '1';
        $input['fancy_4'] = $input['fancy_4'] ?? '1';
        $input['fancy_5'] = $input['fancy_5'] ?? '1';
        $input['fancy_6'] = $input['fancy_6'] ?? '1';
        $input['fancy_7'] = $input['fancy_7'] ?? '1';
        $input['fancy_8'] = $input['fancy_8'] ?? '1';

        Party::create($input);
        return redirect('admin/party')->with('success', "Add Record Successfully");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $party = Party::findOrFail($id);
        return view('admin.party.edit', compact('party'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $push = Party::findOrFail($id);

        $input = $request->all();

        $is_active = $request->has('is_active') ? 1 : 0;
        $input['is_active'] = $is_active;

        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'party_code' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        $input['round_1'] = $input['round_1'] ?? '1';
        $input['round_2'] = $input['round_2'] ?? '1';
        $input['round_3'] = $input['round_3'] ?? '1';
        $input['fancy_1'] = $input['fancy_1'] ?? '1';
        $input['fancy_2'] = $input['fancy_2'] ?? '1';
        $input['fancy_3'] = $input['fancy_3'] ?? '1';
        $input['fancy_4'] = $input['fancy_4'] ?? '1';
        $input['fancy_5'] = $input['fancy_5'] ?? '1';
        $input['fancy_6'] = $input['fancy_6'] ?? '1';
        $input['fancy_7'] = $input['fancy_7'] ?? '1';
        $input['fancy_8'] = $input['fancy_8'] ?? '1';

        $push->update($input);
        return redirect('admin/party')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $party = Party::find($id);

        if (!$party) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        $party->delete();

        return response()->json(['status' => true, 'message' => 'Record deleted successfully']);
    }

    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:parties,id',
        ]);

        // Delete selected records
        Party::whereIn('id', $request->ids)->delete();

        return response()->json([
            'status' => true,
            'message' => "Selected records deleted successfully!"
        ]);
    }

    public function update_status(Request $request)
    {
        $request->validate([
            'party_id' => 'required|integer|exists:parties,id',
            'is_active' => 'required|boolean',
        ]);

        // Retrieve the Party by ID
        $party = Party::find($request->party_id);

        if (!$party) {
            return response()->json(['status' => false, 'message' => 'Party not found'], 404);
        }

        // Update the `is_active` status
        $party->is_active = $request->is_active;
        $party->save();

        // Return JSON response for AJAX
        return response()->json([
            'status' => true,
            'message' => $party->is_active ? 'Activated' : 'Deactivated'
        ]);
    }
}
