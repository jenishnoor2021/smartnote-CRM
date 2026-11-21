<?php

namespace App\Http\Controllers;

use App\Models\DistributorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminDistributorController extends Controller
{
    public function index(Request $request)
    {
        $query = DistributorApplication::orderBy('id', 'DESC');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('trader_name', 'like', "%{$s}%")
                  ->orWhere('firm_name', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('city', 'like', "%{$s}%");
            });
        }

        $limit = intval($request->get('limit', 20));
        if (!in_array($limit, [10, 20, 50, 100])) {
            $limit = 20;
        }

        $applications = $query->paginate($limit)->appends($request->all());

        return view('admin.distributor.index', compact('applications'));
    }

    public function show($id)
    {
        $application = DistributorApplication::findOrFail($id);

        return view('admin.distributor.show', compact('application'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = DistributorApplication::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,contacted,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return Redirect::route('admin.distributor.show', $application->id)->with('success', 'Application status updated successfully.');
    }

    public function destroy($id)
    {
        $application = DistributorApplication::find($id);
        if (!$application) {
            if (request()->ajax()) {
                return response()->json(['status' => false, 'message' => 'Application not found.'], 404);
            }
            return Redirect::route('admin.distributor.index')->with('error', 'Application not found.');
        }

        $application->delete();

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => 'Application deleted successfully.']);
        }
        return Redirect::route('admin.distributor.index')->with('success', 'Application deleted successfully.');
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];
        if (!empty($ids)) {
            DistributorApplication::whereIn('id', $ids)->delete();
        }

        return response()->json(['status' => true, 'message' => 'Selected applications deleted successfully.']);
    }
}

