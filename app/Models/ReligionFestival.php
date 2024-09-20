<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CalendarDailyInfo;

class ReligionFestival extends Model
{
    use HasFactory;

    protected $table = 'religionfestivals';

 protected $guarded = ['id'];   

     public $timestamps = false;
    protected $primaryKey = 'id';

protected $attributes = array(
        'ImgName' => '',
        'TamilEngText'=> '',
        'TamilText'=> '',
         'EngText'=> ''
    );

    protected $appends= ['ImgName', 'TamilEngText', 'TamilText', 'EngText'];


     

    public function getTamilEngTextAttribute()
    {
        $monthsToTamil = ["jan" => "ஜனவரி", "feb" => "பிப்ரவரி", "mar"=>"மார்ச்","apr"=>"ஏப்ரல்","may"=> "மே", "jun"=> "ஜூன்","jul"=>"ஜூலை",
          "aug"=>"ஆகஸ்ட்","sep"=>"செப்டம்பர்", "oct"=> "அக்டோபர்","nov"=> "நவம்பர்","dec"=>"டிசம்பர்"];

         $monthsInt = ["jan" => "1", "feb" => "2", "mar"=> "3","apr"=> "4","may"=> "5", "jun"=> "6","jul"=> "7",
          "aug"=> "8","sep"=> "9", "oct"=> "10","nov"=> "11","dec"=> "12"];

           
         
          $dateReq = $this->day_no."-".$monthsInt[strtolower($this->month_name)]."-".$this->year;
          $time = strtotime($dateReq);
          $newformat = date('Y-m-d',$time);
        $tamilInfo = CalendarDailyInfo::where('created_date', $newformat)->get();
          return $this->day_no."  ".$monthsToTamil[strtolower($this->month_name)].", ".$tamilInfo[0]->tdate."  ".$tamilInfo[0]->tmonth.", ".$this->tamil_day;
    }

    
    public function getEngTextAttribute()
    {
        $monthsToTamil = ["jan" => "ஜனவரி", "feb" => "பிப்ரவரி", "mar"=>"மார்ச்","apr"=>"ஏப்ரல்","may"=> "மே", "jun"=> "ஜூன்","jul"=>"ஜூலை",
          "aug"=>"ஆகஸ்ட்","sep"=>"செப்டம்பர்", "oct"=> "அக்டோபர்","nov"=> "நவம்பர்","dec"=>"டிசம்பர்"];
          return $this->day_no."  ".$monthsToTamil[strtolower($this->month_name)];
    }

    
    public function getTamilTextAttribute()
    {
             $monthsInt = ["jan" => "1", "feb" => "2", "mar"=> "3","apr"=> "4","may"=> "5", "jun"=> "6","jul"=> "7",
          "aug"=> "8","sep"=> "9", "oct"=> "10","nov"=> "11","dec"=> "12"];

           
         
          $dateReq = $this->day_no."-".$monthsInt[strtolower($this->month_name)]."-".$this->year;
          $time = strtotime($dateReq);
          $newformat = date('Y-m-d',$time);
        $tamilInfo = CalendarDailyInfo::where('created_date', $newformat)->get();
          return $tamilInfo[0]->tdate."  ".$tamilInfo[0]->tmonth;
    }

   
     public function getImgNameAttribute()
    {
        $imgName = "";
        if($this->religiontype == "Hindu"){
            $imgName = "hindu.png";
        }else  if($this->religiontype == "Muslim"){
            $imgName = "muslim.png";
        }else  if($this->religiontype == "Christian"){
            $imgName = "christian.png";
        }else  if($this->religiontype == "Ammavasai"){
            $imgName = "Ammavasai.png";
        }else  if($this->religiontype == "Pournami"){
            $imgName = "Pournami.png";
        }else  if($this->religiontype == "Maadha Sivarathiri"){
            $imgName = "MaadhaSivarathiri.png";
        }else  if($this->religiontype == "Shasti"){
            $imgName = "Shasti.png";
        }else  if($this->religiontype == "Sankatahara Chathurthi"){
            $imgName = "Schadhurthi.png";
        }else  if($this->religiontype == "Ekadhasi"){
            $imgName = "Ekadhasi.png";
        }else  if($this->religiontype == "Pradosham"){
            $imgName = "Pradosham.png";
        }else{

        }


         return url('images/calendar/'. $imgName);
    }


}
