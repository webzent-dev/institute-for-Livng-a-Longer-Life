<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebSetting; 
use Illuminate\Support\Facades\Storage;

class WebSettingsController extends Controller
{
    public function updateSettings(Request $request)
    {
        // Validation
        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'footer_content' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'logo_content' => 'nullable|string',
        ]);


        // Get the single row
        $settings = WebSetting::find(1);

        if (!$settings) {
            // If somehow row doesn't exist, create it
            $settings = new WebSetting();
            $settings->id = 1;
        }

        
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo && Storage::exists($settings->logo)) {
                Storage::delete($settings->logo);
            }

            $settings->logo = $request->file('logo')->store('logos', 'public');
        }

        
        $settings->phone = $request->phone;
        $settings->email = $request->email;
        $settings->address = $request->address;
        $settings->footer_content = $request->footer_content;
        $settings->facebook = $request->facebook;
        $settings->twitter = $request->twitter;
        $settings->instagram = $request->instagram;
        $settings->linkedin = $request->linkedin;
        $settings->logo_content = $request->logo_content;

        $settings->save();

        return redirect()->back()->with('success', 'Website settings updated successfully!');
    }
    
    public function editSettings()
    {
        $settings = WebSetting::find(1);
        return view('admin.web_settings', compact('settings'));
    }
    
    public function websettings()
    {
        return view('admin.dashboard.websettings');
    }

}
