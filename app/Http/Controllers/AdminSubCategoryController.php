<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminSubCategoryController extends Controller
{
    /**
     * Display a listing of subcategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::with('category')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get();

        return view('admin.subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new subcategory.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->orderBy('category_name', 'ASC')->get();
        return view('admin.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created subcategory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'subcategory_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'subcategory_name.required' => 'Please enter sub category name.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/subcategories');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $file->move($destinationPath, $fileName);
            $imagePath = 'uploads/subcategories/' . $fileName;
        }

        SubCategory::create([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'image' => $imagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.subcategory.index')->with('success', 'Add Record Successfully');
    }

    /**
     * Show the form for editing the specified subcategory.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::orderBy('category_name', 'ASC')->get();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified subcategory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'subcategory_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'subcategory_name.required' => 'Please enter sub category name.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        $imagePath = $subcategory->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subcategory->image && File::exists(public_path($subcategory->image))) {
                File::delete(public_path($subcategory->image));
            }

            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/subcategories');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $file->move($destinationPath, $fileName);
            $imagePath = 'uploads/subcategories/' . $fileName;
        }

        $subcategory->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'image' => $imagePath,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.subcategory.index')->with('success', 'Update Record Successfully');
    }

    /**
     * Remove the specified subcategory from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);

        if (!$subcategory) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        // Delete image file if exists
        if ($subcategory->image && File::exists(public_path($subcategory->image))) {
            File::delete(public_path($subcategory->image));
        }

        $subcategory->delete();

        return response()->json(['status' => true, 'message' => 'Sub Category deleted successfully']);
    }

    /**
     * Delete multiple selected subcategories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:sub_categories,id',
        ]);

        $subcategories = SubCategory::whereIn('id', $request->ids)->get();

        foreach ($subcategories as $subcategory) {
            if ($subcategory->image && File::exists(public_path($subcategory->image))) {
                File::delete(public_path($subcategory->image));
            }
            $subcategory->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Selected records deleted successfully!'
        ]);
    }

    /**
     * Update active status via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request)
    {
        $request->validate([
            'subcategory_id' => 'required|integer|exists:sub_categories,id',
            'is_active' => 'required|boolean',
        ]);

        $subcategory = SubCategory::find($request->subcategory_id);

        if (!$subcategory) {
            return response()->json(['status' => false, 'message' => 'Sub Category not found'], 404);
        }

        $subcategory->is_active = $request->is_active;
        $subcategory->save();

        return response()->json([
            'status' => true,
            'message' => $subcategory->is_active ? 'Activated' : 'Deactivated'
        ]);
    }

    public function reorder(Request $request)
    {
        $order = $request->order ?? [];
        if (is_array($order)) {
            foreach ($order as $index => $item) {
                $id = is_array($item) ? ($item['id'] ?? null) : $item;
                $sort = is_array($item) ? ($item['sort_order'] ?? ($index + 1)) : ($index + 1);
                if ($id) {
                    SubCategory::where('id', $id)->update(['sort_order' => $sort]);
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Sub Category order updated successfully.']);
    }
}

