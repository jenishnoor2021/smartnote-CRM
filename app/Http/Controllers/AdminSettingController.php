<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class AdminSettingController extends Controller
{
    /**
     * Display the site settings form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        return view('admin.setting.index', compact('settings'));
    }

    /**
     * Update the site settings in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', 'header_logo', 'footer_logo', 'mobile_logo', 'favicon']);

        // Handle File Uploads
        $fileKeys = ['header_logo', 'footer_logo', 'mobile_logo', 'favicon'];
        foreach ($fileKeys as $fKey) {
            if ($request->hasFile($fKey)) {
                $file = $request->file($fKey);
                $fileName = $fKey . '_' . time() . '.' . $file->getClientOriginalExtension();
                $dest = public_path('uploads/settings');
                if (!File::isDirectory($dest)) {
                    File::makeDirectory($dest, 0755, true, true);
                }
                $file->move($dest, $fileName);
                $data[$fKey] = 'uploads/settings/' . $fileName;
            }
        }

        foreach ($data as $key => $val) {
            SiteSetting::set($key, $val);
        }

        return Redirect::route('admin.setting.index')->with('success', 'Site settings updated successfully.');
    }
}

