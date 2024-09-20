<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
class CalendarDailyInfo extends Model
{
    use HasFactory;
    protected $table = 'calendar_daily_info';
    protected $fillable = [
        'tmonth',
        'tyear',
        'tdate',
        'nneram_mrg',
        'nneram_eve',
        'gneram_mrg',
        'gneram_eve',
        'muhurtham',
        'festival_info',
        'day_auspicious',
        'day_inauspicioustime',
        'created_date',
        'thithiimages'
    ];

    
    protected $attributes = array(
        'EngText'=> '',
    );

    protected $appends= ['EngText'];


    
     public function getEngTextAttribute()
    {
        return Carbon::createFromTimeStamp(strtotime($this->created_date))->toFormattedDateString();  

    }
}
