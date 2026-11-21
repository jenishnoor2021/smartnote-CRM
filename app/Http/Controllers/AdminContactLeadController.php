<?php

namespace App\Http\Controllers;

use App\Models\ContactLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminContactLeadController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactLead::orderBy('id', 'DESC');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        $limit = intval($request->get('limit', 20));
        if (!in_array($limit, [10, 20, 50, 100])) {
            $limit = 20;
        }

        $leads = $query->paginate($limit)->appends($request->all());

        return view('admin.contact_lead.index', compact('leads'));
    }

    public function show($id)
    {
        $lead = ContactLead::findOrFail($id);

        return view('admin.contact_lead.show', compact('lead'));
    }

    public function updateStatus(Request $request, $id)
    {
        $lead = ContactLead::findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,contacted,closed',
            'notes' => 'nullable|string',
        ]);

        $lead->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return Redirect::route('admin.contact_lead.show', $lead->id)->with('success', 'Contact lead updated successfully.');
    }

    public function destroy($id)
    {
        $lead = ContactLead::find($id);
        if (!$lead) {
            if (request()->ajax()) {
                return response()->json(['status' => false, 'message' => 'Lead not found.'], 404);
            }
            return Redirect::route('admin.contact-lead.index')->with('error', 'Lead not found.');
        }

        $lead->delete();

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => 'Contact lead deleted successfully.']);
        }
        return Redirect::route('admin.contact-lead.index')->with('success', 'Contact lead deleted successfully.');
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];
        if (!empty($ids)) {
            ContactLead::whereIn('id', $ids)->delete();
        }

        return response()->json(['status' => true, 'message' => 'Selected leads deleted successfully.']);
    }
}

