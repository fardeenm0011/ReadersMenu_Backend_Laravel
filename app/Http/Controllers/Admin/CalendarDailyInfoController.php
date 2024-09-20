<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalendarDailyInfo;
use App\Models\RasiDaily;
use App\Models\Holidays;
use App\Models\Panchangam;
use App\Models\CalendarImages;
use App\Models\SpecialDays;
use App\Models\ReligionFestival;
use App\Models\CalendarAdditional;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Resources\CalendarDailyInfoResource;
use Illuminate\Http\Request;

class CalendarDailyInfoController extends Controller
{
    public function getCalendarDaily(Request $request)
    {
        $date = $request->date;
        $calendarDaily = CalendarDailyInfo::where("created_date", $date)->get();
        return response()->json($calendarDaily);
    }

    public function getTamEngDates(Request $request){

        $date = $request->date;
        $calendarDaily = CalendarDailyInfo::select('tdate','tmonth')->where('created_date',$date)->get();
         return response()->json(['tamilDate' => $calendarDaily[0]->tdate.", ".$calendarDaily[0]->tmonth]);

    }

    public function checkMorning ($checkStr){
        if(strpos($checkStr, "AM")){
            return true;
        }
        return false;
    }

     public function checkEvening ($checkStr){
        if(strpos($checkStr, "AM")){
            return false;
        }
        if(strpos($checkStr, "PM")){
            return true;
        }
        return false;
    }

    public function getAllInfo(Request $request)
    {
        $date = $request->date;
        $rasiDaily = RasiDaily::where("rasi_date", $date)->get();
        $panchangam = Panchangam::where("created_at", $date)->get();
        $calendarDaily = CalendarDailyInfo::where("created_date", $date)->get();

        $customizedData = json_decode($calendarDaily[0]->day_inauspicioustime);
//echo $customizedData->rahu;exit;

// if(strpos($customizedData->rahu, "AM")){

// }
$find = array("AM","PM");
$replace = array("");

    $dataU = ["ragu_m" => $this->checkMorning($customizedData->rahu) ? str_replace($find, $replace, $customizedData->rahu) : "", 
    "ragu_e"=> $this->checkEvening($customizedData->rahu) ? str_replace($find, $replace, $customizedData->rahu) : "", 
    "yama_m"=> $this->checkMorning($customizedData->yama) ? str_replace($find, $replace,$customizedData->yama) : "",
    "yama_e"=> $this->checkEvening($customizedData->yama) ? str_replace($find, $replace,$customizedData->yama) : "", 
    "kuligai_m"=> $this->checkMorning($customizedData->kuligai) ? str_replace($find, $replace,$customizedData->kuligai) : "", 
    "kuligai_e"=> $this->checkEvening($customizedData->kuligai) ? str_replace($find, $replace, $customizedData->kuligai) : ""];

        return response()->json(['rasiDaily' => $rasiDaily, 'panchangam' => $panchangam, 'calendarDaily' => $calendarDaily, 'customData'=>$dataU]);
    }

    public function getMuhurthamDays(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        // $calendarDaily = CalendarDailyInfo::where('muhurtham', 'Y')
        //     ->whereMonth('created_date', $month)
        //     ->whereYear('created_date', $year)
        //     ->orderBy('created_date', 'asc')
        //     ->get();
         
    
         $calendarDaily = CalendarDailyInfo::where('muhurtham', 'Y')
            ->where('tmonth', $month)
            ->whereYear('created_date', $year)
            ->orderBy('created_date', 'asc')
            ->get();

            $assignment_details = \DB::table('calendar_daily_info')
            ->select(\DB::raw('group_concat(tdate) as tamildates'))
            ->where('muhurtham', 'Y')
            ->where('tmonth', $month)
            ->whereYear('created_date', $year)
            ->orderBy('created_date', 'asc')
            ->groupBy('tmonth')
            ->get();

            if(count($assignment_details) > 0){
                
            return response()->json(['data' => $calendarDaily, "tamildates" =>$assignment_details[0]->tamildates]);
            }
            return response()->json(['data' => $calendarDaily, "tamildates" => ""]);
        
    }


    

     public function getSpecialDays(Request $request)
    {
        $month = $request->month; //January to December
        if($month=="All"){
              $daysSpecial = SpecialDays::where('type', 'சிறப்பு நாள்')->orderByRaw(\DB::raw("FIELD(month, 'January','February','March','April','May','June','July','August','September','October','November','December')"))->orderBy('day_no','asc')->get();
              $daysBirthday = SpecialDays::where('type', 'பிறந்த நாள்')->orderByRaw(\DB::raw("FIELD(month, 'January','February','March','April','May','June','July','August','September','October','November','December')"))->orderBy('day_no','asc')->get();
              $daysInfo = SpecialDays::orderByRaw(\DB::raw("FIELD(month, 'January','February','March','April','May','June','July','August','September','October','November','December')"))->orderBy('day_no','asc')->get();
        }else {
            $daysInfo = SpecialDays::where("month", $month)->orderBy('day_no','asc')->get();
         $daysSpecial = SpecialDays::where("month", $month)->orderBy('day_no','asc')->get();
              $daysBirthday = SpecialDays::where("month", $month)->where('type', 'பிறந்த நாள்')->orderBy('day_no','asc')->get();
           
        }
       
        
        return response()->json(['dayList' => $daysInfo, 'சிறப்பு நாள்'=> $daysSpecial, 'பிறந்த நாள்' => $daysBirthday]);
    }


    

    public function getAdditionalDayTypes(Request $request)
    {
        $month = $request->month; //1 to 12 All
        $type = $request->type; //All , Astami, Navami. Dashami,Valarpirai,Theipirai
        $year =$request->year;
        if($month== 0){
            if($type == 0){
                $daysInfo = CalendarAdditional::whereYear('day_date', $year)->get();
            }else{
                 $daysInfo = CalendarAdditional::where('type', $type)->whereYear('day_date', $year)->get();
            }
            
        }else{
             if($type == 0){
                $daysInfo = CalendarAdditional::whereMonth('day_date', $month)->whereYear('day_date', $year)->get();
            }else{
                $daysInfo = CalendarAdditional::whereMonth('day_date', $month)->whereYear('day_date', $year)->where('type', $type)->get();
            }
             
        }
         return response()->json(['dayList' => $daysInfo]);

    }

     public function getAllinonebymonth(Request $request){


        $monthsSpecial = ["1" => "January", "2" => "February", "3"=>"March","4"=>"April","5"=> "May", "6"=> "June","7"=>"July",
          "8"=>"August","9"=>"September", "10"=> "October","11"=> "November","12"=>"December"];
 
        $monthsOthers = ["1" => "jan", "2" => "feb", "3"=>"mar","4"=>"apr","5"=> "may", "6"=> "jun","7"=>"Jul",
          "8"=>"aug","9"=>"sep", "10"=> "oct","11"=> "nov","12"=>"dec"];

          
        $month = $request->month; //1 to 12
        $year = $request->year;
        $religional = ["Hindu","Christian","Muslim"];
        //Ammavasi, Pournami //jan to dec
        $viradhaNatkal = ReligionFestival::whereNotIn('religiontype', $religional)
        ->where('month_name', $monthsOthers[$month])->where('year', $year)
        ->orderBy('day_no','asc')->get();
        //Hindu Christian Muslim //jan to dec
        $religionalInfo = ReligionFestival::whereIn('religiontype', $religional)
        ->where('month_name', $monthsOthers[$month])->where('year', $year)
        ->orderBy('day_no','asc')->get();
        
        $holidaysInfo = Holidays::whereMonth('holiday_date', $month)->where("year", $year)->get();
        
        
        //Astami, Navami. Dashami,Valarpirai,Theipirai 1 to 12
        $additonalDays = CalendarAdditional::whereIn('type', ["Astami", "Navami", "Dashami","Valarpirai","Theipirai"])
        ->whereMonth('day_date', $month)
        ->whereYear('day_date', $year)
        ->orderBy('day_date', 'asc')->get();
        
        //Days / Birthdays //January to December
        $specialDays = SpecialDays::where("month", $monthsSpecial[$month])->where('type', 'பிறந்த நாள்')->orderBy('day_no','asc')->get();


         $calendarDaily = CalendarDailyInfo::where('muhurtham', 'Y')
            ->whereYear('created_date', $year)
            ->whereMonth('created_date', $month)
            ->orderBy('created_date', 'asc')
            ->get();

            // $assignment_details = \DB::table('calendar_daily_info')
            // ->select(\DB::raw('group_concat(tdate) as tamildates'))
            // ->where('muhurtham', 'Y')
            //  ->whereMonth('created_date', $month)
            // ->whereYear('created_date', $year)
            // ->orderBy('created_date', 'asc')
            // ->groupBy('tmonth')
            // ->get();










     
         return response()->json(['விரத நாட்கல்' => $viradhaNatkal, "முகூர்த்த நாட்கள்" => $calendarDaily, 'அஸ்தமி நவமி'=> $additonalDays, 'மதங்கள்' => $religionalInfo, 'விடுமுறை' => $holidaysInfo,
         'சிறப்பு நாட்கள்' => $specialDays, 
        ]);
    
     }
    
     public function getDayTypes(Request $request)
    {
        $month = $request->month; //jan to dec
        $type = $request->type;
        //$religionName = $request->religion;
        $year = $request->year;

        $religional = ["Hindu","Christian","Muslim"];
        if($month=="All"){

            if($type == "Religion"){
                $daysInfo = ReligionFestival::whereIn('religiontype', $religional)->orderByRaw(\DB::raw("FIELD(month_name, 'jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec')"))->orderBy('day_no','asc')->get();
            }else if($type == "Other"){
                //echo "coming";exit;
                 $daysInfo = ReligionFestival::whereNotIn('religiontype', $religional)->orderByRaw(\DB::raw("FIELD(month_name, 'jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec')"))->orderBy('day_no','asc')->get();
            }
                else{
                 $daysInfo = ReligionFestival::where('religiontype', $type)->orderByRaw(\DB::raw("FIELD(month_name, 'jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec')"))->orderBy('day_no','asc')->get();
            }
            
        }else {
            if($type == "Religion"){
                 $daysInfo =ReligionFestival::whereIn('religiontype', $religional)->where('month_name', $month)->where('year', $year)->orderBy('day_no','asc')->get();
            }else if($type == "Other"){
                   $daysInfo =ReligionFestival::whereNotIn('religiontype', $religional)->where('month_name', $month)->where('year', $year)->orderBy('day_no','asc')->get();
   
            }else{
                 $daysInfo =ReligionFestival::where('religiontype', $type)->where('month_name', $month)->where('year', $year)->orderBy('day_no','asc')->get();
            }

           
        }
         $finalArr = [];
         if($type == "Religion"){
         foreach($daysInfo as $pobj) {
            if($pobj->religiontype == "Hindu"){
                $finalArr[$pobj->religiontype][] = $pobj;
            } else {

            }
        }

          foreach($daysInfo as $pobj) {
            if($pobj->religiontype == "Christian"){
                $finalArr[$pobj->religiontype][] = $pobj;
            }else if($pobj->religiontype == "Muslim"){
                $finalArr[$pobj->religiontype][] = $pobj;
            }else {

            }
        }}



        return response()->json(['dayList' => $daysInfo, 'religionByCategory'=> $finalArr]);
    }


     public function getHolidays(Request $request)
    {
        $year = $request->year;
        $month = $request->month;

        if($month != ""){
            if($month == "All"){
                $holidaysInfo = Holidays::where("year", $year)->get();
            }else{
                $holidaysInfo = Holidays::whereMonth('holiday_date', $month)->where("year", $year)->get();
            }
            
        }else{
            $holidaysInfo = Holidays::where("year", $year)->get();
        }
        
        
        
        return response()->json(['holidayList' => $holidaysInfo]);
    }

    public function getCalendarImages(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        if($month == "" || $month == "all"){
            $calendarImages = CalendarImages::where("year", $year)->get();
        }else{
            $calendarImages = CalendarImages::where("year", $year)->where("month", $month)->get();
        }
        
        
        return response()->json(['calendarImages' => $calendarImages]);
    }

    

    

}
