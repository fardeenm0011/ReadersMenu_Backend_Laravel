<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RasiDaily;
use App\Models\Rasi;
use Illuminate\Http\Request;

class RasiDailyController extends Controller
{
    public function getDailyRasi(Request $request)
    {
        $id = $request->id;
        $date = $request->date;
        $dailyRasi = RasiDaily::where('rasi_id', $id)->where('rasi_date', $date)->get();
        return response()->json(['data' => $dailyRasi]);
    }
    public function getAllDailyRasi(Request $request)
    {
        $date = $request->date;
        $dailyRasi = RasiDaily::join('rasi', 'rasi_daily.rasi_id', '=', 'rasi.id')->select('rasi_daily.*', 'rasi.name as rasi_name')->where('rasi_date', $date)->get();
        return response()->json(['data' => $dailyRasi]);
    }
}
