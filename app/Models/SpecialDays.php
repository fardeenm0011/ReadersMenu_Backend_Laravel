<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialDays extends Model
{
    use HasFactory;

    protected $table = 'specialdays';

 protected $guarded = ['id'];   

     public $timestamps = false;
    protected $primaryKey = 'id';

    protected $attributes = array(
        'TamilEngText'=> '',
        'LeaderName'=> '',
        'LeaderRole'=> '',
    );

    protected $appends= ['TamilEngText','LeaderName','LeaderRole'];


     public function getTamilEngTextAttribute()
    {
        $monthsToTamil = ["january" => "ஜனவரி", "february" => "பிப்ரவரி", "march"=>"மார்ச்","april"=>"ஏப்ரல்","may"=> "மே", "june"=> "ஜூன்","july"=>"ஜூலை",
          "august"=>"ஆகஸ்ட்","september"=>"செப்டம்பர்", "october"=> "அக்டோபர்","november"=> "நவம்பர்","december"=>"டிசம்பர்"];
        return $this->day_no."  ".$monthsToTamil[strtolower($this->month)];
           
         
        //   $dateReq = $this->day_no."-".$monthsInt[strtolower($this->month_name)]."-".$this->year;
        //   $time = strtotime($dateReq);
        //   $newformat = date('Y-m-d',$time);
        // $tamilInfo = CalendarDailyInfo::where('created_date', $newformat)->get();
          
    }

     public function getLeaderNameAttribute()
    {
        
        if($this->type == "பிறந்த நாள்"){
             $leaderName=  explode("-",$this->day_name);
           return $leaderName[0];
        }
        return $this->day_name;
         
        //   $dateReq = $this->day_no."-".$monthsInt[strtolower($this->month_name)]."-".$this->year;
        //   $time = strtotime($dateReq);
        //   $newformat = date('Y-m-d',$time);
        // $tamilInfo = CalendarDailyInfo::where('created_date', $newformat)->get();
          
    }

    public function getLeaderRoleAttribute()
    {
        if($this->type == "பிறந்த நாள்"){
         $leaderName=  explode("-",$this->day_name);
           return $leaderName[1];
        }
        return "";
          
    }


   


}
