<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Panchangam;
use App\Models\PanchangamDailyBreif;
use App\Models\Hora;
use Illuminate\Http\Request;

class PanchangamController extends Controller
{
    public function getPanchangam(Request $request)
    {
        $date = $request->date;
        $panchangam = Panchangam::where("created_at", $date)->get();
        return response()->json(['pdata' => $panchangam]);
    }

     public function getGowriPanchangam(Request $request)
    {
        $date = $request->date;
$dayPanchangam = Hora::where("horadate", $date)->where('horatype', "panchangam_day")->get();
$nightPanchangam = Hora::where("horadate", $date)->where('horatype', "panchangam_night")->get();
        return response()->json(['day_info' => $dayPanchangam, 'night_info' => $nightPanchangam]);
    }

     public function getHora(Request $request)
    {
        $date = $request->date;
        $dayHora = Hora::where("horadate", $date)->where('horatype', "hora_day")->get();
        $nightHora= Hora::where("horadate", $date)->where('horatype', "hora_night")->get();;
        
        return response()->json(['day_info' => $dayHora, 'night_info' => $nightHora]);
    }


    public function getPanchangamAdditonal(Request $request)
    {
        $date = $request->date;
        $panchangam = PanchangamDailyBreif::where("pdate", $date)->get();
        $finalArr = [];
         foreach($panchangam as $pobj) {
            if($pobj->CategoryName == "இன்றைக்கு பஞ்சாங்கம்"){
                $finalArr[$pobj->CategoryName][] = $pobj;
            }else if($pobj->CategoryName == "சூரியன் மற்றும் சந்திரன் கணக்கீடுகள்"){
                $finalArr[$pobj->CategoryName][] = $pobj;
            }else if($pobj->CategoryName == "இந்து சந்திர தேதி"){
                $finalArr[$pobj->CategoryName][] = $pobj;
            }else if($pobj->CategoryName == "மங்கள நேரம்"){
                $finalArr[$pobj->CategoryName][] = $pobj;
            }else if($pobj->CategoryName == "திஷ ஸூல"){
                $finalArr[$pobj->CategoryName][] = $pobj;
            }else if($pobj->CategoryName == "சந்திரபலம் மற்றும் தரபலம்"){
                $finalArr[$pobj->CategoryName][] = $pobj;
            }else {

            }
        }
    //return $return;
        return response()->json(['data' => $finalArr]);
    }
}
