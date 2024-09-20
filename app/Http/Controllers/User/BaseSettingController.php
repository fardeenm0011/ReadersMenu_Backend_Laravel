<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BaseSetting;

class BaseSettingController extends Controller
{
    public function index()
    {
        $baseSetting = BaseSetting::all()->first();
        return response()->json(['title' => $baseSetting->seo_title, 'keywords' => $baseSetting->seo_keyword, 'description' => $baseSetting->seo_description]);
    }
}
