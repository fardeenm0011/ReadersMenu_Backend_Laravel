<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CalendarAdditional extends Model
{
    use HasFactory;

    protected $table = 'calendar_additional_days';

 protected $guarded = ['id'];   

     public $timestamps = false;
    protected $primaryKey = 'id';


    protected $attributes = array(
        'ImgName' => '',
        'TamilEngText'=> '',
        'EngText'=>'',
    );

    protected $appends= ['ImgName', 'TamilEngText', 'EngText'];

    public function getImgNameAttribute()
    {
        $imgName = "";
        if($this->type == "Astami"){
            $imgName = "Astami.png";
        }else  if($this->type == "Navami"){
            $imgName = "Navami.png";
        }else  if($this->type == "Dashami"){
            $imgName = "Dashami.png";
        }else  if($this->type == "Valarpirai"){
            $imgName = "Valarpirai.png";
        }else  if($this->type == "Theipirai"){
            $imgName = "Theipirai.png";
        }
        return url('images/calendar/'. $imgName);
    }

     

     public function getEngTextAttribute()
    {
       return Carbon::createFromTimeStamp(strtotime($this->day_date))->toFormattedDateString();
    }



     public function getTamilEngTextAttribute()
    {
        $monthsToTamil = ["jan" => "ஜனவரி", "feb" => "பிப்ரவரி", "mar"=>"மார்ச்","apr"=>"ஏப்ரல்","may"=> "மே", "jun"=> "ஜூன்","jul"=>"ஜூலை",
          "aug"=>"ஆகஸ்ட்","sep"=>"செப்டம்பர்", "oct"=> "அக்டோபர்","nov"=> "நவம்பர்","dec"=>"டிசம்பர்"];

         $monthsInt = ["jan" => "1", "feb" => "2", "mar"=> "3","apr"=> "4","may"=> "5", "jun"=> "6","jul"=> "7",
          "aug"=> "8","sep"=> "9", "oct"=> "10","nov"=> "11","dec"=> "12"];

         $humanFormat = Carbon::createFromTimeStamp(strtotime($this->day_date))->toFormattedDateString();
         
        //   $dateReq = $this->day_no."-".$monthsInt[strtolower($this->month_name)]."-".$this->year;
        //   $time = strtotime($dateReq);
        //   $newformat = date('Y-m-d',$time);
        // $tamilInfo = CalendarDailyInfo::where('created_date', $newformat)->get();

          return $humanFormat.", ".$this->tamil_info.", ".$this->tamil_week_day;
    }


}
