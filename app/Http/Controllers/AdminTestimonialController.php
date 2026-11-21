<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->get();

        return view('admin.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonial.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $avatarPath = null;
        $imageFile = $request->file('avatar') ?? $request->file('image');
        if ($imageFile) {
            $fileName = 'testi_' . time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $dest = public_path('uploads/testimonials');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $imageFile->move($dest, $fileName);
            $avatarPath = 'uploads/testimonials/' . $fileName;
        }

        $institution = $request->school_name ?? $request->institution;

        Testimonial::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'institution' => $institution,
            'school_name' => $institution,
            'avatar' => $avatarPath,
            'image' => $avatarPath,
            'rating' => $request->rating ?? 5,
            'review' => $request->review,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.testimonial.index')->with('success', 'Review added successfully.');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        return view('admin.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $avatarPath = $testimonial->avatar ?? $testimonial->image;
        $imageFile = $request->file('avatar') ?? $request->file('image');
        if ($imageFile) {
            $fileName = 'testi_' . time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $dest = public_path('uploads/testimonials');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $imageFile->move($dest, $fileName);
            $avatarPath = 'uploads/testimonials/' . $fileName;
        }

        $institution = $request->school_name ?? $request->institution;

        $testimonial->update([
            'name' => $request->name,
            'designation' => $request->designation,
            'institution' => $institution,
            'school_name' => $institution,
            'avatar' => $avatarPath,
            'image' => $avatarPath,
            'rating' => $request->rating ?? 5,
            'review' => $request->review,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.testimonial.index')->with('success', 'Review updated successfully.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            if (request()->ajax()) {
                return response()->json(['status' => false, 'message' => 'Review not found.'], 404);
            }
            return Redirect::route('admin.testimonial.index')->with('error', 'Review not found.');
        }

        $imgPath = $testimonial->image ?? $testimonial->avatar;
        if ($imgPath && File::exists(public_path($imgPath))) {
            File::delete(public_path($imgPath));
        }
        $testimonial->delete();

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => 'Review deleted successfully.']);
        }
        return Redirect::route('admin.testimonial.index')->with('success', 'Review deleted successfully.');
    }

    public function update_status(Request $request)
    {
        $id = $request->id ?? $request->testimonial_id;
        $testimonial = Testimonial::find($id);
        if (!$testimonial) {
            return response()->json(['status' => false, 'message' => 'Review not found.'], 404);
        }

        $status = $request->has('is_active') ? $request->is_active : ($request->status ?? 0);
        $testimonial->is_active = $status ? 1 : 0;
        $testimonial->save();

        return response()->json([
            'status' => true,
            'message' => $testimonial->is_active ? 'Review activated successfully.' : 'Review deactivated successfully.'
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];
        if (!empty($ids)) {
            $testimonials = Testimonial::whereIn('id', $ids)->get();
            foreach ($testimonials as $t) {
                if ($t->image && File::exists(public_path($t->image))) {
                    File::delete(public_path($t->image));
                }
                $t->delete();
            }
        }

        return response()->json(['status' => true, 'message' => 'Selected reviews deleted successfully.']);
    }

    public function reorder(Request $request)
    {
        $order = $request->order ?? [];
        if (is_array($order)) {
            foreach ($order as $index => $item) {
                $id = is_array($item) ? ($item['id'] ?? null) : $item;
                $sort = is_array($item) ? ($item['sort_order'] ?? ($index + 1)) : ($index + 1);
                if ($id) {
                    Testimonial::where('id', $id)->update(['sort_order' => $sort]);
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Reviews order updated successfully.']);
    }
}

