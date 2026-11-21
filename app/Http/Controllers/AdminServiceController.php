<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->get();

        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'icon' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        while (Service::where('slug', $slug)->exists()) {
            $slug .= '-' . rand(10, 99);
        }

        Service::create([
            'title' => $request->title,
            'slug' => $slug,
            'icon' => $request->icon,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'features' => $request->features,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.service.index')->with('success', 'Service added successfully.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $id,
            'icon' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
        while (Service::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug .= '-' . rand(10, 99);
        }

        $service->update([
            'title' => $request->title,
            'slug' => $slug,
            'icon' => $request->icon,
            'short_description' => $request->short_description,
            'content' => $request->content,
            'features' => $request->features,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return Redirect::route('admin.service.index')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if (!$service) {
            if (request()->ajax()) {
                return response()->json(['status' => false, 'message' => 'Service not found.'], 404);
            }
            return Redirect::route('admin.service.index')->with('error', 'Service not found.');
        }

        $service->delete();

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => 'Service deleted successfully.']);
        }
        return Redirect::route('admin.service.index')->with('success', 'Service deleted successfully.');
    }

    public function update_status(Request $request)
    {
        $id = $request->id ?? $request->service_id;
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['status' => false, 'message' => 'Service not found.'], 404);
        }

        $status = $request->has('is_active') ? $request->is_active : ($request->status ?? 0);
        $service->is_active = $status ? 1 : 0;
        $service->save();

        return response()->json([
            'status' => true,
            'message' => $service->is_active ? 'Service activated successfully.' : 'Service deactivated successfully.'
        ]);
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids ?? [];
        if (!empty($ids)) {
            Service::whereIn('id', $ids)->delete();
        }

        return response()->json(['status' => true, 'message' => 'Selected services deleted successfully.']);
    }

    public function reorder(Request $request)
    {
        $order = $request->order ?? [];
        if (is_array($order)) {
            foreach ($order as $index => $item) {
                $id = is_array($item) ? ($item['id'] ?? null) : $item;
                $sort = is_array($item) ? ($item['sort_order'] ?? ($index + 1)) : ($index + 1);
                if ($id) {
                    Service::where('id', $id)->update(['sort_order' => $sort]);
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Services order updated successfully.']);
    }
}

