<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanchangamDailyBreif extends Model
{
    use HasFactory;

    protected $table = 'panchangam_daily_breif';

 protected $guarded = ['id'];   

     public $timestamps = false;
    protected $primaryKey = 'id';

    
   


   protected $attributes = array(
        'CategoryName' => ''
    );

    protected $appends= ['CategoryName'];

     public function getCategoryNameAttribute()
    {
         $dailyInfo = ["திதி","பக்ஷம்","நக்ஷத்திரம்","கரணம்","கிழமை","யோகம்"];

        $dailySunMoon = ["சூரியோதயம்", "சூரிய அஸ்தமனம்","சந்திரன்ராசி","சந்திர உதயம்",
"சந்திர அஸ்தமனம்","சந்திரன்ராசி","ரிது"];

      $hinduMoon = ["சக வருஷம்","விக்ரமாதித்ய சகாப்தம்","காளி சம்வத்","பிரவிஷ்டே / கே","மாதம் பூர்ணிமாந்த","மாதம் அமாந்த","பகற்காலம்"];

     $mangalNeram = ["அபிஜித்"];

    $disai = ["திசை சூலம்"];

    $strength = ["தர பல", "சந்திர பல"];
        if(in_array($this->name, $dailyInfo)){
            return "இன்றைக்கு பஞ்சாங்கம்";
        } else if(in_array($this->name, $dailySunMoon)){
            return "சூரியன் மற்றும் சந்திரன் கணக்கீடுகள்";
        }else if(in_array($this->name, $hinduMoon)){
            return "இந்து சந்திர தேதி";
        }else if(in_array($this->name, $mangalNeram)){
            return "மங்கள நேரம்";
        }else if(in_array($this->name, $disai)){
            return "திஷ ஸூல";
        }else if(in_array($this->name, $strength)){
            return "சந்திரபலம் மற்றும் தரபலம்";
        }
        return "";
    }

 
}
