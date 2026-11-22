<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminProductController extends Controller
{
    /**
     * Display a listing of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['category', 'subcategory'])
            ->orderBy('id', 'DESC')
            ->get();    

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('is_active', 1)->orderBy('category_name', 'ASC')->get();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * AJAX endpoint to get subcategories for a given category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubcategories(Request $request)
    {
        $categoryId = $request->get('category_id');
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->where('is_active', 1)
            ->orderBy('subcategory_name', 'ASC')
            ->get(['id', 'subcategory_name']);

        return response()->json([
            'status' => true,
            'data' => $subcategories
        ]);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'subcategory_id' => 'nullable|integer|exists:sub_categories,id',
            'product_name' => 'required|string|max:255',
            'product_code' => 'nullable|string|max:100',
            'author_publisher' => 'nullable|string|max:255',
            'medium' => 'nullable|string|max:100',
            'subject' => 'nullable|string|max:100',
            'standard_class' => 'nullable|string|max:100',
            'mrp_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'stock_quantity' => 'nullable|integer|min:0',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'category_id.required' => 'Please select a category.',
            'product_name.required' => 'Please enter product name.',
            'selling_price.required' => 'Please enter selling price.',
            'cover_image.required' => 'Cover image is required.',
            'cover_image.image' => 'Cover file must be a valid image.',
            'cover_image.mimes' => 'Cover image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'cover_image.max' => 'Cover image size must not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        // Upload Cover Image
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/products/cover');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $coverImagePath = 'uploads/products/cover/' . $fileName;
        }

        // Create Product
        $product = Product::create([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'author_publisher' => $request->author_publisher,
            'medium' => $request->medium,
            'subject' => $request->subject,
            'standard_class' => $request->standard_class,
            'mrp_price' => $request->mrp_price ?? 0,
            'selling_price' => $request->selling_price,
            'unit' => $request->unit ?? 'pcs',
            'stock_quantity' => $request->stock_quantity ?? 0,
            'is_in_stock' => $request->has('is_in_stock') ? 1 : 0,
            'cover_image' => $coverImagePath,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'key_features' => $request->key_features,
            'learning_benefits' => $request->learning_benefits,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'created_by' => Auth::id(),
        ]);

        // Upload Gallery Images
        if ($request->hasFile('gallery_images')) {
            $galleryDest = public_path('uploads/products/gallery');
            if (!File::isDirectory($galleryDest)) {
                File::makeDirectory($galleryDest, 0755, true, true);
            }
            foreach ($request->file('gallery_images') as $index => $gFile) {
                $gFileName = time() . '_' . uniqid() . '.' . $gFile->getClientOriginalExtension();
                $gFile->move($galleryDest, $gFileName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'uploads/products/gallery/' . $gFileName,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Add Record Successfully');
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::orderBy('category_name', 'ASC')->get();
        $subcategories = SubCategory::where('category_id', $product->category_id)->orderBy('subcategory_name', 'ASC')->get();

        return view('admin.product.edit', compact('product', 'categories', 'subcategories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $input = $request->all();

        // If product has no cover image yet, require it; otherwise optional on update
        $coverRule = empty($product->cover_image)
            ? 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
            : 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'subcategory_id' => 'nullable|integer|exists:sub_categories,id',
            'product_name' => 'required|string|max:255',
            'product_code' => 'nullable|string|max:100',
            'author_publisher' => 'nullable|string|max:255',
            'medium' => 'nullable|string|max:100',
            'subject' => 'nullable|string|max:100',
            'standard_class' => 'nullable|string|max:100',
            'mrp_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'stock_quantity' => 'nullable|integer|min:0',
            'cover_image' => $coverRule,
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'category_id.required' => 'Please select a category.',
            'product_name.required' => 'Please enter product name.',
            'selling_price.required' => 'Please enter selling price.',
            'cover_image.required' => 'Cover image is required.',
            'cover_image.image' => 'Cover file must be a valid image.',
            'cover_image.mimes' => 'Cover image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'cover_image.max' => 'Cover image size must not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($input)->withErrors($validator);
        }

        // Handle Cover Image
        $coverImagePath = $product->cover_image;
        if ($request->hasFile('cover_image')) {
            if ($product->cover_image && File::exists(public_path($product->cover_image))) {
                File::delete(public_path($product->cover_image));
            }

            $file = $request->file('cover_image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/products/cover');
            if (!File::isDirectory($dest)) {
                File::makeDirectory($dest, 0755, true, true);
            }
            $file->move($dest, $fileName);
            $coverImagePath = 'uploads/products/cover/' . $fileName;
        }

        // Update product
        $product->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'author_publisher' => $request->author_publisher,
            'medium' => $request->medium,
            'subject' => $request->subject,
            'standard_class' => $request->standard_class,
            'mrp_price' => $request->mrp_price ?? 0,
            'selling_price' => $request->selling_price,
            'unit' => $request->unit ?? 'pcs',
            'stock_quantity' => $request->stock_quantity ?? 0,
            'is_in_stock' => $request->has('is_in_stock') ? 1 : 0,
            'cover_image' => $coverImagePath,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'key_features' => $request->key_features,
            'learning_benefits' => $request->learning_benefits,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        // Upload New Gallery Images
        if ($request->hasFile('gallery_images')) {
            $galleryDest = public_path('uploads/products/gallery');
            if (!File::isDirectory($galleryDest)) {
                File::makeDirectory($galleryDest, 0755, true, true);
            }
            $existingCount = $product->images()->count();
            foreach ($request->file('gallery_images') as $index => $gFile) {
                $gFileName = time() . '_' . uniqid() . '.' . $gFile->getClientOriginalExtension();
                $gFile->move($galleryDest, $gFileName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'uploads/products/gallery/' . $gFileName,
                    'sort_order' => $existingCount + $index,
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Update Record Successfully');
    }

    /**
     * AJAX endpoint to delete a single gallery image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteGalleryImage($id)
    {
        $image = ProductImage::find($id);

        if (!$image) {
            return response()->json(['status' => false, 'message' => 'Image not found'], 404);
        }

        if (File::exists(public_path($image->image))) {
            File::delete(public_path($image->image));
        }

        $image->delete();

        return response()->json([
            'status' => true,
            'message' => 'Gallery image deleted successfully'
        ]);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::with('images')->find($id);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        }

        // Delete Cover Image
        if ($product->cover_image && File::exists(public_path($product->cover_image))) {
            File::delete(public_path($product->cover_image));
        }

        // Delete Gallery Images
        foreach ($product->images as $galleryImg) {
            if ($galleryImg->image && File::exists(public_path($galleryImg->image))) {
                File::delete(public_path($galleryImg->image));
            }
            $galleryImg->delete();
        }

        $product->delete();

        return response()->json(['status' => true, 'message' => 'Product deleted successfully']);
    }

    /**
     * Delete multiple selected products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:products,id',
        ]);

        $products = Product::with('images')->whereIn('id', $request->ids)->get();

        foreach ($products as $product) {
            if ($product->cover_image && File::exists(public_path($product->cover_image))) {
                File::delete(public_path($product->cover_image));
            }

            foreach ($product->images as $galleryImg) {
                if ($galleryImg->image && File::exists(public_path($galleryImg->image))) {
                    File::delete(public_path($galleryImg->image));
                }
                $galleryImg->delete();
            }

            $product->delete();
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
            'product_id' => 'required|integer|exists:products,id',
            'is_active' => 'required|boolean',
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        $product->is_active = $request->is_active;
        $product->save();

        return response()->json([
            'status' => true,
            'message' => $product->is_active ? 'Activated' : 'Deactivated'
        ]);
    }
}

