<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminSliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->get();

        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'bg_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $bgImagePath = null;
        if ($request->hasFile('bg_image')) {
            $file = $request->file('bg_image');
            $fileName = 'slider_bg_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/sliders');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $bgImagePath = 'uploads/sliders/' . $fileName;
        }

        $bookImagePath = null;
        if ($request->hasFile('book_image')) {
            $file = $request->file('book_image');
            $fileName = 'slider_book_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/sliders');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $bookImagePath = 'uploads/sliders/' . $fileName;
        }

        Slider::create([
            'title' => $request->title,
            'highlight_text' => $request->highlight_text,
            'subtitle' => $request->subtitle,
            'bg_image' => $bgImagePath,
            'book_image' => $bookImagePath,
            'button_text' => $request->button_text ?? 'Explore More',
            'button_link' => $request->button_link,
            'slider_type' => $request->slider_type ?? 'hero',
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.slider.index')->with('success', 'Slider created successfully.');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);

        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'bg_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $bgImagePath = $slider->bg_image;
        if ($request->hasFile('bg_image')) {
            $file = $request->file('bg_image');
            $fileName = 'slider_bg_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/sliders');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $bgImagePath = 'uploads/sliders/' . $fileName;
        }

        $bookImagePath = $slider->book_image;
        if ($request->hasFile('book_image')) {
            $file = $request->file('book_image');
            $fileName = 'slider_book_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/sliders');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $bookImagePath = 'uploads/sliders/' . $fileName;
        }

        $slider->update([
            'title' => $request->title,
            'highlight_text' => $request->highlight_text,
            'subtitle' => $request->subtitle,
            'bg_image' => $bgImagePath,
            'book_image' => $bookImagePath,
            'button_text' => $request->button_text ?? 'Explore More',
            'button_link' => $request->button_link,
            'slider_type' => $request->slider_type ?? 'hero',
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.slider.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy($id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            if (request()->ajax()) {
                return response()->json(['status' => false, 'message' => 'Slider not found.'], 404);
            }
            return Redirect::route('admin.slider.index')->with('error', 'Slider not found.');
        }

        if ($slider->bg_image && File::exists(public_path($slider->bg_image))) {
            File::delete(public_path($slider->bg_image));
        }
        if ($slider->book_image && File::exists(public_path($slider->book_image))) {
            File::delete(public_path($slider->book_image));
        }
        $slider->delete();

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => 'Slider deleted successfully.']);
        }
        return Redirect::route('admin.slider.index')->with('success', 'Slider deleted successfully.');
    }

    public function update_status(Request $request)
    {
        $id = $request->id ?? $request->slider_id;
        $slider = Slider::find($id);
        if (!$slider) {
            return response()->json(['status' => false, 'message' => 'Slider not found.'], 404);
        }

        $status = $request->has('is_active') ? $request->is_active : ($request->status ?? 0);
        $slider->is_active = $status ? 1 : 0;
        $slider->save();

        return response()->json([
            'status' => true,
            'message' => $slider->is_active ? 'Slider activated successfully.' : 'Slider deactivated successfully.'
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];
        if (!empty($ids)) {
            $sliders = Slider::whereIn('id', $ids)->get();
            foreach ($sliders as $s) {
                if ($s->bg_image && File::exists(public_path($s->bg_image))) {
                    File::delete(public_path($s->bg_image));
                }
                if ($s->book_image && File::exists(public_path($s->book_image))) {
                    File::delete(public_path($s->book_image));
                }
                $s->delete();
            }
        }

        return response()->json(['status' => true, 'message' => 'Selected sliders deleted successfully.']);
    }

    public function reorder(Request $request)
    {
        $order = $request->order ?? [];
        if (is_array($order)) {
            foreach ($order as $index => $item) {
                $id = is_array($item) ? ($item['id'] ?? null) : $item;
                $sort = is_array($item) ? ($item['sort_order'] ?? ($index + 1)) : ($index + 1);
                if ($id) {
                    Slider::where('id', $id)->update(['sort_order' => $sort]);
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Slider order updated successfully.']);
    }
}

