<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BaseSetting;

class BaseSettingController extends Controller
{
    public function index()
    {
        $title = "BaseSetting";
        $description = "Some description for the page";
        return view('pages.baseSetting.baseSetting', compact('title', 'description'));
    }

    public function saveSetting(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'siteTitle' => 'required|string|max:255',
            'seoTitle' => 'required|string|max:255',
            'seoKeyword' => 'required|string',
            'seoDescription' => 'required|string',
            'email' => 'required|email|max:255',
            'phoneNumber' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'site_logo' => 'nullable|file|image|max:2048', // Adjust as per your file requirements
            'site_favicon' => 'nullable|file|mimes:jpeg,png,bmp,gif,svg,webp,ico|max:2048',
            'facebookUrl' => 'required|string|max:255',
            'twitterUrl' => 'required|string|max:255',
            'instagramUrl' => 'required|string|max:255',
            'googleUrl' => 'required|string|max:255',
            'linkedinUrl' => 'required|string|max:255',
            'telegramUrl' => 'required|string|max:255',
            'whatsappUrl' => 'required|string|max:255',
        ]);

        // Handle file uploads
        $siteLogo = $request->file('site_logo');
        $siteFavicon = $request->file('site_favicon');

        // Define the paths
        $logoPath = $siteLogo->getClientOriginalName();
        $faviconPath = $siteFavicon->getClientOriginalName();

        // Move the files to public/images/logos and public/images/favicons
        $siteLogo->move(public_path('images/setting'), $siteLogo->getClientOriginalName());
        $siteFavicon->move(public_path('images/setting'), $siteFavicon->getClientOriginalName());
        // Extract file names from paths if needed
        $siteLogoName = basename($logoPath);
        $siteFaviconName = basename($faviconPath);

        // Create BaseSetting record
        BaseSetting::create([
            'site_title' => $validatedData['siteTitle'],
            'seo_title' => $validatedData['seoTitle'],
            'seo_keyword' => $validatedData['seoKeyword'],
            'seo_description' => $validatedData['seoDescription'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phoneNumber'],
            'address' => $validatedData['address'],
            'site_logo' => $siteLogoName, // Store file name in database
            'site_favicon' => $siteFaviconName, // Store file name in database
            'social_fb' => $validatedData['facebookUrl'],
            'social_twitter' => $validatedData['twitterUrl'],
            'social_insta' => $validatedData['instagramUrl'],
            'social_google' => $validatedData['googleUrl'],
            'social_linkedin' => $validatedData['linkedinUrl'],
            'social_telegram' => $validatedData['telegramUrl'],
            'social_whatsapp' => $validatedData['whatsappUrl'],
        ]);

        // Optionally, you can return a response indicating success
        return redirect()->back()->with('success', 'Settings saved successfully!');
    }

    //-----------------------------------------API---------------------------------------------------//

    public function save(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'site_title' => 'required|string|max:255',
            'seo_title' => 'required|string|max:255',
            'seo_keyword' => 'required|string|max:255',
            'seo_description' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'site_logo' => 'nullable|file|image|max:2048', // Adjust as per your file requirements
            'site_favicon' => 'nullable|file|image|max:2048', // Adjust as per your file requirements
            'social_fb' => 'required|string|max:255',
            'social_twitter' => 'required|string|max:255',
            'social_insta' => 'required|string|max:255',
            'social_google' => 'required|string|max:255',
            'social_linkedin' => 'required|string|max:255',
            'social_telegram' => 'required|string|max:255',
            'social_whatsapp' => 'required|string|max:255',
        ]);

        // Handle file uploads if provided
        if ($request->hasFile('site_logo')) {
            $imageFile = $request->file('site_logo');
            $imageName = $imageFile->getClientOriginalName();
            $request->file('site_logo')->move(public_path('images'), $imageName);
            $validatedData['site_logo'] = $imageName;
        }

        if ($request->hasFile('site_favicon')) {
            $imageFile = $request->file('site_favicon');
            $imageName = $imageFile->getClientOriginalName();
            $request->file('site_favicon')->move(public_path('images'), $imageName);
            $validatedData['site_favicon'] = $imageName;
        }

        // Find or create BaseSetting record
        $baseSetting = BaseSetting::find(1);
        if (!$baseSetting) {
            $baseSetting = new BaseSetting();
        }

        // Update the attributes
        $baseSetting->fill($validatedData);
        $baseSetting->save();

        // Return success response
        return response()->json(['success' => 'Settings saved successfully!']);
    }



    public function getSetting()
    {
        $setting = BaseSetting::find(1);
        if ($setting == null)
            return response()->json($setting);
        return response()->json($setting);
    }
}
