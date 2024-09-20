<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalDayInfo;
use Illuminate\Http\Request;

class AdditionalDayInfoController extends Controller
{
    public function getAdditionalDayInfo(Request $request)
    {
        $year = $request->year;
        $additionalDayInfo = AdditionalDayInfo::where('year', $year)->get();
        return response()->json(['data' => $additionalDayInfo]);
    }
}
