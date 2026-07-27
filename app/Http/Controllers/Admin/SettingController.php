<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $categories = \App\Models\Category::where('status', true)->whereNull('parent_id')->get();
        return view('admin.settings', compact('categories'));
    }

    /**
     * Update the website settings.
     */
    public function update(Request $request)
    {
        $formType = $request->input('form_type');

        if ($formType === 'general') {
            $request->validate([
                'website_name' => 'required|string|max:255',
                'footer_copyright' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
                'favicon' => 'nullable|file|mimes:png,ico|max:512',
            ]);

            Setting::set('website_name', $request->input('website_name'));
            Setting::set('footer_copyright', $request->input('footer_copyright'));

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('settings', 'public');
                Setting::set('logo', '/storage/' . $path);
            }
            if ($request->hasFile('favicon')) {
                $path = $request->file('favicon')->store('settings', 'public');
                Setting::set('favicon', '/storage/' . $path);
            }
        } elseif ($formType === 'contact') {
            $request->validate([
                'phone' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:100',
                'address' => 'nullable|string',
            ]);

            Setting::set('phone', $request->input('phone'));
            Setting::set('email', $request->input('email'));
            Setting::set('address', $request->input('address'));
        } elseif ($formType === 'social') {
            // Replaced 'url' with 'string' to allow '#' or other placeholder links
            $request->validate([
                'facebook' => 'nullable|string',
                'youtube' => 'nullable|string',
                'instagram' => 'nullable|string',
                'twitter' => 'nullable|string',
                'telegram' => 'nullable|string',
            ]);

            Setting::set('facebook', $request->input('facebook'));
            Setting::set('youtube', $request->input('youtube'));
            Setting::set('instagram', $request->input('instagram'));
            Setting::set('twitter', $request->input('twitter'));
            Setting::set('telegram', $request->input('telegram'));
        } elseif ($formType === 'seo') {
            $request->validate([
                'google_analytics_id' => 'nullable|string|max:100',
                'facebook_pixel_id' => 'nullable|string|max:100',
                'default_seo_title' => 'nullable|string|max:255',
                'default_seo_description' => 'nullable|string',
                'default_seo_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            Setting::set('google_analytics_id', $request->input('google_analytics_id'));
            Setting::set('facebook_pixel_id', $request->input('facebook_pixel_id'));
            Setting::set('default_seo_title', $request->input('default_seo_title'));
            Setting::set('default_seo_description', $request->input('default_seo_description'));

            if ($request->hasFile('default_seo_image')) {
                $path = $request->file('default_seo_image')->store('settings', 'public');
                Setting::set('default_seo_image', '/storage/' . $path);
            }
        } elseif ($formType === 'features') {
            $request->validate([
                'homepage_categories' => 'nullable|array',
                'tech_category' => 'nullable|string|max:100',
            ]);

            Setting::set('tech_category', $request->input('tech_category'));

            if ($request->has('homepage_categories')) {
                Setting::set('homepage_categories', json_encode($request->input('homepage_categories')));
            } else {
                Setting::set('homepage_categories', json_encode([]));
            }

            Setting::set('breaking_news_status', $request->has('breaking_news_status') ? '1' : '0');
            Setting::set('comments_status', $request->has('comments_status') ? '1' : '0');
            Setting::set('registration_status', $request->has('registration_status') ? '1' : '0');
        } else {
            // Fallback for single large form (legacy support just in case)
            $textFields = [
                'website_name', 'phone', 'email', 'address', 'facebook', 'youtube',
                'instagram', 'twitter', 'telegram', 'google_analytics_id', 'facebook_pixel_id',
                'default_seo_title', 'default_seo_description', 'footer_copyright', 'tech_category'
            ];
            foreach ($textFields as $field) {
                if ($request->has($field)) {
                    Setting::set($field, $request->input($field));
                }
            }
            if ($request->has('homepage_categories')) {
                Setting::set('homepage_categories', json_encode($request->input('homepage_categories')));
            }
            Setting::set('breaking_news_status', $request->has('breaking_news_status') ? '1' : '0');
            Setting::set('comments_status', $request->has('comments_status') ? '1' : '0');
            Setting::set('registration_status', $request->has('registration_status') ? '1' : '0');
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
