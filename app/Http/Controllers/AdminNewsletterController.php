<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminNewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::orderBy('id', 'DESC');

        if ($request->filled('search')) {
            $query->where('email', 'like', "%" . trim($request->search) . "%");
        }

        $limit = intval($request->get('limit', 25));
        if (!in_array($limit, [10, 25, 50, 100])) {
            $limit = 25;
        }

        $subscribers = $query->paginate($limit)->appends($request->all());

        return view('admin.newsletter.index', compact('subscribers'));
    }

    public function destroy($id)
    {
        $sub = NewsletterSubscriber::find($id);
        if (!$sub) {
            if (request()->ajax()) {
                return response()->json(['status' => false, 'message' => 'Subscriber not found.'], 404);
            }
            return Redirect::route('admin.newsletter.index')->with('error', 'Subscriber not found.');
        }

        $sub->delete();

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => 'Subscriber removed successfully.']);
        }
        return Redirect::route('admin.newsletter.index')->with('success', 'Subscriber removed successfully.');
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];
        if (!empty($ids)) {
            NewsletterSubscriber::whereIn('id', $ids)->delete();
        }

        return response()->json(['status' => true, 'message' => 'Selected subscribers deleted successfully.']);
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::orderBy('id', 'DESC')->get();
        $filename = "subscribers_" . date('Y-m-d') . ".csv";

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['ID', 'Email', 'Status', 'Subscribed At']);

        foreach ($subscribers as $s) {
            fputcsv($handle, [$s->id, $s->email, $s->status, $s->created_at ? $s->created_at->format('Y-m-d H:i:s') : '']);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}

