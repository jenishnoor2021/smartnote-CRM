<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminTeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->get();

        return view('admin.team.index', compact('members'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'team_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/team');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $imagePath = 'uploads/team/' . $fileName;
        }

        TeamMember::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'image' => $imagePath,
            'quote' => $request->quote,
            'bio' => $request->bio,
            'phone' => $request->phone,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'linkedin' => $request->linkedin ?? $request->linkedin_url,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'is_leadership' => $request->has('is_leadership') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.team.index')->with('success', 'Team member added successfully.');
    }

    public function edit($id)
    {
        $member = TeamMember::findOrFail($id);

        return view('admin.team.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $imagePath = $member->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'team_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/team');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $imagePath = 'uploads/team/' . $fileName;
        }

        $member->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'image' => $imagePath,
            'quote' => $request->quote,
            'bio' => $request->bio,
            'phone' => $request->phone,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'linkedin' => $request->linkedin ?? $request->linkedin_url,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'is_leadership' => $request->has('is_leadership') ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy($id)
    {
        $member = TeamMember::find($id);
        if (!$member) {
            if (request()->ajax()) {
                return response()->json(['status' => false, 'message' => 'Team member not found.'], 404);
            }
            return Redirect::route('admin.team.index')->with('error', 'Team member not found.');
        }

        if ($member->image && File::exists(public_path($member->image))) {
            File::delete(public_path($member->image));
        }
        $member->delete();

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => 'Team member deleted successfully.']);
        }
        return Redirect::route('admin.team.index')->with('success', 'Team member deleted successfully.');
    }

    public function update_status(Request $request)
    {
        $id = $request->id ?? $request->team_id;
        $member = TeamMember::find($id);
        if (!$member) {
            return response()->json(['status' => false, 'message' => 'Team member not found.'], 404);
        }

        $status = $request->has('is_active') ? $request->is_active : ($request->status ?? 0);
        $member->is_active = $status ? 1 : 0;
        $member->save();

        return response()->json([
            'status' => true,
            'message' => $member->is_active ? 'Team member activated successfully.' : 'Team member deactivated successfully.'
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];
        if (!empty($ids)) {
            $members = TeamMember::whereIn('id', $ids)->get();
            foreach ($members as $m) {
                if ($m->image && File::exists(public_path($m->image))) {
                    File::delete(public_path($m->image));
                }
                $m->delete();
            }
        }

        return response()->json(['status' => true, 'message' => 'Selected team members deleted successfully.']);
    }

    public function reorder(Request $request)
    {
        $order = $request->order ?? [];
        if (is_array($order)) {
            foreach ($order as $index => $item) {
                $id = is_array($item) ? ($item['id'] ?? null) : $item;
                $sort = is_array($item) ? ($item['sort_order'] ?? ($index + 1)) : ($index + 1);
                if ($id) {
                    TeamMember::where('id', $id)->update(['sort_order' => $sort]);
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Team members order updated successfully.']);
    }
}

