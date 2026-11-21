<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'title' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'gal_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/gallery');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $imagePath = 'uploads/gallery/' . $fileName;
        }

        Gallery::create([
            'title' => $request->title,
            'category' => $request->category,
            'image' => $imagePath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.gallery.index')->with('success', 'Gallery image uploaded successfully.');
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);

        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'title' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $imagePath = $gallery->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'gal_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/gallery');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $imagePath = 'uploads/gallery/' . $fileName;
        }

        $gallery->update([
            'title' => $request->title,
            'category' => $request->category,
            'image' => $imagePath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.gallery.index')->with('success', 'Gallery image updated successfully.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        if (!$gallery) {
            if (request()->ajax()) {
                return response()->json(['status' => false, 'message' => 'Image not found.'], 404);
            }
            return Redirect::route('admin.gallery.index')->with('error', 'Image not found.');
        }

        if ($gallery->image && File::exists(public_path($gallery->image))) {
            File::delete(public_path($gallery->image));
        }
        $gallery->delete();

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => 'Gallery image deleted successfully.']);
        }
        return Redirect::route('admin.gallery.index')->with('success', 'Gallery image deleted successfully.');
    }

    public function update_status(Request $request)
    {
        $id = $request->id ?? $request->gallery_id;
        $gallery = Gallery::find($id);
        if (!$gallery) {
            return response()->json(['status' => false, 'message' => 'Gallery item not found.'], 404);
        }

        $status = $request->has('is_active') ? $request->is_active : ($request->status ?? 0);
        $gallery->is_active = $status ? 1 : 0;
        $gallery->save();

        return response()->json([
            'status' => true,
            'message' => $gallery->is_active ? 'Gallery image activated successfully.' : 'Gallery image deactivated successfully.'
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];
        if (!empty($ids)) {
            $galleries = Gallery::whereIn('id', $ids)->get();
            foreach ($galleries as $g) {
                if ($g->image && File::exists(public_path($g->image))) {
                    File::delete(public_path($g->image));
                }
                $g->delete();
            }
        }

        return response()->json(['status' => true, 'message' => 'Selected images deleted successfully.']);
    }

    public function reorder(Request $request)
    {
        $order = $request->order ?? [];
        if (is_array($order)) {
            foreach ($order as $index => $item) {
                $id = is_array($item) ? ($item['id'] ?? null) : $item;
                $sort = is_array($item) ? ($item['sort_order'] ?? ($index + 1)) : ($index + 1);
                if ($id) {
                    Gallery::where('id', $id)->update(['sort_order' => $sort]);
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Gallery images order updated successfully.']);
    }
}

